<?php
session_start();
include_once("../db.php");

if (!isset($_SESSION['user_info']['user_id'])) {
    header("location: index.php");  // Redirect to index or login page if user is not logged in
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../style.css" />
</head>

<body>

    <?php
    $user_id = $_SESSION['user_info']['user_id'];

    // Fetch pending orders with item details
    $pending_orders_query = "SELECT orders.*, items.item_name 
                            FROM orders 
                            JOIN items ON orders.item_id = items.item_id 
                            WHERE orders.user_id = $user_id AND orders.order_status = 'P'";
    $pending_orders_result = mysqli_query($conn, $pending_orders_query);

    // Fetch delivered orders with item details
    $delivered_orders_query = "SELECT orders.*, items.item_name 
                              FROM orders 
                              JOIN items ON orders.item_id = items.item_id 
                              WHERE orders.user_id = $user_id AND orders.order_status = 'D'";
    $delivered_orders_result = mysqli_query($conn, $delivered_orders_query);

    // Fetch cancelled orders with item details
    $cancelled_orders_query = "SELECT orders.*, items.item_name 
                              FROM orders 
                              JOIN items ON orders.item_id = items.item_id 
                              WHERE orders.user_id = $user_id AND orders.order_status = 'C'";
    $cancelled_orders_result = mysqli_query($conn, $cancelled_orders_query);
    ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <!-- Display Pending Orders -->
                <h4>Pending Orders</h4>
                <?php
                while ($order = mysqli_fetch_assoc($pending_orders_result)) {
                    displayOrderDetails($order);
                    echo "<hr>";
                }
                ?>
            </div>

            <div class="col-md-4">
                <!-- Display Delivered Orders -->
                <h4>Delivered Orders</h4>
                <?php
                while ($order = mysqli_fetch_assoc($delivered_orders_result)) {
                    displayOrderDetails($order);
                    echo "<hr>";
                }
                ?>
            </div>

            <div class="col-md-4">
                <!-- Display Cancelled Orders -->
                <h4>Cancelled Orders</h4>
                <?php
                while ($order = mysqli_fetch_assoc($cancelled_orders_result)) {
                    displayOrderDetails($order);
                    echo "<hr>";
                }
                ?>
            </div>
        </div>
    </div>

</body>

</html>

<?php
// Function to display order details
function displayOrderDetails($order)
{
    echo "<div>";
    echo "<p>Item Name: " . $order['item_name'] . "</p>";
    echo "<p>Date Ordered: " . $order['date_ordered'] . "</p>";
    echo "<p>Order Quantity: " . $order['order_qty'] . "</p>";
    echo "<p>Total Amount: " . $order['total_amount'] . "</p>";
    echo "<p>Order Reference Number: " . $order['order_reference_number'] . "</p>";
    echo "<p>Order Description: " . $order['order_description'] . "</p>";
    echo "<p>Order Confirmation Date: " . $order['order_confirmation_date'] . "</p>";
    echo "</div>";
}
?>