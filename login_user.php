<?php include "includes/login.php" ?>
<?php include "includes/header.php"; ?>
<?php include "includes/nav.php"; ?>

<!-- Page Content -->
<div class="container">

    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="form-wrap">
                        <h1>Login</h1>
                        <form role="form" action="" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <label for="username" class="sr-only">username</label>
                                <input type="text" name="username" id="username" minlength="4" class="form-control" placeholder="Enter your username" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" minlength="8" class="form-control" placeholder="Password" required>
                            </div>

                            <input type="submit" name="login" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Login">
                        </form>
                        <br>
                        <p>Don't have an account? <a href="registration.php">Sign up</a></p>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>



    <?php include "includes/footer.php"; ?>