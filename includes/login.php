<?php 
include "db.php"; 

session_start(); 

if (isset($_SESSION['username'])) {
    header("Location: index");
    exit;
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT * FROM users WHERE username = '$username'";
    $select_user_query = mysqli_query($connection, $query);
    
    if (!$select_user_query) {
        die("QUERY FAILED: " . mysqli_error($connection));
    }

    $db_id = $db_username = $db_user_password = $db_user_firstname = $db_user_lastname = $db_user_role = '';

    while ($row = mysqli_fetch_array($select_user_query)) {
        $db_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];
    }

    // Verify password
    if (password_verify($password, $db_user_password)) {
        
        //jika passwod benar set session
        $_SESSION['user_id'] = $db_id;
        $_SESSION['username'] = $db_username;
        $_SESSION['firstname'] = $db_user_firstname;
        $_SESSION['lastname'] = $db_user_lastname;
        $_SESSION['user_role'] = $db_user_role;

        header("Location: /cms/admin/index.php");

    } else {
        
        header("Location: /cms/index");
    }
}
?>
