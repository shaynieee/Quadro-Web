<?php
include("../db.php");

// Fetch available items for dropdown
$itemOptionsQuery = "SELECT price_id, item_price FROM pricing";
$itemOptionsResult = mysqli_query($conn, $itemOptionsQuery);

// Fetch available items for dropdown in the update form
$catOptionsQuery = "SELECT item_id, item_name FROM items";
$catOptionsResult = mysqli_query($conn, $catOptionsQuery);

function updatePrice($conn, $price_Id, $newItemPrice, $newItemID) {
    // Update custom property query
    $updatePrice = "UPDATE pricing
                        SET item_price = '$newItemPrice',
                            item_id = '$newItemID'
                        WHERE price_id = '$price_Id'";

    mysqli_query($conn, $updatePrice);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define variables
    $price_Id = isset($_POST['price_id']) ? mysqli_real_escape_string($conn, $_POST['price_id']) : null;
    $newItemPrice = isset($_POST['new_item_name']) ? mysqli_real_escape_string($conn, $_POST['new_item_name']) : null;
    $newItemID = isset($_POST['new_cat_id']) ? mysqli_real_escape_string($conn, $_POST['new_cat_id']) : null;

    // Check if the keys exist before using them
    if ($price_Id !== null && $newItemPrice !== null && $newItemID !== null) {
        // Call updateCustomProperty function
        updatePrice($conn, $price_Id, $newItemPrice, $newItemID);
        echo "<script>alert('Price has been updated successfully');</script>";
    } else {
        echo "<script>alert('Error: Missing data.');</script>";
    }
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
                <label for="price_id" class="form-label">Select Price</label>
                <select id="price_id" name="price_id" class="form-select" required>
                    <?php
                    // Display custom property options in dropdown
                    while ($itemOption = mysqli_fetch_assoc($itemOptionsResult)) {
                        echo "<option value='{$itemOption['price_id']}'>{$itemOption['item_price']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-outline w-50 m-auto mb-4">
                <label for="new_item_name" class="form-label">New Item Price</label>
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

            <button type="submit" class="btn btn-primary">Update Price</button>
        </form>
    </div>

</body>

</html>