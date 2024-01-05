<?php
include("../db.php");

// Fetch available items for dropdown
$itemOptionsQuery = "SELECT stock_id, stock_qty FROM stocks";
$itemOptionsResult = mysqli_query($conn, $itemOptionsQuery);

// Fetch available items for dropdown in the update form
$catOptionsQuery = "SELECT item_id, item_name FROM items";
$catOptionsResult = mysqli_query($conn, $catOptionsQuery);

function updateStock($conn, $stock_id, $newStockQty, $newItemID) {
    // Update stock query
    $updateStock = "UPDATE stocks
                        SET stock_qty = '$newStockQty',
                            item_id = '$newItemID'
                        WHERE stock_id = '$stock_id'";

    mysqli_query($conn, $updateStock);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define variables
    $stock_id = isset($_POST['stock_id']) ? mysqli_real_escape_string($conn, $_POST['stock_id']) : null;
    $newStockQty = isset($_POST['new_stock_qty']) ? mysqli_real_escape_string($conn, $_POST['new_stock_qty']) : null;
    $newItemID = isset($_POST['new_cat_id']) ? mysqli_real_escape_string($conn, $_POST['new_cat_id']) : null;

    // Check if the keys exist before using them
    if ($stock_id !== null && $newStockQty !== null && $newItemID !== null) {
        // Call updateStock function
        updateStock($conn, $stock_id, $newStockQty, $newItemID);
        echo "<script>alert('Stock has been updated successfully');</script>";
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
    <title>UPDATE STOCK</title>
    <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../style.css" />
</head>

<body>

    <div class="container mt-5">
        <h1 class="text-center">UPDATE STOCK</h1>
        <!-- Your HTML form -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

            <div class="form-outline w-50 m-auto mb-4">
                <label for="stock_id" class="form-label">Select Stock</label>
                <select id="stock_id" name="stock_id" class="form-select" required>
                    <?php
                    // Display stock options in dropdown
                    while ($itemOption = mysqli_fetch_assoc($itemOptionsResult)) {
                        echo "<option value='{$itemOption['stock_id']}'>{$itemOption['stock_qty']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-outline w-50 m-auto mb-4">
                <label for="new_stock_qty" class="form-label">New Stock Quantity</label>
                <input type="text" id="new_stock_qty" name="new_stock_qty" class="form-control" required>
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

            <button type="submit" class="btn btn-primary">Update Stock</button>
        </form>
    </div>

</body>

</html>