<?php
include_once("../db.php");
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIEW CATEGORIES</title>
    <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../style.css" />
</head>

<body>
    <div class="container my-5">
        <h3 class="text-center text-success">ITEMS</h3>
        <table class="table table-bordered mt-5">
            <thead class="bg-info">
                <tr>
                    <th>Categories ID</th>
                    <th>Categories Name</th>
                    <th>Categories Description</th>
                    <th>Categories Image</th>
                    <th>Categories Status</th>
                    <th>Edit</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody class="bg-secondary text-light">
                <?php
                $get_categories = "SELECT * FROM categories";
                        
                $result = mysqli_query($conn, $get_categories);
                while ($row = mysqli_fetch_assoc($result)) {
                    $cat_id=$row['cat_id'];
                    $cat_name= $row['cat_name'];
                    $cat_desc= $row['cat_description'];
                    $cat_img= $row['cat_image'];
                    $cat_status= $row['cat_status'];
                
                   ?>
                    <tr class='text-center'>
                        <td><?php echo $cat_id; ?></td>
                        <td><?php echo  $cat_name; ?></td>
                        <td><?php echo $cat_desc; ?></td>
                        <td><?php echo $cat_img; ?></td>
                        <td><?php echo $cat_status; ?></td>
                        <td><a href='edit_categories.php' class='btn btn-primary btn-sm'>Edit</a></td>
                        <td><a href='deactivate_category.php' class='btn btn-primary btn-sm'>Remove</a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>