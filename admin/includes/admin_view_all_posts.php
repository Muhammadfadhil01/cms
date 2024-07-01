<?php

//alert add post 2
if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-success" role="alert">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
}

//bulk options
if (isset($_POST['checkBoxArray'])) {

    $bulk_options = $_POST['bulk_options'];

    foreach ($_POST['checkBoxArray'] as $postValueId) {
        switch ($bulk_options) {

                //apply bulk option

                //switch publish option 
            case 'published':
                $query = "UPDATE posts SET post_status = '$bulk_options' WHERE post_id = '$postValueId'";
                $update_to_published_status = mysqli_query($connection, $query);

                //alert
                if ($update_to_published_status) {
                } else {
                    die('QUERY FAILED' . mysqli_error($connection));
                }

                confirm($update_to_published_status);
                break;

                //switch draft option
            case 'draft':
                $query = "UPDATE posts SET post_status = '$bulk_options' WHERE post_id = '$postValueId'";
                $update_to_draft_status = mysqli_query($connection, $query);


                confirm($update_to_draft_status);
                break;

                //switch delete option
            case 'delete':
                $query = "DELETE FROM posts WHERE post_id = '$postValueId'";
                $update_to_delete_status = mysqli_query($connection, $query);

                $query = "DELETE FROM comments WHERE comment_post_id = $postValueId";
                $delete_comment_query = mysqli_query($connection, $query);


                confirm($update_to_delete_status);
                break;

                //switch clone option
            case 'clone':
                $query = "SELECT * FROM posts WHERE post_id = '$postValueId'";
                $select_posts_query = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_posts_query)) {
                    // $post_id = $row['post_id'];
                    $post_author = $row['post_author'];
                    $post_title = $row['post_title'];
                    $post_category_id = $row['post_category_id'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_comment_count = $row['post_comment_count'];
                    $post_date = $row['post_date'];
                    $post_content = $row['post_content'];
                }

                $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_comment_count, post_status) VALUES ($post_category_id, '$post_title', '$post_author', now(), '$post_image', '$post_content', '$post_tags', 0, '$post_status')";
                $clone_query = mysqli_query($connection, $query);



                confirm($clone_query);
                break;

                //switch reset view option
            case 'reset':
                $query = "UPDATE posts SET post_view_count = 0 WHERE post_id = $postValueId";
                $reset_view_query = mysqli_query($connection, $query);


                confirm($reset_view_query);
                break;
        }
    }
}

?>

<div class="table-responsive">

    <form action="" method="post">
        <table class="table table-bordered table-hover">
            <div id="bulkOptionContainer" class="col-xs-4">

                <select name="bulk_options" id="" class="form-control">
                    <option value="">Select options</option>
                    <option value="published">Publish</option>
                    <option value="draft">Draft</option>
                    <option value="clone">Clone</option>
                    <option value="reset">Reset visited history</option>
                    <option value="delete">Delete</option>
                </select>

            </div>
            <div id="bulkOptionContainer" class="col-xs-4">
                <input type="submit" value="Apply" name="submit" class="btn btn-success">
                <a href="posts.php?source=add_post" class="btn btn-primary">Add new</a>
            </div>
            <br>
            <br>
            <thead>
                <tr>
                    <th><input type="checkbox" name="" id="selectAllboxes"></th>
                    <th>Id</th>
                    <th>Author</th>
                    <th>Title</th>
                    <th>category</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th>Tags</th>
                    <th>Comments</th>
                    <th>Date</th>
                    <th>View</th>
                    <th>Visited</th>
                    <th>Action</th>
                </tr>
            </thead>



            <tbody>

                <?php
                $query = "SELECT * FROM posts ORDER BY post_id DESC";
                $select_posts = mysqli_query($connection, $query);
                $i = 1;
                while ($row = mysqli_fetch_assoc($select_posts)) {
                    $post_id = $row["post_id"];
                    $post_author = htmlspecialchars($row['post_author']);
                    $post_title = htmlspecialchars($row['post_title']);
                    $post_category_id = htmlspecialchars($row['post_category_id']);
                    $post_status = htmlspecialchars($row['post_status']);
                    $post_image = htmlspecialchars($row['post_image']);
                    $post_tags = htmlspecialchars($row['post_tags']);
                    $post_comment_count = htmlspecialchars($row['post_comment_count']);
                    $post_date = htmlspecialchars($row['post_date']);
                    $post_view_count = htmlspecialchars($row['post_view_count']);

                    echo "<tr>";

                ?>

                    <td><input type='checkbox' class='checkboxes' id='selectAllboxes' name='checkBoxArray[]' value='<?php echo $post_id ?>'></td>

                <?php
                    echo "<td>$i</td>";
                    echo "<td>$post_author</td>";
                    echo "<td>$post_title</td>";



                    $query = "SELECT * FROM categories WHERE cat_id = $post_category_id";
                    $select_categories = mysqli_query($connection, $query);
                    while ($row = mysqli_fetch_assoc($select_categories)) {

                        $cat_id = htmlspecialchars($row["cat_id"]);
                        $cat_title = htmlspecialchars($row['cat_title']);

                        echo "<td>$cat_title</td>";

                        
                    }

                    // jika category hilang, maka tetap akan ada td (dengan catatan empty field)
                    if(mysqli_num_rows($select_categories) == 0){
                        echo "<td>empty field</td>";
                    }


                    echo "<td>$post_status</td>";
                    echo "<td><img src='../images/$post_image' width='100' alt='image'></td>";
                    echo "<td>$post_tags</td>";
                    echo "<td>$post_comment_count</td>";
                    echo "<td>$post_date</td>";
                    echo "<td><a href='../post/$post_id'>View</a></td>";
                    echo "<td>$post_view_count</td>";
                    echo "<td> <a href='posts.php?source=edit_post&p_id=$post_id'>Edit</a> | <a href='posts.php?delete=$post_id' onclick=\"return confirm('Are you sure you want to delete??')\">Delete</a></td>";
                    echo "</tr>";
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </form>


    <?php
    if (isset($_SESSION['user_role'])) {
        if ($_SESSION['user_role'] == 'admin') {
            if (isset($_GET['delete'])) {
                $the_post_id = mysqli_real_escape_string($connection, $_GET['delete']);
                $query = "DELETE FROM posts WHERE post_id = $the_post_id";
                $delete_query = mysqli_query($connection, $query);

                $query = "DELETE FROM comments WHERE comment_post_id = $the_post_id";
                $delete_comment_query = mysqli_query($connection, $query);

                if ($delete_query) {
                    //delete semua comments dari post yang sudah dihapus

                    //alert delete post 1
                    if ($delete_query) {
                        $_SESSION['message'] = 'Your post has been deleted!';
                        header('Location: posts.php');
                        exit();
                    } else {
                        die('QUERY FAILED' . mysqli_error($connection));
                    }

                    if (!$delete_comment_query) {
                        die("QUERY FAILED" . mysqli_error($connection));
                    }
                } else {
                    die("QUERY FAILED" . mysqli_error($connection));
                }
            }
        }
    }
    ?>
</div>