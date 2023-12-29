<!DOCTYPE html>
<?php
include_once("../db.php");

if (isset($_POST['insert_stock'])) {
    $item_id = mysqli_real_escape_string($conn, $_POST['item_id']);
    $stock_qty = mysqli_real_escape_string($conn, $_POST['stock_qty']);
    
    $insert_query = "INSERT INTO stocks (item_id, stock_qty) VALUES ('$item_id', '$stock_qty')";
    $result = mysqli_query($conn, $insert_query);

    if ($result) {
        echo "<script>alert('Stock has been inserted successfully');</script>";
    } else {
        echo "<script>alert('Error inserting stock');</script>";
    }
}
?>

<html lang="en">

<head>
    <!-- Add your head content here (CSS, title, etc.) -->
</head>

<body>

    <form action="" method="post" class="mb-2">
        <!-- Dropdown for Item ID -->
        <div class="input-group w-90 mb-2">
            <span class="input-group-text bg-info" id="basic-addon1">
                <select class="form-control" name="item_id" aria-label="Item ID" aria-describedby="basic-addon1">
                    <?php
                    $item_query = "SELECT * FROM items";
                    $item_result = mysqli_query($conn, $item_query);
                    while ($item_row = mysqli_fetch_assoc($item_result)) {
                        echo "<option value='" . $item_row['item_id'] . "'>" . $item_row['item_name'] . "</option>";
                    }
                    ?>
                </select>
            </span>
        </div>

        <!-- Input field for Stock Quantity -->
        <input type="text" class="form-control" name="stock_qty" placeholder="Add stock quantity" aria-label="Insert stock quantity" aria-describedby="basic-addon1">

        <!-- Submit button -->
        <div class="input-group w-10 mb-2 m-auto">
            <input type="submit" class="bg-info border-0 p-2 my-3" name="insert_stock" value="Insert stock">
        </div>
    </form>

    <!-- Other HTML content if needed -->

</body>

</html>