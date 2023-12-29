<?php
include_once("../db.php");

if(isset($_POST['insert_variation'])){
    $variation_name = mysqli_real_escape_string($conn, $_POST['variation_name']);
    $custom_property_id = mysqli_real_escape_string($conn, $_POST['custom_property_id']);
    $variation_price = mysqli_real_escape_string($conn, $_POST['variation_price']);
    $variation_qty = mysqli_real_escape_string($conn, $_POST['variation_qty']);

    $select_query = "SELECT * FROM variation WHERE variation_name = '$variation_name' AND custom_property_id = '$custom_property_id'";
    $result_select = mysqli_query($conn, $select_query);
    $number = mysqli_num_rows($result_select);

    if($number > 0){
        echo "<script>alert('This variation is already present in the database');</script>";
    } else {
        $insert_query = "INSERT INTO variation (variation_name, custom_property_id, variation_price, variation_qty ) VALUES ('$variation_name', '$custom_property_id', '$variation_price', '$variation_qty')";
        $result = mysqli_query($conn, $insert_query);

        if($result){
            echo "<script>alert('Variation has been inserted successfully');</script>";
        } else {
            echo "<script>alert('Error inserting variation');</script>";
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
        <!-- Dropdown for Custom Property ID -->
        <select class="form-control" name="custom_property_id" aria-label="Custom Property ID" aria-describedby="basic-addon1">
            <?php
            $custom_property_query = "SELECT cp.property_name, i.item_name, cp.custom_property_id FROM custom_property cp 
                                      JOIN items i
                                      ON cp.item_id=i.item_id
                                                                  ";
               
            $custom_property_result = mysqli_query($conn, $custom_property_query);
            while ($custom_property_row = mysqli_fetch_assoc($custom_property_result)) {
                echo "<option value='" . $custom_property_row['custom_property_id'] . "'>"  . $custom_property_row['property_name'] . " -". $custom_property_row['item_name']."</option>";
            }
            ?>
        </select>

        <!-- Input field for Variation Name -->
        <input type="text" class="form-control" name="variation_name" placeholder="Add variation" aria-label=" Insert variation" aria-describedby="basic-addon1">

        <!-- Input field for Variation Price -->
        <input type="text" class="form-control" name="variation_price" placeholder="Add variation price" aria-label=" Insert variation price" aria-describedby="basic-addon1">

        <input type="text" class="form-control" name="variation_qty" placeholder="Add variation qty" aria-label=" Insert variation qty" aria-describedby="basic-addon1">
        <!-- Submit button -->
        <div class="input-group w-10 mb-2 m-auto">
            <input type="submit" class="bg-info border-0 p-2 my-3" name="insert_variation" value="Insert variation">
        </div>
    </form>

    <!-- Other HTML content if needed -->

</body>

</html>