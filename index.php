<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<!-- Navigation -->
<?php include "includes/nav.php"; ?>

<!-- Page Content -->
<div class="container">

    <h1 class="page-header">
        Home
        <small>

            <?php
            if (isset($_SESSION['username'])) {
                echo 'Welcome! ' . $_SESSION['username'];
            } else {
                echo "You are not logged in";
            }
            ?>
        </small>
    </h1>

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <?php
            // Post per page
            $posts_per_page = 5;

            // Current page number for url
            if (isset($_GET['page'])) {
                $page = mysqli_real_escape_string($connection, $_GET['page']);
            } else {
                $page = 1;
            }

            // Start page
            $start_from = ($page - 1) * $posts_per_page;

            // Limit query
            $query = "SELECT * FROM posts WHERE post_status = 'published' LIMIT $start_from, $posts_per_page";
            $select_all_posts_query = mysqli_query($connection, $query);

            $count_query = "SELECT * FROM posts WHERE post_status = 'published'";
            $count_posts_query = mysqli_query($connection, $count_query);
            $total_posts = mysqli_num_rows($count_posts_query);
            $total_pages = ceil($total_posts / $posts_per_page);

            // Alert
            if ($total_posts == 0) {
                echo "<h1>No content available</h1>";
            } else {
                while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                    $post_id = htmlspecialchars($row['post_id']);
                    $post_title = htmlspecialchars($row['post_title']);
                    $post_author = htmlspecialchars($row['post_author']);
                    $post_date = htmlspecialchars($row['post_date']);
                    $post_image = htmlspecialchars($row['post_image']);
                    $post_content = substr($row['post_content'], 0, 100);
            ?>

                    <!-- First Blog Post -->
                    <h2>
                        <a href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="author_posts.php?author=<?php echo $post_author ?>"><?php echo $post_author ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                    <hr>
                    <a href="/cms/post/<?php echo $post_id; ?>"><img class="img-responsive" src="images/<?php echo $post_image ?>" alt=""></a>
                    <hr>
                    <p><?php echo $post_content ?></p>
                    <a class="btn btn-primary" href="/cms/post/<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                    <hr>

            <?php
                }
            }
            ?>

            <!-- Pagination -->
            <ul class="pager">
                <?php
                for ($i = 1; $i <= $total_pages; $i++) {
                    if ($i == $page) {
                        echo "<li><a class='active_link' href='index?page={$i}'>{$i}</a></li>";
                    } else {
                        echo "<li><a href='index?page={$i}'>{$i}</a></li>";
                    }
                }
                ?>
            </ul>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"; ?>

    </div>
    <!-- /.row -->

    <hr>

    <?php include "includes/footer.php"; ?>
</div>
<!-- /.container -->