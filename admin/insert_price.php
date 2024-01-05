
You sent
<?php
include_once("../db.php");

if(isset($_POST['insert_pricing'])){
    $item_id = mysqli_real_escape_string($conn, $_POST['item_id']);
    $item_price = mysqli_real_escape_string($conn, $_POST['item_price']);
    
    $select_query = "SELECT * FROM pricing WHERE item_id = '$item_id'";
    $result_select = mysqli_query($conn, $select_query);
    $number = mysqli_num_rows($result_select);

    if($number > 0){
        echo "<script>alert('Pricing for this item is already present in the database');</script>";
    } else {
        $insert_query = "INSERT INTO pricing (item_id, item_price) VALUES ('$item_id', '$item_price')";
        $result = mysqli_query($conn, $insert_query);

        if($result){
            echo "<script>alert('Pricing has been inserted successfully');</script>";
        } else {
            echo "<script>alert('Error inserting pricing');</script>";
        }
    }
}
?>

<!DOCTYPE html>
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

        <!-- Input field for Item Price -->
        <input type="text" class="form-control" name="item_price" placeholder="Add item price" aria-label=" Insert item price" aria-describedby="basic-addon1">

        <!-- Submit button -->
        <div class="input-group w-10 mb-2 m-auto">
            <input type="submit" class="bg-info border-0 p-2 my-3" name="insert_pricing" value="Insert pricing">
        </div>
    </form>

    <!-- Other HTML content if needed -->

</body>

</html>