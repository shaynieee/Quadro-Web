<?php 
session_start();
include_once("db.php"); 
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
<style>
        .navbar-container {
            display: flex;
            justify-content: space-between; /* Updated to space-between */
            align-items: center;
            background-color: #f8f9fa;
            padding: 10px;
        }

        .navbar-logo,
        .navbar-search {
            display: flex;
            align-items: center;
        }

        .navbar-logo img {
            margin-right: 10px; /* Add margin for spacing between logo and search */
        }

        .navbar-search form {
            margin-bottom: 0;
        }

        .nav-item {
            margin-right: 15px;
        }

        .nav-link {
            margin-bottom: 0;
        }
        
        .picture-container {
            display: flex;
            justify-content: space-between; /* Updated to space-between */
            align-items: center;
            background-color: rgb(238, 237, 226);
            padding: 5px;
        }

        .text {
            margin-right: 0%; 
            margin-bottom: 15%;
            font-size: 30px;
        }
  </style>
  <header>
  <body style="background-color: rgb(238, 237, 226);">

<div class="container-fluid navbar-container">
    <div class="navbar-logo">
        <a><img src="logo.jpg" alt="Logo" width="40" height="24" class="d-inline-block align-text-top">TOKEN CORE</a>
    </div>
    <div class="navbar-search">
        <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
        <nav class="nav-item">  
            <a class="nav-link" href="log_in.php">Login</a>
        </nav>
        <nav class="nav-item">
            <a class="nav-link" href="registration.php">Signup</a>
        </nav>
    </div>
</div>
    </header>

<hr />
<div class="container mt-4 text-center">
        <nav class="navbar-links d-inline-block">
            <a class="nav-link active navbar-link" aria-current="page" href="index.php">Home</a>
            <a class="nav-link navbar-link" href="visitor_explore.php">Explore</a>
            <a class="nav-link navbar-link" href="#">Contact</a>
            <a class="nav-link navbar-link" href="about_us.php">About Us</a>
        </nav>
    </div>
     

    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="../pictures/346992-Sunset-Road-Landscape-Scenery.jpg" class="d-block w-10" alt="...">
    </div>
    <div class="carousel-item">
      <img src="../pictures/346992-Sunset-Road-Landscape-Scenery.jpg" class="d-block w-10" alt="...">
    </div>
    <div class="carousel-item">
      <img src="../pictures/346992-Sunset-Road-Landscape-Scenery.jpg" class="d-block w-10" alt="...">
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"></script>

<script>
  // Activate the carousel
  var myCarousel = new bootstrap.Carousel(document.getElementById('carouselExampleSlidesOnly'), {
    interval: 2000 // Set the interval between slides in milliseconds (e.g., 2000 for 2 seconds)
  });
</script>

   <br> 
  <br>

   <h2 style="text-align:center">Some of our Categories</h2>
  <div class="row">
    <?php
    // Your database connection and other configurations
    $categories_query = "SELECT * FROM categories";
    $categories_result = mysqli_query($conn, $categories_query);

    if ($categories_result !== false) {
        while ($category = mysqli_fetch_assoc($categories_result)) {
            echo "<div class='col-3'>";
            echo "<div class='card mb-3'>";
            echo "<a href='visitor_explore.php#{$category['cat_id']}'>";
            echo "<img src='/pictures/{$category['cat_image']}' class='card-img-top' alt='...' usemap='#{$category['cat_name']}' width='400' height='379'>";
            echo "</a>";
            echo "<map name='{$category['cat_name']}'>";
            echo "<area shape='rect' coords='0,0,400,379' alt='...' href='visitor_explore.php#{$category['cat_id']}'>";
            echo "</map>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>{$category['cat_name']}</h5>";
            echo "<p class='card-text'>{$category['cat_description']}</p>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        mysqli_free_result($categories_result);
    }
    else {
        echo "Error: " . mysqli_error($conn);
    }
  ?>
      
   <h2 style="text-align:center">Our Items</h2>
  <?php
    $categories_query = "SELECT * FROM categories";
    $categories_result = mysqli_query($conn, $categories_query);

    if ($categories_result !== false) {
        while ($category = mysqli_fetch_assoc($categories_result)) {
            echo "<div class='sha mt-3'><h3>{$category['cat_name']}</h3></div>";

            // Fetch items for the current category
            $category_id = $category['cat_id'];
            $items_query = "SELECT items.*, pricing.item_price, stocks.stock_qty
                            FROM items
                            JOIN pricing ON items.price_id = pricing.price_id
                            JOIN stocks ON items.stock_id = stocks.stock_id
                            WHERE items.cat_id = '$category_id'";
            $items_result = mysqli_query($conn, $items_query);
            if ($items_result !== false) {
                echo "<div class='row'>";
                while ($row = mysqli_fetch_assoc($items_result)) {
                    echo "<div class='col-3'>";
                    echo "<div class='card mb-3 mt-3'>";
                    echo "<img src='QUADROWEB/pictures/{$row['item_img']}' class='card-img-top' alt='...'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>{$row['item_name']}</h5>";
                    echo "<p class='card-text text-success'>{$row['item_price']}</p>";
                            echo "<p class='card-text'>{$row['stock_qty']}</p>";
                            echo "<a href='index.php?action=add-to-cart&item_id 'btn btn-primary'>Add to Cart</a>";
                            echo "<a href='index.php?action=buy&item_id={$row['item_id']}' class='btn btn-success'>Buy</a>";
                    echo "</div></div></div>";
                 }
                        echo "</div>";
                    } else {
                        echo "<p>No items found for category: {$category['cat_name']}</p>";
                    }
                }

                // Close the result set for categories
                mysqli_close($conn);
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        

    ?>
  </div>
  </body>