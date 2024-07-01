<?php

if (isset($_GET['edit_user'])) {
    $the_user_id = mysqli_real_escape_string($connection, $_GET['edit_user']);

    $query = "SELECT * FROM users WHERE user_id = $the_user_id";
    $select_users_query = mysqli_query($connection, $query);
    $i = 1;
    while ($row = mysqli_fetch_assoc($select_users_query)) {
        $user_id = $row["user_id"];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
    }
}
if (isset($_POST['edit_user'])) {
    //$user_id = $_POST['user_id'];
    $user_firstname = mysqli_real_escape_string($connection, $_POST['user_firstname']);
    $user_lastname = mysqli_real_escape_string($connection, $_POST['user_lastname']);
    $user_role = mysqli_real_escape_string($connection, $_POST['user_role']);

    // $post_image = $_FILES['image']['name'];
    // $post_image_temp = $_FILES['image']['tmp_name'];

    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $user_email = mysqli_real_escape_string($connection, $_POST['user_email']);
    $user_password = mysqli_real_escape_string($connection, $_POST['user_password']);

    //$post_date = date('d-m-y');
    //$post_comment_count = 0;

    // move_uploaded_file($post_image_temp, "../images/$post_image");

    //password hash
    $user_password = password_hash($user_password, PASSWORD_BCRYPT);

    $query = "UPDATE users SET 
             user_firstname = '$user_firstname',
             user_lastname = '$user_lastname',
             user_role = '$user_role',
             username = '$username',
             user_email = '$user_email',
             user_password = '$user_password'
             WHERE user_id = $the_user_id";

    $edit_user_query = mysqli_query($connection, $query);

    //alert add post 1
    if ($edit_user_query) {
        $_SESSION['message'] = 'User has been updated!';
        header("Location: users.php?source=edit_user&edit_user=$the_user_id");
        exit();
    } else {
        die('QUERY FAILED' . mysqli_error($connection));
    }
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="firstname">First name</label>
        <input type="text" class="form-control" name="user_firstname" id="firstname" minlength="3" value="<?php echo $user_firstname ?>" required>
    </div>
    <div class="form-group">
        <label for="lastname">Last name</label>
        <input type="text" class="form-control" name="user_lastname" id="lastname" minlength="3" value="<?php echo $user_lastname ?>" required>
    </div>


    <div class="form-group">
        <select name="user_role" id="">
            <?php
            if ($user_role == 'admin') {
                echo "<option value='admin'>admin</option>";
                echo "<option value='user'>user</option>";
            } elseif ($user_role == 'user') {
                echo "<option value='user'>user</option>";
                echo "<option value='admin'>admin</option>";
            }
            ?>
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
        <input type="text" class="form-control" name="username" id="username" minlength="4" value="<?php echo $username; ?>" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="user_email" id="email" value="<?php echo $user_email; ?>" required>
    </div>
    <div class="form-group">
        <label for="password">New password</label>
        <input type="password" autocomplete="off" class="form-control" name="user_password" id="password" minlength="8" value="" placeholder="Enter new password" required>
    </div>
    <div class="form-group">
        <input type="submit" value="Submit" name="edit_user" class="btn btn-primary">
    </div>
</form>