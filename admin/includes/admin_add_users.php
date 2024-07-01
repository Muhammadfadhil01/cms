<?php

//alert add user 2
if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-success" role="alert">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
}



if (isset($_POST['create_user'])) {
    //$user_id = $_POST['user_id'];
    $user_firstname = mysqli_real_escape_string($connection, $_POST['user_firstname']);
    $user_lastname = mysqli_real_escape_string($connection,  $_POST['user_lastname']);
    $user_role = mysqli_real_escape_string($connection, $_POST['user_role']);

    // $post_image = $_FILES['image']['name'];
    // $post_image_temp = $_FILES['image']['tmp_name'];

    $username = mysqli_real_escape_string($connection,  $_POST['username']);
    $user_email = mysqli_real_escape_string($connection, $_POST['user_email']);
    $user_password = mysqli_real_escape_string($connection, $_POST['user_password']);

    //validasi jika di database ada username yang sama
    $query = "SELECT username FROM users WHERE username = '$username'";
    $select_validate_user = mysqli_query($connection, $query);

    //validasi jika di database ada email yang sama
    $query = "SELECT user_email FROM users WHERE user_email = '$user_email'";
    $select_validate_email = mysqli_query($connection, $query);

    //validasi execute 
    if (mysqli_num_rows($select_validate_user) > 0) {
            echo "<div class='alert alert-danger' role='alert'>Username already in use!</div>";
    } elseif (mysqli_num_rows($select_validate_email) > 0) {
            echo "<div class='alert alert-danger' role='alert'>Email already in use!</div>";
    } else {

        //password hash
        $user_password = password_hash($user_password, PASSWORD_BCRYPT);

        //$post_date = date('d-m-y');
        //$post_comment_count = 0;

        // move_uploaded_file($post_image_temp, "../images/$post_image");

        $query = "INSERT INTO users(user_firstname, user_lastname, user_role, username, user_email, user_password) VALUES ('$user_firstname', '$user_lastname', '$user_role', '$username', '$user_email', '$user_password')";
        $create_user_query = mysqli_query($connection, $query);

        //alert add user 1
        if ($create_user_query) {
            $_SESSION['message'] = 'User has been added!';
            header('Location: users.php?source=add_user');
            exit();
        } else {
            die('QUERY FAILED' . mysqli_error($connection));
        }
    }
}
?>


<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="firstname">First name</label>
        <input type="text" class="form-control" name="user_firstname" minlength="3" id="firstname" required>
    </div>
    <div class="form-group">
        <label for="lastname">Last name</label>
        <input type="text" class="form-control" name="user_lastname" minlength="3" id="lastname" required>
    </div>


    <div class="form-group">
        <select name="user_role" id="">
            <option value="user">Select option</option>
            <option value="admin">admin</option>
            <option value="user">user</option>
        </select>
    </div>

    <!-- <div class="form-group">
        <label for="status">Post Status</label><br>
        <select name="post_status" id="status">
            <option value="draft">draft</option>
            <option value="published">published</option>
        </select>
    </div> -->

    <!-- <div class="form-group">
        <label for="image">Post Image</label>
        <input type="file" class="form-control" name="image" id="image" required>
    </div> -->

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username" minlength="4" id="username" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="user_email" id="email" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="user_password" minlength="8" id="password" required>
    </div>
    <div class="form-group">
        <input type="submit" value="Submit" name="create_user" class="btn btn-primary">
    </div>
</form>