<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../style.css" />
</head>
<body>
    <div class="container-fluid">
        <h3 class="display-5">Manage Users</h3>

        <?php
        // Include your database connection file here
        include_once("../db.php");

        // Fetch and display user details based on status
        $statuses = array('Active' => 'A', 'Inactive' => 'I', 'Banned' => 'B');

        foreach ($statuses as $status => $status_code) {
            echo "<div class='col-4'>";
            echo "<h3>{$status}</h3>";

            // Fetch and display users based on status
            $query = "SELECT * FROM users WHERE user_status = '{$status_code}'";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='user-details'>";
                echo "<p>User ID: {$row['user_id']}</p>";
                echo "<p>User Fullname: {$row['user_fullname']}</p>";
                echo "<p>Contact Number: {$row['contact_number']}</p>";

                // Display buttons for changing user status
                foreach ($statuses as $actionStatus => $actionStatusCode) {
                    if ($status !== $actionStatus) {
                        echo "<a href='update_user_status.php?status={$actionStatusCode}&userId={$row['user_id']}' class='btn btn-primary'>Set as {$actionStatus}</a>";
                    }
                }

                echo "</div>";
            }

            echo "</div>";
        }
        ?>
    </div>

    <script src="../bootstrap-5.3.2-dist/js/bootstrap.js"></script>
</body>
</html>