<?php include_once ("db.php"); ?>
<?php 
function gen_order_refnum($len){
    $alpha_num=array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H','I','J',
                     'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',
                     'U', 'V', 'W', 'X', 'Y', 'Z', '0', '0', '1','2',
                     '3', '4', '5','6','7','8','9','a','b','c','d','e','f');
        $key="";
        for($i=1; $i<=$len; $i++)
        {
            if($i%2==0 && $i>0)
            {
                $key.=$alpha_num[rand(0,25)];
            }
            else{
                $key.=$alpha_num[rand(26, sizeof($alpha_num)-1)];
            }
        }
        return $key;  
}

// Function to remove items from the cart
function remove_cart_item(){
    global $conn;
    
    if(isset($_POST['remove_cart'])){
        foreach($_POST['remove_items'] as $remove_id){
            // Update the status to 'cancel' for the removed item
            $update_status_query = "UPDATE cart SET cart_status = 'C' WHERE `cart_id` = $remove_id";
            $run_update_status = mysqli_query($conn, $update_status_query);

            if(!$run_update_status){
                echo "<script> console.error('Error updating status:', " . mysqli_error($conn) . ");</script>";
            }

            // Delete the item from the cart
            $delete_query = "DELETE FROM cart WHERE `cart_id` = $remove_id";
            $run_delete = mysqli_query($conn, $delete_query);

            if(!$run_delete){
                echo "<script> console.error('Error removing item:', " . mysqli_error($conn) . ");</script>";
            }
        }
    }
}


function checkout() {
    global $conn; // Assuming $conn is your database connection

    // Retrieve user ID from the session
    $user_id = $_SESSION['user_info']['user_id'];

    // Generate a unique order reference number using your custom function
    $order_reference = gen_order_refnum(8); // Adjust the length as needed

    // Retrieve the cart items to process
    $cart_query = "SELECT * FROM cart WHERE user_id = $user_id AND cart_status = 'P'";
    $cart_result = mysqli_query($conn, $cart_query);

    // Check if there are items in the cart with 'P' status
    if (mysqli_num_rows($cart_result) > 0) {
        // Initialize arrays to store item details for orders table
        $item_quantities = array();
        $total_quantity = 0;

        // Iterate through cart items
        while ($cart_row = mysqli_fetch_assoc($cart_result)) {
            // Store quantity, total price, and order description in the array
            $item_quantities[$cart_row['cart_id']] = array(
                'item_id' => $cart_row['item_id'],
                'item_qty' => $cart_row['item_qty'],
                'order_desc' => $cart_row['order_desc'],
                'total_price' => $cart_row['total_price']
            );

            // Update total quantity
            $total_quantity += $cart_row['item_qty'];
        }

        // Insert selected items into the orders table
        foreach ($item_quantities as $cart_id => $item_info) {
            $item_id = $item_info['item_id'];
            $quantity = $item_info['item_qty'];
            $order_desc = $item_info['order_desc'];
            $total_price = $item_info['total_price'];

            // Modify the INSERT query according to your orders table structure
            $insert_query = "INSERT INTO `orders` (`user_id`, `item_id`, `order_qty`, `total_amount`,  `order_description`, `order_reference_number`)
                             VALUES ('$user_id', '$item_id', '$quantity', '$total_price', '$order_desc', '$order_reference')";

            mysqli_query($conn, $insert_query);
        }

        // Update the status of items in the cart to indicate they have been checked out
        $update_query = "UPDATE cart SET cart_status = 'O' WHERE user_id = $user_id AND cart_status = 'P'";
        mysqli_query($conn, $update_query);

        // Remove items from the cart after successful checkout
        $delete_query = "DELETE FROM cart WHERE user_id = $user_id AND cart_status = 'O'";
        mysqli_query($conn, $delete_query);

        // Redirect the user to checkout.php after successful checkout
        header("Location: checkout.php");
        exit(); // Make sure to exit to prevent further execution
    } else {
        // Handle the case where there are no items with 'P' status in the cart
        echo "No items to checkout.";
    }

    // You can add more actions related to the checkout process here
}
?>