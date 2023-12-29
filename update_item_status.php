<?php
// Include your database connection file here
include_once("../db.php");

// Check if status and userId are set in the URL
if (isset($_GET['status']) && isset($_GET['item_id'])) {
    $newStatus = $_GET['status'];
    $item_id = $_GET['item_id'];

    // Update item status in the database
    $updateQuery = "UPDATE items SET item_status = '{$newStatus}' WHERE item_id = {$item_id}";
    mysqli_query($conn, $updateQuery);

    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit();
} else {
    // Handle the case where status or userId is not set in the URL
    echo "Invalid request.";
}
?>