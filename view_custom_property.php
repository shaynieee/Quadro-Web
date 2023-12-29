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
                   <th>Custom Property ID</th>
                    <th>Item Id</th>
                    <th>Custom Property Name</th>
                    <th>Custom Property Status</th>
                    <th>Edit</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody class="bg-secondary text-light">
                <?php
                $get_custom_property = "SELECT custom_property.*, items.item_id
                            FROM custom_property
                            INNER JOIN items ON items.item_id = custom_property.item_id";
                        
                $result = mysqli_query($conn, $get_custom_property);
                while ($row = mysqli_fetch_assoc($result)) {
                    $custom_property_id=$row['custom_property_id'];
                    $item_id = $row['item_id'];
                    $custom_property_name = $row['property_name'];
                    $custom_property_status=$row['custom_property_status'];
                   ?>
                    <tr class='text-center'>
                        <td><?php echo $custom_property_id; ?></td>
                        <td><?php echo $item_id; ?></td>
                        <td><?php echo $custom_property_name; ?></td>
                        <td><?php echo $custom_property_status; ?></td>
                        <td><a href='edit_custom_property.php' class='btn btn-primary btn-sm'>Edit</a></td>
                        <td><a href='deact_custom_property.php' class='btn btn-primary btn-sm'>Remove</a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>