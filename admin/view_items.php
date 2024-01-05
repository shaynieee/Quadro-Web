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
                    <th>Item Id</th>
                    <th>Item Name</th>
                    <th>Item Description</th>
                    <th>Item Category</th>
                    <th>Item Stock</th>
                    <th>Item Status</th>
                    <th>Item Price</th>
                    <th>Item Image</th>
                    <th>Edit</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody class="bg-secondary text-light">
                <?php
                $get_items = "SELECT items.*, categories.cat_name, stocks.stock_qty, pricing.item_price
                            FROM items
                            INNER JOIN categories ON items.cat_id = categories.cat_id
                            INNER JOIN stocks ON items.stock_id = stocks.stock_id
                            INNER JOIN pricing ON items.price_id = pricing.price_id";
                $result = mysqli_query($conn, $get_items);
                while ($row = mysqli_fetch_assoc($result)) {
                    $item_id = $row['item_id'];
                    $item_name = $row['item_name'];
                    $item_desc = $row['item_desc'];
                    $cat_name = $row['cat_name'];
                    $stock_name = $row['stock_qty'];
                    $item_status = $row['item_status'];
                    $item_price = $row['item_price'];
                    $item_image = $row['item_img'];
                    ?>
                    <tr class='text-center'>
                        <td><?php echo $item_id; ?></td>
                        <td><?php echo $item_name; ?></td>
                        <td><?php echo $item_desc; ?></td>
                        <td><?php echo $cat_name; ?></td>
                        <td><?php echo $stock_name; ?></td>
                        <td><?php echo $item_status; ?></td>
                        <td><?php echo $item_price; ?></td>
                        <td><img src='../pictures/<?php echo $item_image; ?>' class='proimg' width='50' height='50' /></td>
                        <td><a href='edit_items.php?item_id=<?php echo $item_id; ?>' class='btn btn-primary btn-sm'>Edit</a></td>
                        <td><a href='deactivate_item.php' class='btn btn-primary btn-sm'>Remove</a></td>
                    </tr>
                <?php
                
            }
          
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>