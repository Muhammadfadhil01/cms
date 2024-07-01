<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">CMS ADMIN</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li><a href="">Users online : <span class="usersonline"></span></a></li>

        <!-- Users online js -->
        <script type="text/javascript">
            $(document).ready(function() {
                function loadUsersOnline() {
                    $.get("functions.php?onlineusers=true", function(data) {
                        $(".usersonline").text(data);
                    });
                }

                setInterval(function() {
                    loadUsersOnline();
                }, 500);

                loadUsersOnline();
            });
        </script>



        <li><a href="../index">HOME</a></li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo htmlspecialchars($_SESSION['user_role']) . ' ' . htmlspecialchars($_SESSION['username']) ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>


    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li>
                <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="posts_dropdown" class="collapse">
                    <li>
                        <a href="posts.php">View all posts</a>
                    </li>
                    <li>
                        <a href="posts.php?source=add_post">Add posts</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="categories.php"><i class="fa fa-fw fa-wrench"></i> Categories</a>
            </li>
            <li> <!-- class="active" -->
                <a href="comments.php"><i class="fa fa-fw fa-file"></i> Comments</a>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo" class="collapse">
                    <li>
                        <a href="users.php">View all users</a>
                    </li>
                    <li>
                        <a href="users.php?source=add_user">Add users</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="profile.php"><i class="fa fa-fw fa-dashboard"></i> Profile</a>
            </li>
        </ul>
    </div>



    <!-- /.navbar-collapse -->
</nav>