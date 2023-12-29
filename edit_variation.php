<?php
include("../db.php");

// Fetch available items for dropdown
$itemOptionsQuery = "SELECT variation_id, variation_name FROM variation";
$itemOptionsResult = mysqli_query($conn, $itemOptionsQuery);

// Fetch available items for dropdown in the update form
$catOptionsQuery = "SELECT item_id, item_name FROM items";
$catOptionsResult = mysqli_query($conn, $catOptionsQuery);

function updateVariation($conn, $variation_id, $newVariationName, $newVariationPrice, $newVariationQty, $newCustomProperty_id) {
    // Update variation query
    $updateVariationQuery = "UPDATE variation
                        SET variation_name = '$newVariationName',
                            variation_price = '$newVariationPrice',
                            variation_qty = '$newVariationQty',
                            custom_property_id = '$newCustomProperty_id'
                        WHERE variation_id = '$variation_id'";
    
    mysqli_query($conn, $updateVariationQuery);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define variables
    $variation_id = mysqli_real_escape_string($conn, $_POST['custom_property_id']);
    $newVariationName = mysqli_real_escape_string($conn, $_POST['new_variation_name']);
    $newVariationPrice = mysqli_real_escape_string($conn, $_POST['new_variation_price']);
    $newVariationQty = mysqli_real_escape_string($conn, $_POST['new_variation_qty']);
    $newCustomProperty_id = mysqli_real_escape_string($conn, $_POST['new_cat_id']);
    
    // Call updateVariation function
    updateVariation($conn, $variation_id, $newVariationName, $newVariationPrice, $newVariationQty, $newCustomProperty_id);
    echo "<script>alert('Variation has been updated successfully');</script>";
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
            <label for="custom_property_id" class="form-label">Select Variation</label>
            <select id="custom_property_id" name="custom_property_id" class="form-select" required>
                <?php
                // Display variation options in dropdown
                while ($itemOption = mysqli_fetch_assoc($itemOptionsResult)) {
                    echo "<option value='{$itemOption['variation_id']}'>{$itemOption['variation_name']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-outline w-50 m-auto mb-4">
            <label for="new_variation_name" class="form-label">New Variation Name</label>
            <input type="text" id="new_variation_name" name="new_variation_name" class="form-control" required>
        </div>

        <div class="form-outline w-50 m-auto mb-4">
            <label for="new_variation_price" class="form-label">New Variation Price</label>
            <input type="text" id="new_variation_price" name="new_variation_price" class="form-control" required>
        </div>

        <div class="form-outline w-50 m-auto mb-4">
            <label for="new_variation_qty" class="form-label">New Variation Quantity</label>
            <input type="text" id="new_variation_qty" name="new_variation_qty" class="form-control" required>
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

        <button type="submit" class="btn btn-primary">Update Variation</button>
    </form>
</div>

</body>
</html>