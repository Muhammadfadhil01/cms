<?php include "includes/admin_header.php"; ?>

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

                    //alert user 2
                    if (isset($_SESSION['message'])) {
                        echo '<div class="alert alert-success" role="alert">' . $_SESSION['message'] . '</div>';
                        unset($_SESSION['message']);
                    }
                    ?>

                    <?php
                    if (isset($_GET['source'])) {
                        $source = mysqli_real_escape_string($connection, $_GET['source']);
                    } else {
                        $source = '';
                    }

                    switch ($source) {
                        case 'add_user':
                            include "includes/admin_add_users.php";
                            break;

                        case 'edit_user':

                            // Validasi edit_user agar hanya mengandung integer
                            if (isset($_GET['edit_user']) && filter_var($_GET['edit_user'], FILTER_VALIDATE_INT)) {
                                $the_user_id = mysqli_real_escape_string($connection, $_GET['edit_user']);

                                $query = "SELECT * FROM users WHERE user_id = $the_user_id";
                                $select_users_query = mysqli_query($connection, $query);

                                // Langsung ke halaman users.php jika user ID tidak ditemukan
                                if (mysqli_num_rows($select_users_query) == 0) {
                                    header("Location: users.php");
                                    exit;
                                }

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
                            } else {
                                // Redirect ke users.php jika parameter edit_user tidak valid
                                header("Location: users.php");
                                exit;
                            }
                            include "includes/admin_edit_users.php";
                            break;

                        default:
                            include "includes/admin_view_all_users.php";
                            break;
                    }
                    ?>


                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>


    <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php" ?>