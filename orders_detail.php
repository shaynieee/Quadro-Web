<?php include_once("../db.php"); 
session_start();

function get_total_sales_orders($conn){
    $sql_get_sales = "SELECT *FROM orders WHERE sum(i.total_amount * mo.order_qty) salees 
                        ";
   $sales_result = mysqli_query($conn, $sql_get_sales);
   $row = mysqli_fetch_array($sales_result);
   
    return "Php ".number_format($row['sales'],2);
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../style.css" />

</head>
<body>
                
                     
                      <div class="container-fluid">
                      <h3 class="display-5">Manage Orders (Multi Order)</h3>
                          <div class="row">
                              <div class="col-4">
                           
    <h3>Pending</h3>
    <?php
    $sql_get_pending = "SELECT DISTINCT mo.order_reference_number, u.user_fullname, u.user_address
                            FROM orders mo
                            JOIN users u ON mo.user_id = u.user_id
                            WHERE mo.order_status = 'P'";
    $pending_result = mysqli_query($conn, $sql_get_pending);

    while ($row = mysqli_fetch_assoc($pending_result)) {
        $ord_ref_num = $row['order_reference_number'];
        $user = $row['user_fullname'];
        $address = $row['user_address'];

        echo "<em>" . $ord_ref_num . "</em> - <a>" . $user . "</a> <br>";
        echo "<small>" . $address . "</small> ";

        $sql_get_orders = "SELECT i.item_name, mo.order_description, i.item_img, mo.order_qty, mo.total_amount
                            FROM orders mo
                            JOIN items i ON mo.item_id = i.item_id
                            WHERE mo.order_reference_number = '$ord_ref_num'";
        $orders_result = mysqli_query($conn, $sql_get_orders);

        $totalOrderAmount = 0;

        echo "<ul>";
        while ($order = mysqli_fetch_assoc($orders_result)) {
            $actualAmount = $order['order_qty'] * $order['total_amount'];
            $totalOrderAmount += $actualAmount;

            echo "<li>" . $order['item_name'] . " - " . $order['order_description'] . " - Actual Amount: Php " . number_format($actualAmount, 2) . "</li>";
        }
        echo "</ul>";

        echo "Total Order Amount: Php " . number_format($totalOrderAmount, 2);

        ?>
        <a href="update_order_status.php?update_order_status=D&order_reference_number=<?php echo $ord_ref_num; ?>" class="btn btn-success btn-sm">Delivered</a>
        <a href="update_order_status.php?update_order_status=C&order_reference_number=<?php echo $ord_ref_num; ?>" class="btn btn-danger btn-sm">Cancel</a>
        <hr>
    <?php
    }
    ?>
</div>

<div class="col-4">
    <h3>Delivered</h3>
    <?php
    $sql_get_delivered = "SELECT DISTINCT mo.order_reference_number, u.user_fullname, u.user_address
                            FROM orders mo
                            JOIN users u ON mo.user_id = u.user_id
                            WHERE mo.order_status = 'D'";
    $delivered_result = mysqli_query($conn, $sql_get_delivered);

    while ($row = mysqli_fetch_assoc($delivered_result)) {
        $ord_ref_num = $row['order_reference_number'];
        $user = $row['user_fullname'];
        $address = $row['user_address'];

        echo "<em>" . $ord_ref_num . "</em> - <a>" . $user . "</a> <br>";
        echo "<small>" . $address . "</small> ";

        $sql_get_orders = "SELECT i.item_name, mo.order_description, i.item_img, mo.order_qty, mo.total_amount
                            FROM orders mo
                            JOIN items i ON mo.item_id = i.item_id
                            WHERE mo.order_reference_number = '$ord_ref_num'";
        $orders_result = mysqli_query($conn, $sql_get_orders);

        $totalOrderAmount = 0;

        echo "<ul>";
        while ($order = mysqli_fetch_assoc($orders_result)) {
            $actualAmount = $order['order_qty'] * $order['total_amount'];
            $totalOrderAmount += $actualAmount;

            echo "<li>" . $order['item_name'] . " - " . $order['order_description'] . " - Actual Amount: Php " . number_format($actualAmount, 2) . "</li>";
        }
        echo "</ul>";

        echo "Total Order Amount: Php " . number_format($totalOrderAmount, 2);

        ?>
        <hr>
    <?php
    }
    ?>
</div>

<div class="col-4">
    <h3>Cancelled</h3>
    <?php
    $sql_get_cancelled = "SELECT DISTINCT mo.order_reference_number, u.user_fullname, u.user_address
                            FROM orders mo
                            JOIN users u ON mo.user_id = u.user_id
                            WHERE mo.order_status = 'C'";
    $cancelled_result = mysqli_query($conn, $sql_get_cancelled);

    while ($row = mysqli_fetch_assoc($cancelled_result)) {
        $ord_ref_num = $row['order_reference_number'];
        $user = $row['user_fullname'];
        $address = $row['user_address'];

        echo "<em>" . $ord_ref_num . "</em> - <a>" . $user . "</a> <br>";
        echo "<small>" . $address . "</small> ";

        $sql_get_orders = "SELECT i.item_name, mo.order_description, i.item_img, mo.order_qty, mo.total_amount
                            FROM orders mo
                            JOIN items i ON mo.item_id = i.item_id
                            WHERE mo.order_reference_number = '$ord_ref_num'";
        $orders_result = mysqli_query($conn, $sql_get_orders);

        $totalOrderAmount = 0;

        echo "<ul>";
        while ($order = mysqli_fetch_assoc($orders_result)) {
            $actualAmount = $order['order_qty'] * $order['total_amount'];
            $totalOrderAmount += $actualAmount;

            echo "<li>" . $order['item_name'] . " - " . $order['order_description'] . " - Actual Amount: Php " . number_format($actualAmount, 2) . "</li>";
        }
        echo "</ul>";

        echo "Total Order Amount: Php " . number_format($totalOrderAmount, 2);

        ?>
        <hr>
    <?php
    }
    ?>
</div>
</body>
</html>