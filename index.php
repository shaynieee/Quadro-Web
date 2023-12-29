<?php
session_start();
include_once("../db.php");

// Check if the user is logged in and active
if (isset($_SESSION['user_info']['username'])) {
    $username = $_SESSION['user_info']['username'];
    $userQuery = "SELECT user_id, user_type, user_status FROM users WHERE username ='$username'";
    $userResult = mysqli_query($conn, $userQuery);

    if ($userResult !== false) {
        $userData = mysqli_fetch_assoc($userResult);

        // Check if the user is active
        if ($userData['user_status'] !== 'A') {
          header("Location: ../log_in.php?Sorry, you're not allowed here. User not active.");
            exit();
        }

        // Check user type
        if ($userData['user_type'] !== 'U') {
          header("Location: ../log_in.php?Sorry, you're not allowed here. Invalid user type");
            exit();
        }

        $user_id = $userData['user_id'];
        $_SESSION['user_info']['user_id'] = $user_id;
        mysqli_free_result($userResult);
    } else {
        echo "Error: " . mysqli_error($conn);
        exit();
    }
} else {
    header("Location: ../log_in.php?msg=no_user_found");
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="../bootstrap-5.3.2-dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../style.css" />
    
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-4 mb-5 text-center">
                <a class="navbar-brand" href="#"><img src="../pictures/token core logo.jpg " width=40% height=40% ></a>
            </div>
            <div class="col-md-4 justify-content-center"> <!-- Adjusted the column width -->
                <?php
                if (isset($_SESSION['user_info']['username'])) {
                    echo "<h3>Hi, {$_SESSION['user_info']['username']}! Welcome to TOKEN CORE!</h3>";
                } else {
                    echo "<h3>Welcome to TOKEN CORE!</h3>";
                }
                ?>
            </div>
            <div class="col-md-4 mb-5 text-center">
            <a class="nav-link" href="logout.php">Logout</a>
            <a href="logout.php" class="btn-outline-danger"><?php echo $_SESSION['user_info']['username']?></a>
            </div> 
        </div>
    </div>
</nav>
<br>
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
    <a class="nav-link active" aria-current="page" href="#"><h3>Home </h3></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="explore.php"><h3>Explore</h3></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#"><h3>Deals</h3></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#"> <h3>About Us</h3></a>
  </li>
</ul>
</nav>
<br>
<br>

<div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="../pictures/carousel_image.jpg" class="d-block w-10" alt="...">
    </div>
    <div class="carousel-item">
      <img src="../.jpg" class="d-block w-10" alt="...">
    </div>
    <div class="carousel-item">
      <img src="../pictures/346992-Sunset-Road-Landscape-Scenery.jpg" class="d-block w-10" alt="...">
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"></script>

<script>

  var myCarousel = new bootstrap.Carousel(document.getElementById('carouselExampleSlidesOnly'), {
    interval: 2000 
  });
</script>

   <br> 
  <br>

   
  <div class="row">
    <?php

    // Check category status and display categories
$categories_query = "SELECT * FROM categories WHERE cat_status = 'A'";
$categories_result = mysqli_query($conn, $categories_query);

if ($categories_result !== false) {
  while ($category = mysqli_fetch_assoc($categories_result)) {
      echo "<div class='col-3'>";
      echo "<div class='card mb-3'>";
      echo "<a href='explore.php#{$category['cat_id']}'>";
      echo "<img src='../pictures/{$category['cat_image']}' class='card-img-top' alt='...' usemap='#{$category['cat_name']}' width='400' height='379'>";
      echo "</a>";
      echo "<map name='{$category['cat_name']}'>";
      echo "<area shape='rect' coords='0,0,400,379' alt='...' href='explore.php#{$category['cat_id']}'>";
      echo "</map>";
      echo "<div class='card-body'>";
      echo "<h5 class='card-title'>{$category['cat_name']}</h5>";
      echo "<p class='card-text'>{$category['cat_description']}</p>";
      echo "</div>";
      echo "</div>";
      echo "</div>";
  }


  mysqli_free_result($categories_result);
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
    ?>
</div>

</body>

</html>