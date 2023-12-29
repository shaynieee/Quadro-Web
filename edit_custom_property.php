<?php
include("../db.php");

// Fetch available items for dropdown
$itemOptionsQuery = "SELECT custom_property_id, property_name FROM custom_property";
$itemOptionsResult = mysqli_query($conn, $itemOptionsQuery);

// Fetch available items for dropdown in the update form
$catOptionsQuery = "SELECT item_id, item_name FROM items";
$catOptionsResult = mysqli_query($conn, $catOptionsQuery);

function updateCustomProperty($conn, $custom_property_Id, $newPropertyName, $newCustomProperty_id) {
    // Update custom property query
    $updateCustomPropertyQuery = "UPDATE custom_property
                        SET property_name = '$newPropertyName',
                            item_id = '$newCustomProperty_id'
                        WHERE custom_property_id = '$custom_property_Id'";
    
    mysqli_query($conn, $updateCustomPropertyQuery);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define variables
    $custom_property_Id = mysqli_real_escape_string($conn, $_POST['custom_property_id']);
    $newPropertyName = mysqli_real_escape_string($conn, $_POST['new_item_name']);
    $newCustomProperty_id = mysqli_real_escape_string($conn, $_POST['new_cat_id']);
    
    // Call updateCustomProperty function
    updateCustomProperty($conn, $custom_property_Id, $newPropertyName, $newCustomProperty_id);
    echo "<script>alert('Custom property has been updated successfully');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPDATE CUSTOM PROPERTY</title>
    <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../style.css" />
</head>

<body>

<div class="container mt-5">
    <h1 class="text-center">UPDATE CUSTOM PROPERTY</h1>
    <!-- Your HTML form -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

        <div class="form-outline w-50 m-auto mb-4">
            <label for="custom_property_id" class="form-label">Select Custom Property</label>
            <select id="custom_property_id" name="custom_property_id" class="form-select" required>
                <?php
                // Display custom property options in dropdown
                while ($itemOption = mysqli_fetch_assoc($itemOptionsResult)) {
                    echo "<option value='{$itemOption['custom_property_id']}'>{$itemOption['property_name']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-outline w-50 m-auto mb-4">
            <label for="new_item_name" class="form-label">New Custom Property Name</label>
            <input type="text" id="new_item_name" name="new_item_name" class="form-control" required>
        </div>

        <div class="form-outline w-50 m-auto mb-4">
            <label for="new_cat_id" class="form-label">New Item ID</label>
            <select id="new_cat_id" name="new_cat_id" class="form-select" required>
                <?php
                // Display item options in dropdown
                while ($catOption = mysqli_fetch_assoc($catOptionsResult)) {
                    echo "<option value='{$catOption['item_id']}'>{$catOption['item_name']}</option>";
                }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Custom Property</button>
    </form>
</div>

</body>
</html>