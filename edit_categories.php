<?php
include("../db.php");

// Fetch available items for dropdown
$itemOptionsQuery = "SELECT cat_id, cat_name FROM categories";
$itemOptionsResult = mysqli_query($conn, $itemOptionsQuery);

// Fetch available items for dropdown in the update form
$catOptionsQuery = "SELECT item_id, item_name FROM items";
$catOptionsResult = mysqli_query($conn, $catOptionsQuery);

function updateCategory($conn, $cat_id, $newCatName, $newCatDesc, $newCatImg) {
    // Update variation query
    $updateCategoriesQuery = "UPDATE categories
                        SET cat_name = '$newCatName',
                            cat_description = '$newCatDesc',
                            cat_image ='$newCatImg'
                        WHERE cat_id = '$cat_id'";
    
    mysqli_query($conn, $updateCategoriesQuery);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define variables
    $cat_id = mysqli_real_escape_string($conn, $_POST['cat_id']);
    $newCatName = mysqli_real_escape_string($conn, $_POST['new_cat_name']);
    $newCatDesc = mysqli_real_escape_string($conn, $_POST['new_cat_desc']);
    $newCatImg = mysqli_real_escape_string($conn, $_POST['new_cat_img']);
    
    // Call updateVariation function
    updateCategory($conn, $cat_id, $newCatName, $newCatDesc, $newCatImg);
    echo "<script>alert('Category has been updated successfully');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN PAGE</title>
    <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../style.css" />
</head>

<body>

<div class="container mt-5">
    <h1 class="text-center">UPDATE VARIATION</h1>
    <!-- Your HTML form -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

        <div class="form-outline w-50 m-auto mb-4">
            <label for="cat_id" class="form-label">Select Variation</label>
            <select id="cat_id" name="cat_id" class="form-select" required>
                <?php
                // Display variation options in dropdown
                while ($itemOption = mysqli_fetch_assoc($itemOptionsResult)) {
                    echo "<option value='{$itemOption['cat_id']}'>{$itemOption['cat_name']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-outline w-50 m-auto mb-4">
            <label for="new_cat_name" class="form-label">New Category Name</label>
            <input type="text" id="new_cat_name" name="new_cat_name" class="form-control" required>
        </div>

        <div class="form-outline w-50 m-auto mb-4">
            <label for="new_cat_desc" class="form-label">New Category Description</label>
            <input type="text" id="new_cat_desc" name="new_cat_desc" class="form-control" required>
        </div>

        <div class="form-outline w-50 m-auto mb-4">
            <label for="new_cat_img" class="form-label">New Category Image</label>
            <input type="file" id="new_cat_img" name="new_cat_img" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Category</button>
    </form>
</div>

</body>
</html>