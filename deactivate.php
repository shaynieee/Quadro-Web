<?php
include_once("../db.php");

if (isset($_GET['item_id'])) {
    $itemId = $_GET['item_id'];

    // Perform logic to deactivate the item (e.g., update status column)
    $deactivateQuery = "UPDATE items SET item_status = 'I' WHERE item_id = '$itemId'";
    $result = mysqli_query($conn, $deactivateQuery);

    if ($result) {
        header("Location: manage_items.php?msg=y"); // Redirect with success message
        exit();
    } else {
        header("Location: manage_items.php?msg=n"); // Redirect with error message
        exit();
    }
}
?>