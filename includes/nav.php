<?php

// mencegah session double di page login_user
if (session_status() == PHP_SESSION_NONE) {

    // Jika sesi belum dimulai, mulai sesi
    session_start();
}

?>

<?php

if (isset($_GET['p_id']) && isset($_SESSION['user_role'])  && $_SESSION['user_role'] == 'admin') {
    $link_post_id = $_GET['p_id'];
}


?>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/cms/index">CMS Fadhil</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                <?php

                // Mengembalikan path relatif dari URL
                $current = $_SERVER['REQUEST_URI'];
                $current_category = isset($_GET['category']) ? $_GET['category'] : '';

                $query = "SELECT * FROM categories";
                $select_all_categories_query = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($select_all_categories_query)) {
                    $cat_id = htmlspecialchars($row['cat_id']);
                    $cat_title = htmlspecialchars($row['cat_title']);

                    // Path kategori 
                    $category_path = "/cms/category/$cat_id/page/1";

                    // Pengecekan jika ada parameter 'page' pada URL saat ini
                    if (isset($_GET['page'])) {
                        $current_page = intval($_GET['page']);

                        // Jika parameter 'page' adalah angka dan lebih dari 1, maka ubah path kategori
                        if ($current_page > 1) {
                            $category_path = "/cms/category/$cat_id/page/$current_page";
                        }
                    }

                    if ($current == $category_path && $current_category == $cat_id) {
                        echo "<li class='active'><a href='/cms/category/$cat_id/page/1'>{$cat_title}</a></li>";
                    } else {
                        echo "<li><a href='/cms/category/$cat_id/page/1'>{$cat_title}</a></li>";
                    }
                }
                ?>


                <?php

                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
                    echo "<li><a href='/cms/admin/index.php'>admin</a></li>";
                }

                if (isset($_GET['p_id']) && isset($_SESSION['user_role'])  && $_SESSION['user_role'] == 'admin') {
                    echo "<li><a href='/cms/admin/posts.php?source=edit_post&p_id=$link_post_id'>edit post</a></li>";
                }

                if (!isset($_SESSION['user_role'])) {
                    // active class
                    if ($current == '/cms/registration') {
                        echo "<li class='active'><a href='/cms/registration'>register</a></li>";
                    } else {
                        echo "<li><a href='/cms/registration'>register</a></li>";
                    }

                    // active class
                    if ($current == '/cms/login_user') {
                        echo "<li class='active'><a href='/cms/login_user'>login</a></li>";
                    } else {
                        echo "<li><a href='/cms/login_user'>login</a></li>";
                    }
                }


                if ($current == '/cms/contact') {
                    echo "<li class='active' ><a href='/cms/contact'>contact</a></li>";
                } else {
                    echo "<li><a href='/cms/contact'>contact</a></li>";
                }



                ?>
            </ul>
        </div>
        <a href=""></a>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>