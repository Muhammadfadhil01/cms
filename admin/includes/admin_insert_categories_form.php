<?php insert_categories(); ?>

<form action="" method="post">
    <div class="form-group">
        <label for="cat-title">Add Category</label>
        <input type="text" class="form-control" name="cat_title" required>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="submit" value="Add category">
    </div>
</form>

<?php
if (isset($_GET['edit'])) {

    $cat_id = mysqli_real_escape_string($connection, $_GET['edit']);

    //jika page tidak sesuai, maka balik ke page awal
    if(!is_numeric($cat_id) || $cat_id <= 0){
        header('location:categories.php');
    }
    
    $query = "SELECT * FROM categories WHERE cat_id = $cat_id";
    $select_categories_id = mysqli_query($connection, $query);

    //jika query tidak ada maka balik ke page awal
    if(mysqli_num_rows($select_categories_id) == 0){
        header('location:categories.php');
    }

    while ($row = mysqli_fetch_assoc($select_categories_id)) {
        $cat_id = $row["cat_id"];
        $cat_title = $row['cat_title'];
?>
        <form action="" method="post">
            <div class="form-group">
                <label for="cat-title">Edit Category</label>
                <input type="text" value="<?php if (isset($cat_title)) {
                                                echo $cat_title;
                                            } ?>" class="form-control" name="cat_title" required>
            </div>
            <div class="form-group">
                <input class="btn btn-primary" type="submit" name="update_category" value="Update Category">
            </div>
        </form>
<?php }
} ?>

<?php
//update, include update categories query
if (isset($_POST['update_category'])) {
    $cat_id = mysqli_real_escape_string($connection, $_GET['edit']);

    include "includes/admin_update_categories.php";
}
?>