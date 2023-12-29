<!DOCTYPE html>
<?php
include_once("../db.php");

// Function to validate selected values
function validateSelectedValue($conn, $table, $column, $selectedValue)
{
    $validate_query = "SELECT $column FROM $table WHERE $column = '$selectedValue'";
    $validate_result = mysqli_query($conn, $validate_query);
    return mysqli_num_rows($validate_result) > 0;
}

if (isset($_POST['insert_item'])) {
    $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $item_desc = mysqli_real_escape_string($conn, $_POST['item_desc']);
    $cat_id = mysqli_real_escape_string($conn, $_POST['cat_id']);
    $stock_id = mysqli_real_escape_string($conn, $_POST['stock_id']);
    $item_status = mysqli_real_escape_string($conn, $_POST['item_status']);
    $price_id = mysqli_real_escape_string($conn, $_POST['price_id']);

    $item_image_name = $_FILES['item_image']['name'];
    $item_image_tmp = $_FILES['item_image']['tmp_name'];
    $item_image_size = $_FILES['item_image']['size'];
    $item_image_error = $_FILES['item_image']['error'];

    if ($item_image_error === 0) {
        $item_image_destination = "../pictures/" . $item_image_name;
        move_uploaded_file($item_image_tmp, $item_image_destination);

        // Add validation for selected values
        $valid_cat = validateSelectedValue($conn, 'categories', 'cat_id', $cat_id);
        $valid_stock = validateSelectedValue($conn, 'stocks', 'stock_id', $stock_id);
        $valid_price = validateSelectedValue($conn, 'pricing', 'price_id', $price_id);

        if ($valid_cat && $valid_stock && $valid_price) {
            $select_query = "SELECT * FROM items WHERE item_name = '$item_name'";
            $result_select = mysqli_query($conn, $select_query);
            $number = mysqli_num_rows($result_select);

            if ($number > 0) {
                echo "<script>alert('This item is already present in the database');</script>";
            } else {
                $insert_query = "INSERT INTO items (item_name, item_desc, cat_id, stock_id, item_status, item_img, price_id) VALUES ('$item_name', '$item_desc', $cat_id, $stock_id, '$item_status', '$item_image_destination', $price_id)";
                $result = mysqli_query($conn, $insert_query);

                if ($result) {
                    echo "<script>alert('Item has been inserted successfully');</script>";
                } else {
                    echo "<script>alert('Error inserting item');</script>";
                }
            }
        } else {
            echo "<script>alert('Invalid selection for category, stock, or price. Please choose valid values.');</script>";
        }
    } else {
        echo "<script>alert('Error uploading file');</script>";
    }
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Item</title>
    <!-- Add your CSS and Bootstrap links here -->
</head>

<body>
    <form action="" method="post" enctype="multipart/form-data" class="mb-2">
        <!-- Item Name -->
        <div class="input-group w-90 mb-2">
            <span class="input-group-text bg-info" id="basic-addon1">
                <input type="text" class="form-control" name="item_name" placeholder="Item Name" aria-label="Item Name" aria-describedby="basic-addon1">
            </span>
        </div>

        <!-- Item Description -->
        <div class="input-group w-90 mb-2">
            <span class="input-group-text bg-info" id="basic-addon1">
                <input type="text" class="form-control" name="item_desc" placeholder="Item Description" aria-label="Item Description" aria-describedby="basic-addon1">
            </span>
        </div>

        <!-- Dropdown for Category ID -->
        <div class="input-group w-90 mb-2">
            <span class="input-group-text bg-info" id="basic-addon1">
                <select class="form-control" name="cat_id" aria-label="Category ID" aria-describedby="basic-addon1">
                    <?php
                    $cat_query = "SELECT * FROM categories";
                    $cat_result = mysqli_query($conn, $cat_query);
                    while ($cat_row = mysqli_fetch_assoc($cat_result)) {
                        echo "<option value='" . $cat_row['cat_id'] . "'>" . $cat_row['cat_name'] . "</option>";
                    }
                    ?>
                </select>
            </span>
        </div>

        <!-- Dropdown for Stock ID -->
        <div class="input-group w-90 mb-2">
            <span class="input-group-text bg-info" id="basic-addon1">
                <select class="form-control" name="stock_id" aria-label="Stock ID" aria-describedby="basic-addon1">
                    <?php
                    $stock_query = "SELECT * FROM stocks";
                    $stock_result = mysqli_query($conn, $stock_query);
                    while ($stock_row = mysqli_fetch_assoc($stock_result)) {
                        echo "<option value='" . $stock_row['stock_id'] . "'>" . $stock_row['stock_qty'] . "</option>";
                    }
                    ?>
                </select>
            </span>
        </div>

        <!-- Other input fields -->
        <div class="input-group w-90 mb-2">
            <span class="input-group-text bg-info" id="basic-addon1">
                <input type="text" class="form-control" name="item_status" placeholder="Item Status" aria-label="Item Status" aria-describedby="basic-addon1">
            </span>
        </div>

        <!-- Dropdown for Price ID -->
        <div class="input-group w-90 mb-2">
            <span class="input-group-text bg-info" id="basic-addon1">
                <select class="form-control" name="price_id" aria-label="Price ID" aria-describedby="basic-addon1">
                    <?php
                    $price_query = "SELECT * FROM pricing";
                    $price_result = mysqli_query($conn, $price_query);
                    while ($price_row = mysqli_fetch_assoc($price_result)) {
                        echo "<option value='" . $price_row['price_id'] . "'>" . $price_row['item_price'] . "</option>";
                    }
                    ?>
                </select>
            </span>
        </div>

        <!-- File Upload for Item Image -->
        <div class="input-group w-90 mb-2">
            <span class="input-group-text bg-info" id="basic-addon1">
                <input type="file" class="form-control" name="item_image"  aria-label="Item Image" aria-describedby="basic-addon1">
            </span>
        </div>

        <!-- Add other input fields if needed -->

        <div class="input-group w-10 mb-2 m-auto">
            <input type="submit" class="bg-info border-0 p-2 my-3" name="insert_item" value="Insert items">
        </div>
    </form>
</body>

</html>