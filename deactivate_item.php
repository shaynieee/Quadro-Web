<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deactivate Item</title>
    <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../style.css" />
</head>
<body>
    <div class="container-fluid">
        <h3 class="display-5">Deactivate Item</h3>

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
                $query = "SELECT * FROM items WHERE item_status = '{$status_code}'";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='user-details'>";
                    echo "<p>Item Id: {$row['item_id']}</p>";
                    echo "<p>Item Name: {$row['item_name']}</p>";
                    echo "<p>Item Description: {$row['item_desc']}</p>";

                    // Display buttons for changing item status
                    foreach ($statuses as $actionStatus => $actionStatusCode) {
                        if ($status !== $actionStatus) {
                            echo "<a href='update_item_status.php?status={$actionStatusCode}&item_id={$row['item_id']}' class='btn btn-primary'>Set as {$actionStatus}</a>";
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