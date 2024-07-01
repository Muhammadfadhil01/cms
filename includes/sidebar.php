<div class="col-md-4">
    <!-- Blog Sidebar Widgets Column -->

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="/cms/search.php" method="post"> <!-- search form -->
            <div class="input-group">
                <input type="text" name="search" class="form-control">
                <span class="input-group-btn">
                    <button name="submit" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.input-group -->
    </div>

    <!-- Login -->
    <div class="well">
        <h4>Login</h4>


        <?php
        if (isset($_SESSION['username'])) {
            echo "<div class='alert alert-success'>You are logged in as <strong>" . htmlspecialchars($_SESSION['username'])  . "</strong>
                <br><br> 
                <a href='/cms/includes/logout.php' class='btn btn-primary btn-sm'>Logout</a> 
                 </div>";
        } else {
        ?>
            <form action="/cms/includes/login.php" method="post">
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="Enter username" required minlength="4">
                    <!-- <span class="input-group-btn">
                    <button name="submit" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span> -->
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Enter password" required minlength="8"><br>
                    <span class="input-group-btn">
                        <button name="login" class="btn btn-primary" type="submit">
                            Submit
                        </button>
                    </span>
                </div>
            </form>
        <?php

        }
        ?>

        <!-- /.input-group -->
    </div>

    <!-- Blog Categories Well -->
    <div class="well">

        <?php
        $query = "SELECT * FROM categories";
        $select_categories_sidebar = mysqli_query($connection, $query);
        ?>

        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">

                    <?php
                    while ($row = mysqli_fetch_assoc($select_categories_sidebar)) {
                        $cat_id = htmlspecialchars($row['cat_id']);
                        $cat_title = htmlspecialchars($row['cat_title']);
                        echo "<li><a href='/cms/category/$cat_id/page/1'>{$cat_title}</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php include "widget.php"; ?>

</div>