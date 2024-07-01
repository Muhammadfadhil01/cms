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
            if (isset($_GET['category'])) {
                $post_category_id = mysqli_real_escape_string($connection, $_GET['category']);

                if (!isset($post_category_id)) {
                    header('Location: /cms/index');
                    exit;
                }

                // Validasi bahwa post_category_id adalah angka
                if (!is_numeric($post_category_id)) {
                    header('Location: /cms/index');
                    exit;
                }

                // Validasi bahwa category ID ada di database
                $query = "SELECT * FROM categories WHERE cat_id = $post_category_id";
                $check_category_query = mysqli_query($connection, $query);

                if (mysqli_num_rows($check_category_query) == 0) {
                    header('Location: /cms/index');
                    exit;
                }

                // Post per page
                $post_per_page = 5;

                // Current page number for url
                if (isset($_GET['page'])) {
                    $page = mysqli_real_escape_string($connection, $_GET['page']);
                } else {
                    $page = 1;
                }

                // Start page
                $start_from = ($page - 1) * $post_per_page;
                $query = "SELECT * FROM posts WHERE post_category_id = $post_category_id AND post_status = 'published'";
                $all_posts_query = mysqli_query($connection, $query);

                if (!$all_posts_query) {
                    die("Query failed: " . mysqli_error($connection));
                }

                $count = mysqli_num_rows($all_posts_query);
                $total_pages = ceil($count / $post_per_page);

                // Limit query
                $query .= " LIMIT $start_from, $post_per_page";
                $select_all_posts_query = mysqli_query($connection, $query);

                // Alert
                if ($count == 0) {
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
                            by <a href="index"><?php echo $post_author ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                        <hr>
                        <img class="img-responsive" src="/cms/images/<?php echo $post_image ?>" alt="">
                        <hr>
                        <p><?php echo $post_content ?></p>
                        <a class="btn btn-primary" href="/cms/post/<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                        <hr>

            <?php
                    }
                }
            } else {
                header('Location: /cms/index');
                exit;
            }
            ?>

            <!-- Pagination -->
            <ul class="pager">
                <?php
                if ($count > 0) {
                    for ($i = 1; $i <= $total_pages; $i++) {
                        if ($i == $page) {
                            echo "<li><a class='active_link' href='/cms/category/{$post_category_id}/page/{$i}'>{$i}</a></li>";
                        } else {
                            echo "<li><a href='/cms/category/{$post_category_id}/page/{$i}'>{$i}</a></li>";
                        }
                    }
                }
                ?>
            </ul>

            <!-- First blog post close -->

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>

    </div>
    <!-- /.row -->

    <hr>

    <?php include "includes/footer.php"; ?>