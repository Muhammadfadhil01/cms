<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<?php
$query = "SELECT * FROM posts WHERE post_status = 'published'";
$select_all_posts_query = mysqli_query($connection, $query);

// mencetak no content available jika post kosong
// $count = mysqli_num_rows($select_all_posts_query);
// if ($count == 0) {
//     echo "<h1>No content available</h1>";
// } else {

while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
    $post_id = htmlspecialchars($row['post_id']);
    $post_title = htmlspecialchars($row['post_title']);
    // $post_author = $row['post_author'];
    // $post_date = $row['post_date'];
    // $post_image = $row['post_image'];
    // $post_content = substr($row['post_content'], 0, 100);
    // $post_status = $row['post_status'];
}
?>


<!-- Navigation -->
<?php include "includes/nav.php"; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <?php

            // Post per page
            $post_per_page = 5;

            // Current page number for url
            if (isset($_POST['submit'])) {
                $search = mysqli_real_escape_string($connection, $_POST['search']);
            } elseif (isset($_GET['search'])) {
                $search = mysqli_real_escape_string($connection, $_GET['search']);
            } else {
                $search = "";
            }

            if (isset($_GET['page'])) {
                $page = mysqli_real_escape_string($connection, $_GET['page']);
            } else {
                $page = 1;
            }

            // Start page
            $start_from = ($page - 1) * $post_per_page;

            $query = "SELECT * FROM posts WHERE (post_tags LIKE '%$search%' OR post_title LIKE '%$search%' OR post_author LIKE '%$search%') AND post_status = 'published'";
            $search_query = mysqli_query($connection, $query);

            if (!$search_query) {
                die("Query failed: " . mysqli_error($connection));
            }

            $count = mysqli_num_rows($search_query);
            $total_pages = ceil($count / $post_per_page);

            // limit query
            $query .= " LIMIT $start_from, $post_per_page";
            $search_query = mysqli_query($connection, $query);

            //Alert 
            if ($count == 0) {
                echo "<h1>No result</h1>";
            } else {
                echo "<h1 class='page-header'>Search by: <small>$search</small></h1>";

                while ($row = mysqli_fetch_assoc($search_query)) {
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
                    <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
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
                if ($count > 0) {
                    for ($i = 1; $i <= $total_pages; $i++) {
                        if ($i == $page) {
                            echo "<li><a class='active_link' href='search.php?page={$i}&search={$search}'>{$i}</a></li>";
                        } else {
                            echo "<li><a href='search.php?page={$i}&search={$search}'>{$i}</a></li>";
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