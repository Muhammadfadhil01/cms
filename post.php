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
            if (isset($_GET['p_id']) && is_numeric($_GET['p_id'])) {
                $the_post_id = mysqli_real_escape_string($connection, $_GET['p_id']);
                $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
                $select_all_posts_query = mysqli_query($connection, $query);

                // Post view count
                $query = "UPDATE posts SET post_view_count = post_view_count + 1 WHERE post_id =" . mysqli_real_escape_string($connection, $the_post_id);
                $post_view_query = mysqli_query($connection, $query);

                if (!$post_view_query) {
                    die('QUERY FAILED' . mysqli_error($connection));
                }

                if (mysqli_num_rows($select_all_posts_query) > 0) {
                    while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                    $post_title = htmlspecialchars($row['post_title']);
                    $post_author = htmlspecialchars($row['post_author']);
                    $post_date = htmlspecialchars($row['post_date']);
                    $post_image = htmlspecialchars($row['post_image']);
                    $post_content = $row['post_content'];
            ?>

                        <!-- First Blog Post -->
                        <h2>
                            <a href="/cms/post/<?php echo $the_post_id; ?>"><?php echo $post_title ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="/cms/author_posts.php?author=<?php echo $post_author ?>"><?php echo $post_author ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
                        <hr>
                        <img class="img-responsive" src="/cms/images/<?php echo $post_image ?>" alt="">
                        <hr>
                        <p><?php echo $post_content ?></p>
                        <hr>
            <?php
                    }
                } else {
                    //jika post tidak ditemukan balik ke halaman index
                    header("Location: /cms/index");
                    exit;
                }
            } else {
                //jika post p_id diotak atik balik ke halaman index
                header("Location: /cms/index");
                exit;
            }

            ?>

            <!-- Blog Comments -->
            <?php
            if (isset($_POST['create_comment'])) {
                $the_post_id = mysqli_real_escape_string($connection, $_GET['p_id']);
                $comment_author = mysqli_real_escape_string($connection, $_SESSION['username']);

                $query = "SELECT user_email FROM users WHERE username = '$comment_author'";
                $select_user_email = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($select_user_email)) {
                    $comment_email = $row['user_email'];
                }

                $comment_content = mysqli_real_escape_string($connection, $_POST['comment_content']);
                
                $query = "INSERT INTO comments(comment_post_id, comment_author, comment_email,comment_content, comment_status, comment_date) 
                          VALUES('$the_post_id', '$comment_author', '$comment_email', '$comment_content', 'Unapprove', now())";
                $create_comment_query = mysqli_query($connection, $query);
                
                if ($create_comment_query) {
                    
                } else {
                    die('QUERY FAILED' . mysqli_error($connection));
                }

                $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = $the_post_id";
                $update_comment_count_query = mysqli_query($connection, $query);
            }


            ?>

            <!-- Jika tidak ada sesi login di comment maka login terlebih dahulu -->
            <?php if (isset($_SESSION['username'])) { ?>
                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" action="" method="post">
                        <div class="form-group">
                            <label for="your_comment">Your comment</label>
                            <textarea class="form-control" rows="3" name="comment_content" id="your_comment" required></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            <?php } else { ?>
                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" action="" method="post">
                        <div class="form-group">
                            <label for="your_comment">Your comment</label>
                            <textarea class="form-control" rows="3" name="comment_content" id="your_comment" required></textarea>
                        </div>
                        <a href="/cms/login_user" class="btn btn-primary">Submit</a>
                    </form>
                </div>    
            <?php } ?>

            <hr>

            <!-- Posted Comments -->
            <?php
            $query = "SELECT * FROM comments WHERE comment_post_id = $the_post_id AND comment_status = 'Approve' ORDER BY comment_id DESC";
            $select_comments_query = mysqli_query($connection, $query);
            if (!$select_comments_query) {
                die('Query failed' . mysqli_error($connection));
            }
            while ($row = mysqli_fetch_assoc($select_comments_query)) {
                $comment_id = htmlspecialchars($row["comment_id"]);
                $comment_date = htmlspecialchars($row['comment_date']);
                $comment_content = htmlspecialchars($row['comment_content']);
                $comment_author = htmlspecialchars($row['comment_author']);

            ?>

                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <?php echo $comment_content; ?>
                    </div>
                </div>
            <?php } ?>


            <!-- First blog post close -->

        </div>


        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>

    </div>
    <!-- /.row -->

    <hr>

    <?php include "includes/footer.php"; ?>
    