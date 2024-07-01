<?php

//alert add post 2
if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-success" role="alert">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
}

if (isset($_POST['create_post'])) {
    $post_title = mysqli_real_escape_string($connection, $_POST['title']);

    $post_author = mysqli_real_escape_string($connection, $_POST['author']);

    $post_category_id = mysqli_real_escape_string($connection,  $_POST['post_category_id']);

    $post_status = mysqli_real_escape_string($connection, $_POST['post_status']);

    $post_image = mysqli_real_escape_string($connection, $_FILES['image']['name']);
    $post_image_temp = $_FILES['image']['tmp_name'];

    $post_tags = mysqli_real_escape_string($connection, $_POST['post_tags']);
    $post_content = mysqli_real_escape_string($connection, $_POST['post_content']);
    $post_date = date('d-m-y');
    $post_comment_count = 0;

    move_uploaded_file($post_image_temp, "../images/$post_image");

    $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_comment_count, post_status) VALUES ($post_category_id, '$post_title', '$post_author', now(), '$post_image', '$post_content', '$post_tags', '$post_comment_count', '$post_status')";
    $create_post_query = mysqli_query($connection, $query);

    //alert add post 1
    if ($create_post_query) {
        $_SESSION['message'] = 'Your post has been added!';
        header('Location: posts.php?source=add_post');
        exit();
    } else {
        die('QUERY FAILED' . mysqli_error($connection));
    }
}
?>



<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post title</label>
        <input type="text" class="form-control" name="title" id="title" required>
    </div>
    <div class="form-group">
        <label for="post_category">Post category</label><br>
        <select name="post_category_id" id="post_category">
            <?php
            $query = "SELECT * FROM categories";
            $select_categories = mysqli_query($connection, $query);

            confirm($select_categories);

            while ($row = mysqli_fetch_assoc($select_categories)) {
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
            $query = "SELECT * FROM users";
            $select_categories = mysqli_query($connection, $query);

            confirm($select_categories);

            while ($row = mysqli_fetch_assoc($select_categories)) {
                $user_id = $row['user_id'];
                $username = $row['username'];

                echo "<option value='$username'>$username</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="status">Post Status</label><br>
        <select name="post_status" id="status">
            <option value="draft">draft</option>
            <option value="published">published</option>
        </select>
    </div>
    <div class="form-group">
        <label for="image">Post Image</label>
        <input type="file" class="form-control" name="image" id="image" required>
    </div>
    <div class="form-group">
        <label for="tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" id="tags" required>
    </div>
    <div class="form-group">
        <label for="summernote">Post Content</label>
        <textarea type="text" class="form-control" name="post_content" cols="30" rows="10" id="summernote" required></textarea>
    </div>
    <div class="form-group">
        <input type="submit" value="Submit" name="create_post" class="btn btn-primary">
    </div>
</form>