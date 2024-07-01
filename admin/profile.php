<?php include "includes/admin_header.php"; ?>


<?php

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $query = "SELECT * FROM users WHERE username = '$username'";

    $select_user_profile_query = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_array($select_user_profile_query)) {
        $user_id = $row["user_id"];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
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

    $user_id2 = mysqli_real_escape_string($connection, $_SESSION['user_id']);

    //password hash
    $user_password = password_hash($user_password, PASSWORD_BCRYPT);

    $query = "UPDATE users SET 
             user_firstname = '$user_firstname',
             user_lastname = '$user_lastname',
             user_role = '$user_role',
             username = '$username',
             user_email = '$user_email',
             user_password = '$user_password' WHERE user_id = '$user_id2'
             ";

    $edit_user_query = mysqli_query($connection, $query);

    //alert update profile/user 1
    if ($edit_user_query) {


    } else {
        die('QUERY FAILED' . mysqli_error($connection));
    }
}

?>

?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_nav.php" ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to admin!
                        <small>Author</small>
                    </h1>

                    <?php

                    //alert add post 2
                    if (isset($_SESSION['message'])) {
                        echo '<div class="alert alert-success" role="alert">' . $_SESSION['message'] . '</div>';
                        unset($_SESSION['message']);
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

                        <!-- user/admin -->
                        <div class="form-group">
                            <select name="user_role" id="">
                                <option value="<?php echo $user_role ?>"><?php echo $user_role ?></option>
                                <?php
                                if ($user_role == 'admin') {
                                    echo "<option value='user'>user</option>";
                                } elseif ($user_role == 'user') {
                                    echo "<option value='admin'>admin</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" id="username" minlength="4" value="<?php echo $username ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="user_email" id="email" value="<?php echo $user_email ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="user_password" id="password" minlength="8" value="<?php //echo $user_password 
                                                                                                                                ?>" placeholder="Enter new password" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Update profile" name="edit_user" class="btn btn-primary">
                        </div>
                    </form>

                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>


    <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php" ?>