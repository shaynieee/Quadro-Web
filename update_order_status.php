<?php
include_once("../db.php");

if(isset($_GET['update_order_status']) && isset($_GET['order_reference_number'])) {
    $update_status = $_GET['update_order_status'];
    $order_reference_number = $_GET['order_reference_number'];

    // Validate and sanitize input if necessary

    // Get the current date and time
    $order_confirmation_date = date('Y-m-d H:i:s');

    // Update order status and order confirmation date in the database
    $sql_update_status = "UPDATE orders SET order_status = '$update_status', order_confirmation_date = '$order_confirmation_date' WHERE order_reference_number = '$order_reference_number'";
    mysqli_query($conn, $sql_update_status);

    // Redirect back to the page where the button was clicked
    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit();
} else {
    // Handle invalid or missing parameters
    echo "Invalid request!";
}
?>