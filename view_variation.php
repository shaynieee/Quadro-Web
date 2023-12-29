<?php
include_once("../db.php");
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIEW VARIATION</title>
    <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../style.css" />
</head>

<body>
    <div class="container my-5">
        <h3 class="text-center text-success">ITEMS</h3>
        <table class="table table-bordered mt-5">
            <thead class="bg-info">
                <tr>
                   <th>Variation ID</th>
                    <th>Custom Property ID</th>
                    <th>Variation Name</th>
                    <th>Variation Price</th>
                    <th>Variation Quantity</th>
                    <th>Variation Status</th>
                    <th>Edit</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody class="bg-secondary text-light">
                <?php
                $get_variation = "SELECT variation.*, custom_property.property_name
                            FROM variation
                            INNER JOIN custom_property ON custom_property.custom_property_id = variation.custom_property_id";
                        
                $result = mysqli_query($conn, $get_variation);
                while ($row = mysqli_fetch_assoc($result)) {
                    $variation=$row['variation_id'];
                    $custom_property_id = $row['custom_property_id'];
                    $variation_name = $row['variation_name'];
                    $variation_price = $row['variation_price'];
                    $variation_qty = $row['variation_qty'];
                    $variation_status = $row['variation_status'];
                   ?>
                    <tr class='text-center'>
                        <td><?php echo $variation; ?></td>
                        <td><?php echo  $custom_property_id; ?></td>
                        <td><?php echo $variation_name; ?></td>
                        <td><?php echo $variation_price; ?></td>
                        <td><?php echo $variation_qty; ?></td>
                        <td><?php echo $variation_status; ?></td>
                        <td><a href='edit_variation.php' class='btn btn-primary btn-sm'>Edit</a></td>
                        <td><a href='deact-variation.php' class='btn btn-primary btn-sm'>Remove</a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>