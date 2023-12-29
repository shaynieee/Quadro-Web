<?php
// Include your database connection file here
include_once("../db.php");

// Check if status and userId are set in the URL
if (isset($_GET['status']) && isset($_GET['custom_property_id'])) {
    $newStatus = $_GET['status'];
    $custom_property_id = $_GET['custom_property_id'];

    // Update item status in the database
    $updateQuery = "UPDATE custom_property SET custom_property_status = '{$newStatus}' WHERE custom_property_id = {$custom_property_id}";
    mysqli_query($conn, $updateQuery);

    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit();
} else {
    // Handle the case where status or userId is not set in the URL
    echo "Invalid request.";
}
?>