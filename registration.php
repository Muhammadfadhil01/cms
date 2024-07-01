<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<?php

// insert query
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];
    $user_role = 'user';

    $username = mysqli_real_escape_string($connection, $username);
    $user_email = mysqli_real_escape_string($connection, $user_email);
    $user_password = mysqli_real_escape_string($connection, $user_password);

    // validasi jika di database ada username yang sama
    $query = "SELECT username FROM users WHERE username = '$username'";
    $select_validate_user = mysqli_query($connection, $query);

    // validasi jika di database ada email yang sama
    $query = "SELECT user_email FROM users WHERE user_email = '$user_email'";
    $select_validate_email = mysqli_query($connection, $query);

    // validasi execute
    if (mysqli_num_rows($select_validate_user) > 0) {
        echo "<div class='alert alert-danger' role='alert'>
              Username already in use!
              </div>";
    } elseif (mysqli_num_rows($select_validate_email) > 0) {
        echo "<div class='alert alert-danger' role='alert'>
              Email already registered!
              </div>";
    } else {

        // password hash
        $user_password = password_hash($user_password, PASSWORD_BCRYPT);

        $query = "INSERT INTO users(username, user_email, user_password, user_role) VALUES ('$username', '$user_email', '$user_password', '$user_role')";
        $create_user_query = mysqli_query($connection, $query);

        //alert
        if ($create_user_query) {

            echo '<div class="alert alert-success" role="alert">
            Your registration has been submitted!
            </div>';
        } else {
            die('QUERY FAILED' . mysqli_error($connection));
        }
    }
}

?>

<!-- Navigation -->
<?php include "includes/nav.php"; ?>


<!-- Page Content -->
<div class="container">

    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="form-wrap">
                        <h1>Register</h1>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <label for="username" class="sr-only">username</label>
                                <input type="text" name="username" id="username" minlength="4" class="form-control" placeholder="Enter your username" required>
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" minlength="8" class="form-control" placeholder="Password" required>
                            </div>

                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                        </form>
                        <br>
                        <p>Already have an account? <a href="login_user">Sign in</a></p>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>



    <?php include "includes/footer.php"; ?>