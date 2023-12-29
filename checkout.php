<?php
session_start();
include("../db.php");

// Check if the user is logged in
if (!isset($_SESSION['user_info']['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get payment method and reference number
    $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';
    $reference_number = isset($_POST['reference_number']) ? $_POST['reference_number'] : '';

    // Get user information from the session
    $user_id = $_SESSION['user_info']['user_id'];

    // Fetch user's orders from the database, excluding 'Delivered' and 'Cancelled' orders
    $order_query = "SELECT orders.order_id, orders.order_reference_number, orders.order_description, 
                    orders.total_amount, orders.date_ordered, orders.order_status, items.item_name
                    FROM orders
                    INNER JOIN items ON orders.item_id = items.item_id
                    WHERE orders.user_id = $user_id
                    AND orders.order_status NOT IN ('D', 'C')";

    $order_result = mysqli_query($conn, $order_query);

    // Check if there are orders
    if (mysqli_num_rows($order_result) > 0) {
        // Display user's orders
        echo "<h3>Your Orders</h3>";
        while ($order_row = mysqli_fetch_assoc($order_result)) {
            echo "<p>Order ID: {$order_row['order_id']}</p>";
            echo "<p>Item Name: {$order_row['item_name']}</p>";
            echo "<p>Order Reference: {$order_row['order_reference_number']}</p>";
            echo "<p>Order Description: {$order_row['order_description']}</p>";
            echo "<p>Total Amount: {$order_row['total_amount']}</p>";
            echo "<p>Order Date: {$order_row['date_ordered']}</p>";
            // Add more order details as needed
            echo "<hr>";

            // Check if the order status is not 'Delivered' or 'Cancelled'
            if ($order_row['order_status'] != 'D' && $order_row['order_status'] != 'C') {
                // Insert payment method details into the payment_method table
                $insert_payment_query = "INSERT INTO payment_method (user_id, order_id, payment_method, reference) 
                                        VALUES ($user_id, {$order_row['order_id']}, '$payment_method', '$reference_number')";
                mysqli_query($conn, $insert_payment_query);
            }
        }

        // Display total amount
        echo "<h3>TOTAL AMOUNT ORDER: $total_amount</h3>";

        // Redirect or perform other actions after successful insertion
        header("Location: index.php");
        exit();
    } else {
        echo "<p>No orders found.</p>";
    }
}

// Get user information from the session
$user_fullname = isset($_SESSION['user_global_info']['user_fullname']) ? $_SESSION['user_global_info']['user_fullname'] : '';
$contact_number = isset($_SESSION['user_global_info']['contact_number']) ? $_SESSION['user_global_info']['contact_number'] : '';
$email_address = isset($_SESSION['user_global_info']['email_address']) ? $_SESSION['user_global_info']['email_address'] : '';
$user_address = isset($_SESSION['user_global_info']['user_address']) ? $_SESSION['user_global_info']['user_address'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../style.css" />
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2>Checkout Information</h2>
                <!-- ... (your existing user information display) -->
                <p>User ID: <?php echo $_SESSION['user_info']['user_id']; ?></p>
                <p>Username: <?php echo $_SESSION['user_info']['username']; ?></p>
                <p>User Fullname: <?php echo $user_fullname; ?></p>
                <p>Contact Number: <?php echo $contact_number; ?></p>
                <p>Email Address: <?php echo $email_address; ?></p>
                <p>User Address: <?php echo $user_address; ?></p>

                <hr>

                <?php
                $total_amount = 0;
                // Fetch user's orders from the database, excluding 'Delivered' and 'Cancelled' orders
                $user_id = $_SESSION['user_info']['user_id'];
                $order_query = "SELECT orders.order_id, orders.order_reference_number, orders.order_description, 
                                orders.total_amount, orders.date_ordered, orders.order_status, items.item_name
                                FROM orders
                                INNER JOIN items ON orders.item_id = items.item_id
                                WHERE orders.user_id = $user_id
                                AND orders.order_status NOT IN ('D', 'C')";

                $order_result = mysqli_query($conn, $order_query);

                // Check if there are orders
                if (mysqli_num_rows($order_result) > 0) {
                    // Display user's orders
                    echo "<h3>Your Orders</h3>";
                    while ($order_row = mysqli_fetch_assoc($order_result)) {
                        echo "<p>Order ID: {$order_row['order_id']}</p>";
                        echo "<p>Item Name: {$order_row['item_name']}</p>";
                        echo "<p>Order Reference: {$order_row['order_reference_number']}</p>";
                        echo "<p>Order Description: {$order_row['order_description']}</p>";
                        echo "<p>Total Amount: {$order_row['total_amount']}</p>";
                        echo "<p>Order Date: {$order_row['date_ordered']}</p>";
                        // Add more order details as needed
                        echo "<hr>";

                        $total_amount += $order_row['total_amount'];
                    }
                    echo "<h3>TOTAL AMOUNT ORDER: $total_amount</h3>";
                } else {
                    echo "<p>No orders found.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <form method="post">
                    <h3>Select Payment Method</h3>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" value="COD" required>
                        <label class="form-check-label">Cash on Delivery (COD)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_method" value="GCash" required>
                        <label class="form-check-label">GCash</label>
                    <input type="text" name="reference_number" placeholder="Enter GCash Reference Number">
                                            <br>
                                            <img src='../pictures/gcash1.jpg' alt='Payment Scan Image' id='payment_scan' width='50%' height='50%'>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Place Order</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <script src="../bootstrap-5.3.2-dist/js/bootstrap.js"></script>
</body>
</html>