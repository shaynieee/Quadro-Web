<?php
include_once("../db.php");
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN PAGE</title>
    <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../style.css" />
</head>

<body>
    <div class="container my-5">
        <h3 class="text-center text-success">ITEMS</h3>
        <table class="table table-bordered mt-5">
            <thead class="bg-info">
                <tr>
                   <th>Price ID</th>
                    <th>Item ID</th>
                    <th>Item Price</th>
                    <th>Price Status</th>
                    <th>Edit</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody class="bg-secondary text-light">
                <?php
                $get_pricing= "SELECT pricing.*, items.item_id
                            FROM pricing
                            INNER JOIN items ON items.item_id = pricing.item_id";
                        
                $result = mysqli_query($conn, $get_pricing);
                while ($row = mysqli_fetch_assoc($result)) {
                    $price_id=$row['price_id'];
                    $item_id = $row['item_id'];
                    $item_price = $row['item_price'];
                    $price_stat=$row['price_status'];
                   ?>
                    <tr class='text-center'>
                        <td><?php echo $price_id; ?></td>
                        <td><?php echo $item_id; ?></td>
                        <td><?php echo $item_price; ?></td>
                        <td><?php echo $price_stat; ?></td>
                        <td><a href='edit_price.php' class='btn btn-primary btn-sm'>Edit</a></td>
                        <td><a href='deact_pricng.php' class='btn btn-primary btn-sm'>Remove</a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>