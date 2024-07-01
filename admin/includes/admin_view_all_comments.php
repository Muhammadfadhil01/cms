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

                //switch delete option
            case 'delete':
                $query = "DELETE FROM comments WHERE comment_id = $postValueId";
                $delete_query = mysqli_query($connection, $query);

                //kurangin comment count
                $query =    "UPDATE posts SET post_comment_count = post_comment_count - $postValueId WHERE post_id = $postValueId";
                $delete_post_comment_count_query = mysqli_query($connection, $query);

                if (!$delete_post_comment_count_query) {
                    die('QUERY FAILED' . mysqli_error($connection));
                }


                //alert
                confirm($delete_post_comment_count_query);
                break;


                //switch approve option
            case 'approve':

                $query = "UPDATE comments SET comment_status = 'Approve' WHERE comment_id = $postValueId";
                $approve_query = mysqli_query($connection, $query);

                if ($approve_query) {
                    header("location:comments.php");
                } else {
                    die("QUERY FAILED");
                }

                //alert
                confirm($approve_query);
                break;

                //switch unapprove option
            case 'unapprove':

                $query = "UPDATE comments SET comment_status = 'Unapprove' WHERE comment_id = $postValueId";
                $unapprove_query = mysqli_query($connection, $query);

                if ($unapprove_query) {
                    header("location:comments.php");
                } else {
                    die("QUERY FAILED");
                }

                //alert
                confirm($unapprove_query);
                break;
        }
    }
}

?>

<div class="table-responsive">
    <form action="" method="post">
        <table class="table table-bordered table-hover">

            <table class="table table-bordered table-hover">
                <div id="bulkOptionContainer" class="col-xs-4">
                    <select name="bulk_options" id="" class="form-control">
                        <option value="">Select options</option>
                        <option value="approve">Approve</option>
                        <option value="unapprove">Unapprove</option>
                        <option value="delete">Delete</option>
                    </select>

                </div>
                <div id="bulkOptionContainer" class="col-xs-4">
                    <input type="submit" value="Apply" name="submit" class="btn btn-success">
                </div>
                <br>
                <br>
                <thead>
                    <tr>
                        <th><input type="checkbox" name="" id="selectAllboxes"></th>
                        <th>Id</th>
                        <th>Author</th>
                        <th>Comment</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>In response to</th>
                        <th>Date</th>
                        <th>Approve</th>
                        <th>Unapprove</th>
                        <th>Delete</th>
                    </tr>
                </thead>



                <tbody>

                    <?php
                    $query = "SELECT * FROM comments ORDER BY comment_post_id DESC";
                    $select_comments = mysqli_query($connection, $query);
                    $i = 1;
                    while ($row = mysqli_fetch_assoc($select_comments)) {
                        $comment_id = $row["comment_id"];
                        $comment_post_id = $row['comment_post_id'];
                        $comment_author = $row['comment_author'];
                        $comment_content = $row['comment_content'];
                        $comment_email = $row['comment_email'];
                        $comment_status = $row['comment_status'];
                        $comment_date = $row['comment_date'];

                        echo "<tr>";

                    ?>

                        <td><input type='checkbox' class='checkboxes' id='selectAllboxes' name='checkBoxArray[]' value='<?php echo $comment_id ?>'></td>

                    <?php


                        echo "<td>$i</td>";
                        echo "<td>$comment_author</td>";
                        echo "<td>$comment_content</td>";



                        // $query = "SELECT * FROM categories WHERE cat_id = $post_category_id";
                        // $select_categories = mysqli_query($connection, $query);
                        // while ($row = mysqli_fetch_assoc($select_categories)) {

                        //     $cat_id = $row["cat_id"];
                        //     $cat_title = $row['cat_title'];

                        //     echo "<td>$cat_title</td>";
                        // }

                        echo "<td>$comment_email</td>";
                        echo "<td>$comment_status</td>";

                        $query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
                        $select_post_id_query = mysqli_query($connection, $query);
                        while ($row = mysqli_fetch_assoc($select_post_id_query)) {
                            $post_id = htmlspecialchars($row['post_id']);
                            $post_title = htmlspecialchars($row['post_title']);
                            echo "<td><a href='../post/$post_id'>$post_title</a></td>";
                        }

                        echo "<td>$comment_date</td>";

                        echo "<td><a href='comments.php?approve=$comment_id'>Approve</a></td>";
                        echo "<td><a href='comments.php?unapprove=$comment_id'>Unapprove</a></td>";
                        echo "<td><a href='comments.php?delete=$comment_id' onclick=\"return confirm('Are you sure you want to delete??')\">Delete</a></td>";
                        echo "</tr>";
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
            <?php

            //approve
            if (isset($_GET['approve'])) {
                $the_comment_id = mysqli_real_escape_string($connection, $_GET['approve']);
                $query = "UPDATE comments SET comment_status = 'Approve' WHERE comment_id = $the_comment_id";
                $approve_query = mysqli_query($connection, $query);
                if ($approve_query) {
                    header("location:comments.php");
                } else {
                    die("QUERY FAILED");
                }
            }

            //unapprove
            if (isset($_GET['unapprove'])) {
                $the_comment_id = mysqli_real_escape_string($connection, $_GET['unapprove']);
                $query = "UPDATE comments SET comment_status = 'Unapprove' WHERE comment_id = $the_comment_id";
                $unapprove_query = mysqli_query($connection, $query);
                if ($unapprove_query) {
                    header("location:comments.php");
                } else {
                    die("QUERY FAILED");
                }
            }


            if (isset($_SESSION['user_role'])) {
                if ($_SESSION['user_role'] == 'admin') {
                    if (isset($_GET['delete'])) {
                        $the_comment_id = mysqli_real_escape_string($connection, $_GET['delete']);
                        $query = "DELETE FROM comments WHERE comment_id = $the_comment_id";
                        $delete_query = mysqli_query($connection, $query);

                        //kurangin comment count
                        $query =    "UPDATE posts SET post_comment_count = post_comment_count - 1 WHERE post_id = $comment_post_id";
                        $delete_post_comment_count_query = mysqli_query($connection, $query);

                        if (!$delete_post_comment_count_query) {
                            die('QUERY FAILED' . mysqli_error($connection));
                        }

                        //alert delete comment 1
                        if ($delete_query) {
                            $_SESSION['message'] = 'Your comment has been deleted!';
                            header('Location: comments.php');
                            exit();
                        } else {
                            die('QUERY FAILED' . mysqli_error($connection));
                        }
                    }
                }
            }
            ?>

        </table>
    </form>
</div>