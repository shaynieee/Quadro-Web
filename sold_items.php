<?php
session_start();
include_once("../db.php");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Item Sales</title>
    <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../style.css" />
</head>

<body>

    <?php
    // Calculate total quantity sold for each item
    $totalItemSalesQuery = "SELECT items.item_name, SUM(orders.order_qty) AS total_quantity_sold
                            FROM orders
                            JOIN items ON orders.item_id = items.item_id
                            GROUP BY items.item_id, items.item_name";
    $totalItemSalesResult = mysqli_query($conn, $totalItemSalesQuery);
    ?>

    <div class="container">
        <h2>Total Quantity Sold for Each Item</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Total Quantity Sold</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($totalItemSalesResult)) {
                    echo "<tr>";
                    echo "<td>{$row['item_name']}</td>";
                    echo "<td>{$row['total_quantity_sold']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>