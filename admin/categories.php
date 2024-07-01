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


                    //alert categories 2
                    if (isset($_SESSION['message'])) {
                        echo '<div class="alert alert-success" role="alert">' . $_SESSION['message'] . '</div>';
                        unset($_SESSION['message']);
                    }

                    ?>
                    <div class="col-xs-6">

                        <!-- insert categories query -->
                        <?php include "includes/admin_insert_categories_form.php" ?>

                    </div>

                    <div class="col-xs-6">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Category Title</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <!-- find select all categories query -->
                                    <?php findAllCategories(); ?>

                                    <!-- delete categories query -->
                                    <?php deleteCategories(); ?>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>


    <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php" ?>