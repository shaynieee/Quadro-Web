<?php
session_start();
include("../db.php");
include_once("../function.php");

// Initialize quantities array and total quantity
$item_quantities = array();
$total_quantity = 0;

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove_cart'])) {
        // Call the remove_cart_item function with quantities array
        remove_cart_item($item_quantities);
    } elseif (isset($_POST['checkout'])) {
        // Call the checkout function here (you need to implement this function)
        checkout();
    }
}
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../style.css" />
</head>

<body>
    <?php
    // Check if user ID is set in the session
    if (isset($_SESSION['user_info']['user_id'])) {
        $user_id = $_SESSION['user_info']['user_id'];

        $cart_query = "SELECT cart.cart_id, items.item_name, cart.order_desc, cart.item_qty, cart.total_price 
        FROM cart
        JOIN items ON cart.item_id = items.item_id
        WHERE cart.user_id = $user_id";
        $cart_result = mysqli_query($conn, $cart_query);

        // Display Cart Items
        echo "<form method='post'>";
        echo "<table class='table table-striped'>";
        echo "<thead class='table-dark'>
                <tr>
                    <th scope='col'>Product</th>
                    <th scope='col'>Order Description</th>
                    <th scope='col'>Quantity</th>
                    <th scope='col'>Total</th>
                    <th scope='col'>Remove</th>
                </tr>
            </thead>
            <tbody>";

        $total_amount = 0;

        while ($cart_row = mysqli_fetch_assoc($cart_result)) {
            $total = $cart_row['total_price'];
            $total_amount += $total;

            // Store quantity in the array
            $item_quantities[$cart_row['cart_id']] = $cart_row['item_qty'];

            // Update total quantity
            $total_quantity += $cart_row['item_qty'];

            echo "<tr class='table-light'>";
            echo "<td class='fw-bold'>" . $cart_row['item_name'] . "</td>";
            echo "<td>" . $cart_row['order_desc'] . "</td>";
            echo "<td class='text-center'>" . $cart_row['item_qty'] . "</td>";
            echo "<td class='text-end'>$" . number_format($total, 2) . "</td>";
            echo "<td class='text-end'><input class='form-check-input' type='checkbox' name='remove_items[]' value='" . $cart_row['cart_id'] . "'></td>";
            echo "</tr>";
        }

        // Display total quantity
        echo "<tr class='table-light'>";
        echo "<td colspan='2' class='text-end'><strong>Total Quantity:</strong></td>";
        echo "<td class='text-center'>$total_quantity</td>";
        echo "<td colspan='2'></td>";
        echo "</tr>";

        // Display a row for the total amount and a checkbox for the whole order
        echo "<tr class='table-light'>";
        echo "<td colspan='3' class='text-end'><strong>Total Amount:</strong></td>";
        echo "<td class='text-end'>$" . number_format($total_amount, 2) . "</td>";
        echo "<td class='text-end'><input type='submit' name='remove_cart' value='Remove Selected Items'></td>";
        echo "</tr>";

        // Checkout Button
        echo "<tr class='table-light'>";
        echo "<td colspan='4'></td>";
        echo "<td class='text-end'><input type='submit' name='checkout' value='Checkout'></td>";
        echo "</tr>";

        echo "<tr class='table-light'>";
        echo "<td colspan='4'></td>";
        echo "<td class='text-end'><input type='submit' name='Back' value='Done'></td>";
        echo "</tr>";

        // Close the table
        echo "</tbody></table>";
        echo "</form>";

    } else {
        // Handle the case where user_id is not set
        echo "User ID is not set.";
    }
    ?>
    <!-- Include your JavaScript links here -->
</body>

</html>