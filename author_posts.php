<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<!-- Navigation -->
<?php include "includes/nav.php"; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <?php

            if ($_GET['author'] == null) {
                header('location:index');
            }

            $post_author = mysqli_real_escape_string($connection, $_GET['author']);


            $query = "SELECT * FROM posts WHERE post_status = 'published' AND post_author = '$post_author'";
            $select_all_posts_query = mysqli_query($connection, $query);

            //mencetak no content available jika post kosong
            $count = mysqli_num_rows($select_all_posts_query);
            if ($count == 0) {
                header('location:index');
                echo "<h1>No content available</h1>";
            } else {

                while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                    $post_id = htmlspecialchars($row['post_id']);
                    $post_title = htmlspecialchars($row['post_title']);
                    $post_author = htmlspecialchars($row['post_author']);
                    $post_date = htmlspecialchars($row['post_date']);
                    $post_image = htmlspecialchars($row['post_image']);
                    $post_content = substr($row['post_content'], 0, 100);
                    $post_status = htmlspecialchars($row['post_status']);

            ?>

                    <h1 class="page-header">
                        All post by :
                        <small><?php echo $post_author ?></small>
                    </h1>

                    <!-- First Blog Post -->
                    <h2>
                        <a href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="author_posts.php?author=<?php echo $post_author ?>"><?php echo $post_author ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
                    <hr>
                    <a href="/cms/post/<?php echo $post_id; ?>"><img class="img-responsive" src="images/<?php echo $post_image ?>" alt=""></a>
                    <hr>
                    <p><?php echo $post_content ?></p>
                    <a class="btn btn-primary" href="/cms/post/<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                    <hr>

            <?php }
            } ?>
            <!-- First blog post close -->

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>

    </div>
    <!-- /.row -->

    <hr>

    <?php include "includes/footer.php"; ?>