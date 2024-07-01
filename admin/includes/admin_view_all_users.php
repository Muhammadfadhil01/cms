<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>Username</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>



        <tbody>

            <?php
            $query = "SELECT * FROM users";
            $select_users = mysqli_query($connection, $query);
            $i = 1;
            while ($row = mysqli_fetch_assoc($select_users)) {
                $user_id = htmlspecialchars($row["user_id"]);
                $username = htmlspecialchars($row['username']);
                $user_password = htmlspecialchars($row['user_password']);
                $user_firstname = htmlspecialchars($row['user_firstname']); 
                $user_lastname = htmlspecialchars($row['user_lastname']);
                $user_email = htmlspecialchars($row['user_email']);
                $user_image = htmlspecialchars($row['user_image']);
                $user_role = htmlspecialchars($row['user_role']);

                echo "<tr>";
                echo "<td>$i</td>";
                echo "<td>$username</td>";
                echo "<td>$user_firstname</td>";
                echo "<td>$user_lastname</td>";
                echo "<td>$user_email</td>";
                echo "<td>$user_role</td>";
                echo "<td>
                        <a href='users.php?change_to_admin=$user_id'>Admin</a> |
                        <a href='users.php?change_to_user=$user_id'>User</a> |
                        <a href='users.php?source=edit_user&edit_user=$user_id'>edit</a> | <a href='users.php?delete=$user_id' onclick=\"return confirm('Are you sure you want to delete??')\">Delete</a>
                      </td>";

                //cadangan 
                // $query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
                // $select_post_id_query = mysqli_query($connection, $query);
                // while ($row = mysqli_fetch_assoc($select_post_id_query)) {
                //     $post_id = $row['post_id'];
                //     $post_title = $row['post_title'];
                // }

                //approve unapprove
                // echo "<td><a href='comments.php?approve=$comment_id'>Approve</a></td>";
                // echo "<td><a href='comments.php?unapprove=$comment_id'>Unapprove</a></td>";
                // echo "<td><a href='comments.php?delete=$comment_id'>Delete</a></td>";

                echo "</tr>";
                $i++;
            }
            ?>
        </tbody>
    </table>
    <?php

    //approve
    if (isset($_GET['change_to_admin'])) {
        $the_user_id = mysqli_real_escape_string($connection, $_GET['change_to_admin']);
        $query = "UPDATE users SET user_role = 'admin' WHERE user_id = $the_user_id";
        $admin_query = mysqli_query($connection, $query);
        if ($admin_query) {
            header("location:users.php");
        } else {
            die("QUERY FAILED");
        }
    }

    //unapprove
    if (isset($_GET['change_to_user'])) {
        $the_user_id = mysqli_real_escape_string($connection, $_GET['change_to_user']);
        $query = "UPDATE users SET user_role = 'user' WHERE user_id = $the_user_id";
        $user_query = mysqli_query($connection, $query);
        if ($user_query) {
            //$_SESSION['user_role'] = 'user';
            header("location:users.php");
        } else {
            die("QUERY FAILED");
        }
    }

    if (isset($_GET['delete'])) {

        if (isset($_SESSION['user_role'])) {
            if ($_SESSION['user_role'] == 'admin') {
                $the_user_id = mysqli_real_escape_string($connection, $_GET['delete']);
                $query = "DELETE FROM users WHERE user_id = $the_user_id";
                $delete_query = mysqli_query($connection, $query);

                //alert delete user 1
                if ($delete_query) {
                    $_SESSION['message'] = 'User has been deleted!';
                    header('Location: users.php');
                    exit();
                } else {
                    die('QUERY FAILED' . mysqli_error($connection));
                }
            }
        }
    }
    ?>
</div>