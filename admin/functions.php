<?php

function confirm($result)
{

    global $connection;
    if (!$result) {
        die("QUERY FAILED" . mysqli_error($connection));
    } else {
    }
}

function insert_categories()
{
    //insert query

    global $connection;

    if (isset($_POST['submit'])) {
        $cat_title = mysqli_real_escape_string($connection, $_POST['cat_title']);

        if ($cat_title == "" || empty($cat_title)) {
            echo "This field should not be empty";
        } else {
            $query = "INSERT INTO categories(cat_title) VALUE('$cat_title')";
            $create_category_query = mysqli_query($connection, $query);

            //alert add category 1
            if ($create_category_query) {
                $_SESSION['message'] = 'Your category has been added!';
                header('Location: categories.php');
                exit();
            } else {
                die('QUERY FAILED' . mysqli_error($connection));
            }
        }
    }
}

function findAllCategories()
{
    global $connection;

    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection, $query);
    $i = 1;
    while ($row = mysqli_fetch_assoc($select_categories)) {
        $cat_id = htmlspecialchars($row["cat_id"]);
        $cat_title = htmlspecialchars($row['cat_title']);
        echo "<tr>";
        echo "<td>{$i}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a> | <a href='categories.php?delete={$cat_id}' onclick=\"return confirm('Are you sure you want to delete??')\">Delete</a></td>";
        echo "</tr>";
        $i++;
    }
}

function deleteCategories()
{
    //delete query

    global $connection;

    if (isset($_SESSION['user_role'])) {
        if ($_SESSION['user_role'] == 'admin') {
            if (isset($_GET['delete'])) {
                $the_cat_id = mysqli_real_escape_string($connection, $_GET['delete']);
                $query = "DELETE FROM categories WHERE cat_id = '$the_cat_id'";
                $delete_query = mysqli_query($connection, $query);
                if ($delete_query) {

                    //alert edit category 1
                    if ($delete_query) {
                        $_SESSION['message'] = 'Your category has been deleted!';
                        header('Location: categories.php');
                        exit();
                    } else {
                        die('QUERY FAILED' . mysqli_error($connection));
                    }
                }
            }
        }
    }
}


//users online
// users_online function
function users_online()
{
    global $connection;

    if (isset($_GET['onlineusers'])) {
        if (!$connection) {
            session_start();
            include("../includes/db.php");
        }

        $session = session_id();
        $time = time();
        $time_out_in_seconds = 05;
        $time_out = $time - $time_out_in_seconds;

        $query = "SELECT * FROM users_online WHERE session = '$session'";
        $send_query = mysqli_query($connection, $query);
        $count = mysqli_num_rows($send_query);

        if ($count == NULL) {
            mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
        } else {
            mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
        }

        $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time >= '$time_out'");
        echo $count_user_session = mysqli_num_rows($users_online_query);
    }
}

users_online(); // Call the function to update users online status
