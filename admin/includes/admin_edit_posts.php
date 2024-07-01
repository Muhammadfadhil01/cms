<?php


//alert add post 2
if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-success" role="alert">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
}

if (isset($_GET['p_id'])) {

    //jika page tidak sesuai, maka balik ke page awal
    $the_post_id = $_GET['p_id'];
    if (!is_numeric($the_post_id) || $the_post_id <= 0) {
        header('location:posts.php');
    }

    $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
    $select_posts_by_id = mysqli_query($connection, $query);

    //jika query tidak ada maka balik ke page awal
    if (mysqli_num_rows($select_posts_by_id) == 0) {
        header('location:posts.php');
    }
    while ($row = mysqli_fetch_assoc($select_posts_by_id)) {
        $post_id = $row["post_id"];
        $post_author = $row['post_author'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_content = $row['post_content'];
        $post_comment_count = $row['post_comment_count'];
        $post_date = $row['post_date'];

        if (isset($_POST['update_post'])) {
            $post_title = $_POST['title'];
            $post_author = $_POST['author'];
            $post_category_id = $_POST['post_category'];
            $post_status = $_POST['post_status'];

            $post_image = $_FILES['image']['name'];
            $post_image_temp = $_FILES['image']['tmp_name'];

            $post_tags = $_POST['post_tags'];
            $post_content = $_POST['post_content'];

            move_uploaded_file($post_image_temp, "../images/$post_image");

            if (empty($post_image)) {
                $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
                $select_image = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_array($select_image)) {
                    $post_image = $row['post_image'];
                }
            }

            $query = "UPDATE posts SET post_title = '$post_title',
             post_author = '$post_author',
              post_category_id = '$post_category_id',
               post_date = now(),
                post_status = '$post_status',
                 post_tags = '$post_tags',
                   post_content = '$post_content',
                    post_image = '$post_image' WHERE post_id = $post_id";

            $update_query = mysqli_query($connection, $query);

            //alert add post 1
            if ($update_query) {
                $_SESSION['message'] = 'Your post has been updated!';
                header("Location: posts.php?source=edit_post&p_id=$the_post_id");
                exit();
            } else {
                die('QUERY FAILED' . mysqli_error($connection));
            }
        }
    }
?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Post title</label>
            <input type="text" class="form-control" name="title" id="title" value="<?php echo $post_title ?>" required>
        </div>
        <div class="form-group">
            <label for="post_category">Post category</label><br>
            <select name="post_category" id="post_category">
                <?php
                
                // seleksi agar option tidak double
                $query = "SELECT * FROM categories WHERE cat_id = $post_category_id";
                $query2 = "SELECT * FROM categories WHERE cat_id != $post_category_id";
                $select_categories = mysqli_query($connection, $query);
                $select_categories2 = mysqli_query($connection, $query2);

                confirm($select_categories);

                while ($row = mysqli_fetch_assoc($select_categories)) {
                    $cat_id = $row["cat_id"];
                    $cat_title = $row['cat_title'];
                    echo "<option value='$cat_id'>$cat_title</option>";
                }

                while ($row = mysqli_fetch_assoc($select_categories2)) {
                    $cat_id = $row["cat_id"];
                    $cat_title = $row['cat_title'];
                    echo "<option value='$cat_id'>$cat_title</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="post_author">Author</label><br>
            <select name="author" id="post_author">
                <?php

                
                // seleksi agar option tidak double
                $query = "SELECT * FROM users WHERE username = '$post_author'";
                $query2 = "SELECT * FROM users WHERE username != '$post_author'";
                
                $select_categories = mysqli_query($connection, $query);
                $select_categories2 = mysqli_query($connection, $query2);

                confirm($select_categories);

                while ($row = mysqli_fetch_assoc($select_categories)) {
                    $user_id = $row['user_id'];
                    $username = $row['username'];

                    echo "<option value='$username'>$username</option>";
                }

                while ($row = mysqli_fetch_assoc($select_categories2)) {
                    $user_id = $row['user_id'];
                    $username = $row['username'];

                    echo "<option value='$username'>$username</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="post_status">Post status</label><br>
            <select name="post_status" id="post_status">
                <option value="<?php echo $post_status ?>"><?php echo $post_status ?></option>
                <?php
                if ($post_status == 'published') {
                    echo "<option value='draft'>draft</option>";
                } elseif ($post_status == 'draft') {
                    echo "<option value='published'>published</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <img width="100" src="../images/<?php echo $post_image; ?>" alt="" srcset="" name="post_image"><br><br>
            <input type="file" name="image" id="">
        </div>
        <div class="form-group">
            <label for="tags">Post Tags</label>
            <input type="text" class="form-control" name="post_tags" id="tags" value="<?php echo $post_tags ?>" required>
        </div>
        <div class="form-group">
            <label for="content">Post Content</label>
            <textarea type="text" class="form-control" name="post_content" cols="30" rows="10" id="summernote2" required><?php echo $post_content ?></textarea>
        </div>
        <div class="form-group">
            <input type="submit" value="Submit" name="update_post" class="btn btn-primary" required>
        </div>
    </form>

<?php } ?>