<?php
session_start();
include_once("../db.php");

if (!isset($_SESSION['user_info']['user_id'])) {
    header("location: index.php");  // Redirect to index or login page if the user is not logged in
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customization</title>
    <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../style.css" />
</head>

<body>

    <?php
    // Ensure the necessary variables are set
    if (isset($_GET['item_id'])) {
        $item_id = $_GET['item_id'];

        // Fetch customization details based on the item ID
        $sql_get_property = "SELECT * FROM custom_property WHERE item_id = ? AND custom_property_status = 'A'";
        $property_stmt = mysqli_prepare($conn, $sql_get_property);
        mysqli_stmt_bind_param($property_stmt, "i", $item_id);
        mysqli_stmt_execute($property_stmt);
        $property_result = mysqli_stmt_get_result($property_stmt);

        echo "<form action='' method='post'>"; // Changed method to 'post' for better security
        echo "<ul>";

        while ($prop = mysqli_fetch_array($property_result)) {
            echo "<li>" . $prop['property_name'] . "</li>";
            $custom_property_id = $prop['custom_property_id'];

            $sql_get_variation = "SELECT * FROM variation WHERE custom_property_id = ? AND variation_status = 'A'";
            $variation_stmt = mysqli_prepare($conn, $sql_get_variation);
            mysqli_stmt_bind_param($variation_stmt, "i", $custom_property_id);
            mysqli_stmt_execute($variation_stmt);
            $variation_result = mysqli_stmt_get_result($variation_stmt);

            echo "<ol>";
            while ($var = mysqli_fetch_array($variation_result)) {
                ?>
                <input type="radio" name="property_<?php echo $custom_property_id; ?>" value="<?php echo $var['variation_name'] . ":" . $var['variation_price']; ?>" id="variation_<?php echo $var['variation_id']; ?>" class="btn btn-success" autocomplete="off">
                <label class="btn btn-outline-success" for="variation_<?php echo $var['variation_id']; ?>"><?php echo $var['variation_name']; ?></label>
                <?php
            }

            echo "</ol>";
        }

        echo "<br>";
        echo "<label for='quantity'> QUANTITY:</label>";
        echo "<input type='number' name='item_qty' value='1' min='1'>"; // Added 'min' attribute
        echo "<br>";
        echo "</ul>";

        echo "<input type='submit' name='order_custom' value='SUBMIT'>";
        echo "<input type='hidden' name='item_id' value='$item_id'>"; // Added hidden input for item_id

        echo "</form>";
    }

    if (isset($_POST['order_custom'])) {
        if (!isset($_SESSION['user_info']['user_id'])) {
            echo "User ID is not set. Please log in.";
            exit();
        }

        $item_id = $_POST['item_id'];
        $user_id = $_SESSION['user_info']['user_id'];
        
        // Process customization details and calculate total price
        $new_order_desc = "";
        $total_price = 0;

        foreach ($_POST as $var => $value) {
            if ($var != 'chk_item' && $var != 'order_custom' && strpos($var, 'property_') !== false) {
                $new_order_desc .= ":" . $value;
                list($variation_name, $variation_price) = explode(":", $value);

                $quantity = isset($_POST['item_qty']) ? intval($_POST['item_qty']) : 1;
                $total_price += floatval($variation_price) * $quantity;
            }
        }

        $insert_cart_sql = "INSERT INTO cart (user_id, item_id, order_desc, item_qty, total_price, date_added, cart_status) VALUES (?, ?, ?, ?, ?, NOW(), 'Pending')";
        $insert_cart_stmt = mysqli_prepare($conn, $insert_cart_sql);
        mysqli_stmt_bind_param($insert_cart_stmt, "iissd", $user_id, $item_id, $new_order_desc, $quantity, $total_price);

        if (mysqli_stmt_execute($insert_cart_stmt)) {
            echo "Item added to cart successfully.";
        } else {
            echo "Error adding item to cart: " . mysqli_error($conn);
        }

        echo "<hr>";
        echo "Order_description: " . $new_order_desc . "<br>";
        echo "Total Price: " . $total_price;
    }
    ?>
    
</body>

</html>