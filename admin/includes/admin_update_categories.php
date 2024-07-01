<?php

$the_cat_title = $_POST['cat_title'];

$query = "UPDATE categories SET cat_title = '$the_cat_title' WHERE cat_id = $cat_id";
$edit_query = mysqli_query($connection, $query);

header("Location:categories.php");

//alert edit category 1
if ($edit_query) {
    $_SESSION['message'] = 'Your category has been updated!';
    header('Location: categories.php');
    exit();
} else {
    die('QUERY FAILED' . mysqli_error($connection));
}
