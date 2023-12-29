<?php
// Include your database connection file here
include_once("../db.php");

// Check if status and userId are set in the URL
if (isset($_GET['status']) && isset($_GET['variation_id'])) {
    $newStatus = $_GET['status'];
    $variation_id = $_GET['variation_id'];

    // Update item status in the database
    $updateQuery = "UPDATE variation SET variation_status = '{$newStatus}' WHERE variation_id = {$variation_id}";
    mysqli_query($conn, $updateQuery);

    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit();
} else {
    // Handle the case where status or userId is not set in the URL
    echo "Invalid request.";
}
?>