
<?php
// Include your database connection file here
include_once("../db.php");

// Check if status and userId are set in the URL
if (isset($_GET['status']) && isset($_GET['userId'])) {
    $newStatus = $_GET['status'];
    $userId = $_GET['userId'];

    // Update user status in the database
    $updateQuery = "UPDATE users SET user_status = '{$newStatus}' WHERE user_id = {$userId}";
    mysqli_query($conn, $updateQuery);

    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit();
} else {
    // Handle the case where status or userId is not set in the URL
    echo "Invalid request.";
}
?>