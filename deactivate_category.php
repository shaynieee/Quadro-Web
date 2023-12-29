<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deactivate Category</title>
    <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../style.css" />
</head>
<body>
    <div class="container-fluid">
        <h3 class="display-5">Deactivate Category</h3>

        <div class="row">
            <?php
            // Include your database connection file here
            include_once("../db.php");

            // Fetch and display users based on status
            $statuses = array('Active' => 'A', 'Inactive' => 'I');

            foreach ($statuses as $status => $status_code) {
                echo "<div class='col-6'>";
                echo "<h3>{$status}</h3>";

                // Fetch and display users based on status
                $query = "SELECT * FROM categories WHERE cat_status = '{$status_code}'";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='user-details'>";
                    echo "<p>Category Id: {$row['cat_id']}</p>";
                    echo "<p>Category Name: {$row['cat_name']}</p>";
                    echo "<p> Category Description: {$row['cat_description']}</p>";

                    // Display buttons for changing item status
                    foreach ($statuses as $actionStatus => $actionStatusCode) {
                        if ($status !== $actionStatus) {
                            echo "<a href='update_category_status.php?status={$actionStatusCode}&cat_id={$row['cat_id']}' class='btn btn-primary'>Set as {$actionStatus}</a>";
                        }
                    }

                    echo "</div>";
                }

                echo "</div>";
            }
            ?>
        </div>
    </div>

    <script src="../bootstrap-5.3.2-dist/js/bootstrap.js"></script>
</body>
</html>