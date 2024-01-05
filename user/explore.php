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
    <title>Explore</title>
    <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../style.css" />
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
            <div class="col-md-6 col-sm-6">
                <ul class="nav nav-underline justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">Cart</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="order_history.php">Order History</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <hr>

    <nav>
        <ul class="nav nav-underline justify-content-center">
            <li class="nav-item">
                <a class="nav-link" href="index.php"><h3>Home</h3></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="explore.php"><h3>Explore</h3></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><h3>Deals</h3></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"> <h3>About Us</h3></a>
            </li>
        </ul>
    </nav>
    <script src="../bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>

    <div class="sha mt-3">
        <h3>What's New?</h3>
    </div>

    <div class="row">
    <?php
// Your database connection and other configurations

// Check if the user is logged in
if (isset($_SESSION['user_info']['user_id'])) {
    $user_id = $_SESSION['user_info']['user_id'];

    // Fetch categories
    $categories_query = "SELECT * FROM categories WHERE cat_status = 'A'";
    $categories_result = mysqli_query($conn, $categories_query);

    if ($categories_result !== false) {
        while ($category = mysqli_fetch_assoc($categories_result)) {
            // Check if category status is active
            if ($category['cat_status'] === 'A') {
                echo "<div class='sha mt-3'><h3>{$category['cat_name']}</h3></div>";

                // Fetch items for the current category
                $category_id = $category['cat_id'];
                $items_query = "SELECT items.*, pricing.item_price, stocks.stock_qty, pricing.price_status, stocks.stock_status
                                FROM items
                                JOIN pricing ON items.price_id = pricing.price_id
                                JOIN stocks ON items.stock_id = stocks.stock_id
                                WHERE items.cat_id = '$category_id' AND items.item_status = 'A'
                                AND pricing.price_status = 'A' AND stocks.stock_status = 'A'";
                $items_result = mysqli_query($conn, $items_query);

                if ($items_result !== false) {
                    echo "<div class='row'>";
                    while ($row = mysqli_fetch_assoc($items_result)) {
                        // Check if item status, pricing status, and stock status are active
                        if ($row['item_status'] === 'A' && $row['price_status'] === 'A' && $row['stock_status'] === 'A') {
                            echo "<div class='col-3'>";
                            echo "<div class='card mb-3 mt-3'>";
                            echo "<img src='../pictures/{$row['item_img']}' class='card-img-top' alt='...'>";
                            echo "<div class='card-body'>";
                            echo "<h5 class='card-title'>{$row['item_name']}</h5>";
                            echo "<p class='card-text text-success'>{$row['item_price']}</p>";
                            echo "<p class='card-text'>{$row['stock_qty']}</p>";
                            echo "<a href='cuztomization.php?action=add-to-cart&item_id={$row['item_id']}&user_id={$user_id}' class='btn btn-primary'>Add to Cart</a>";
                            echo "<a href='cuztomization.php?action=buy&item_id={$row['item_id']}' class='btn btn-success'>Buy</a>";
                            echo "</div></div></div>";
                        }
                    }
                    echo "</div>";
                } else {
                    echo "<p>No items found for category: {$category['cat_name']}</p>";
                }
            }
        }

        // Close the result set for categories
        mysqli_free_result($categories_result);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Handle the case where the user is not logged in
    echo "User is not logged in.";
}

// Close the database
mysqli_close($conn);
?>

    
    </div>

</body>

</html>