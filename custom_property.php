<?php
include_once("../db.php");

if(isset($_POST['insert_custom_property'])){
    $property_name = mysqli_real_escape_string($conn, $_POST['property_name']);
    $item_id = mysqli_real_escape_string($conn, $_POST['item_id']);

    $select_query = "SELECT * FROM custom_property WHERE property_name = '$property_name' AND item_id = $item_id";
    $result_select = mysqli_query($conn, $select_query);
    $number = mysqli_num_rows($result_select);

    if($number > 0){
        echo "<script>alert('This is already present in the database');</script>";
    } else {
        $insert_query = "INSERT INTO custom_property (property_name, item_id) VALUES ('$property_name', '$item_id')";
        $result = mysqli_query($conn, $insert_query);

        if($result){
            echo "<script>alert('Custom property has been inserted successfully');</script>";
        }
    }
}
?>

<form action="" method="post" class="mb-2">
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

    <input type="text" class="form-control" name="property_name" placeholder="Add custom name" aria-label="Insert Custom property" aria-describedby="basic-addon1">

    <div class="input-group w-10 mb-2 m-auto">
        <input type="submit" class="bg-info border-0 p-2 my-3" name="insert_custom_property" value="Insert custom property">
    </div>
</form>