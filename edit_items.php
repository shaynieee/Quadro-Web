<?php
include("../db.php");

// Fetch available items for dropdown
$itemOptionsQuery = "SELECT item_id, item_name FROM items";
$itemOptionsResult = mysqli_query($conn, $itemOptionsQuery);

function updateItem($conn, $itemId, $newItemName, $newItemDesc, $newCatId, $newStockId, $newItemStatus, $newItemImg, $newPrice) {
    // Update item query
    $updateItemQuery = "UPDATE items
                        INNER JOIN pricing ON items.price_id = pricing.price_id
                        INNER JOIN stocks ON items.stock_id = stocks.stock_id
                        SET items.item_name = '$newItemName',
                            items.item_desc = '$newItemDesc',
                            items.cat_id = '$newCatId',
                            items.stock_id = '$newStockId',
                            items.item_status = '$newItemStatus',
                            items.item_img = '$newItemImg',
                            pricing.item_price = '$newPrice'
                        WHERE items.item_id = '$itemId'";
    
    mysqli_query($conn, $updateItemQuery);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define variables
    $itemIdToUpdate = mysqli_real_escape_string($conn, $_POST['item_id']);
    $newItemName = mysqli_real_escape_string($conn, $_POST['new_item_name']);
    $newItemDesc = mysqli_real_escape_string($conn, $_POST['new_item_desc']);
    $newCatId = mysqli_real_escape_string($conn, $_POST['new_cat_id']);
    $newStockId = mysqli_real_escape_string($conn, $_POST['new_stock_id']);
    $newItemStatus = mysqli_real_escape_string($conn, $_POST['new_item_status']);
    $newItemImg = mysqli_real_escape_string($conn, $_POST['new_item_img']);
    $newPrice = mysqli_real_escape_string($conn, $_POST['new_price']);
  
    // Call updateItem function
    updateItem($conn, $itemIdToUpdate, $newItemName, $newItemDesc, $newCatId, $newStockId, $newItemStatus, $newItemImg, $newPrice);
    echo "<script>alert('Item has been updated successfully');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPDATE ITEM</title>
    <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../style.css" />
</head>

<body>

<div class="container mt-5">
    <h1 class="text-center">UPDATE ITEM</h1>
    <!-- Your HTML form -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

        <div class="form-outline w-50 m-auto mb-4">
            <label for="item_id" class="form-label">Select Item</label>
            <select id="item_id" name="item_id" class="form-select" required>
                <?php
                // Display item options in dropdown
                while ($itemOption = mysqli_fetch_assoc($itemOptionsResult)) {
                    echo "<option value='{$itemOption['item_id']}'>{$itemOption['item_name']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-outline w-50 m-auto mb-4">
            <label for="new_item_name" class="form-label">New Item Name</label>
            <input type="text" id="new_item_name" name="new_item_name" class="form-control" required>
        </div>

        <div class="form-outline w-50 m-auto mb-4">
            <label for="new_item_desc" class="form-label">New Item Description</label>
            <input type="text" id="new_item_desc" name="new_item_desc" class="form-control" required>
        </div>

        <div class="form-outline w-50 m-auto mb-4">
            <label for="new_cat_id" class="form-label">New Category ID</label>
            <select id="new_cat_id" name="new_cat_id" class="form-select" required>
                <?php
                // Fetch available category options
                $catOptionsQuery = "SELECT cat_id, cat_name FROM categories";
                $catOptionsResult = mysqli_query($conn, $catOptionsQuery);

                while ($catOption = mysqli_fetch_assoc($catOptionsResult)) {
                    echo "<option value='{$catOption['cat_id']}'>{$catOption['cat_name']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-outline w-50 m-auto mb-4">
            <label for="new_stock_id" class="form-label">New Stock ID</label>
            <select id="new_stock_id" name="new_stock_id" class="form-select" required>
                <?php
                // Fetch available stock options
                $stockOptionsQuery = "SELECT stock_id, stock_qty FROM stocks";
                $stockOptionsResult = mysqli_query($conn, $stockOptionsQuery);

                while ($stockOption = mysqli_fetch_assoc($stockOptionsResult)) {
                    echo "<option value='{$stockOption['stock_id']}'>{$stockOption['stock_qty']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-outline w-50 m-auto mb-4">
            <label for="new_item_status" class="form-label">New Item Status</label>
            <input type="text" id="new_item_status" name="new_item_status" class="form-control" required>
        </div>

        <div class="form-outline w-50 m-auto mb-4">
            <label for="new_item_img" class="form-label">New Item Image</label>
            <input type="file" id="new_item_img" name="new_item_img" class="form-control" required>
        </div>

        <div class="form-outline w-50 m-auto mb-4">
            <label for="new_price" class="form-label">New Price ID</label>
            <select id="new_price" name="new_price" class="form-select" required>
                <?php
                // Fetch available price options
                $priceOptionsQuery = "SELECT price_id, item_price FROM pricing";
                $priceOptionsResult = mysqli_query($conn, $priceOptionsQuery);

                while ($priceOption = mysqli_fetch_assoc($priceOptionsResult)) {
                    echo "<option value='{$priceOption['price_id']}'>{$priceOption['item_price']}</option>";
                }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Item</button>
    </form>
</div>

</body>
</html>