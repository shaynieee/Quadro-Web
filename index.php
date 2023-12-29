<!DOCTYPE html>
<?php include_once("../db.php")?>
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
  <div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="container-fluid">
        <img src="../pictures/token core logo.jpg" alt="..." class="logo">
        <nav class="navbar navbar-expand-lg">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a href="" class="nav-link">WELCOME GUEST</a>
            </li>
          </ul>
        </nav>
      </div>
    </nav>
  </div>

  <div class="bg-light">
    <h3 class="text-center p-2"> Manage Details </h3>
  </div>

  <div class="row">
    <div class="col-md-12 --bs-warning-bg-subtle">
      <div>
        <p class="text-dark text-center"> Admin Name </p>
      </div>

      <div class="button text-center">
        <button><a href="index.php?view_items" class="nav-link text-dark my-1">VIEW ITEMS</a></button>
        <button><a href="index.php?insert_items" class="nav-link text-dark my-1">INSERT ITEMS</a></button>
        <button><a href="index.php?view_categories" class="nav-link text-dark my-1">VIEW CATEGORIES</a></button>
        <button><a href="index.php?insert_category" class="nav-link text-dark my-1">INSERT CATEGORIES</a></button>
        <button><a href="index.php?view_custom_property" class="nav-link text-dark my-1">VIEW CUSTOM PROPERTY</a></button>
        <button><a href="index.php?custom_property" class="nav-link text-dark my-1">INSERT CUSTOM PROPERTY</a></button>
        <button><a href="index.php?view_variation" class="nav-link text-dark my-1">VIEW VARIATIONS</a></button>
        <button><a href="index.php?variation" class="nav-link text-dark my-1">INSERT VARIATIONS</a></button>
        <button><a href="index.php?insert_price" class="nav-link text-dark my-1">INSERT PRICE</a></button>
        <button><a href="index.php?view_price" class="nav-link text-dark my-1">VIEW PRICE</a></button>
        <button><a href="index.php?insert_stock" class="nav-link text-dark my-1">INSERT STOCK</a></button>
        <button><a href="index.php?view_stock" class="nav-link text-dark my-1">VIEW STOCK</a></button>
        <button><a href="index.php?orders_detail" class="nav-link text-dark my-1">ORDER DETAILS</a></button>
        <button><a href="index.php?user_details" class="nav-link text-dark my-1">USER DETAILS</a></button>
        <button><a href="index.php?sales_report" class="nav-link text-dark my-1">SALES REPORT</a></button>
        <button><a href="index.php?sold_items" class="nav-link text-dark my-1">SOLD ITEMS</a></button>
        <button><a href="#" class="nav-link text-dark my-1">LOGOUT</a></button>
      </div>
   <hr>
      <div>
        <?php
        if (isset($_GET['insert_category'])) {
          include('insert_category.php');
        }
        if (isset($_GET['insert_items'])) {
          include('insert_items.php');
        }
        if (isset($_GET['custom_property'])) {
          include('custom_property.php');
        }
        if (isset($_GET['variation'])) {
          include('variation.php');
        }
        if (isset($_GET['view_items'])) {
          include('view_items.php');
        }
        if (isset($_GET['edit_items'])) {
          include('edit_items.php');
        }
        if (isset($_GET['insert_price'])) {
          include('insert_price.php');
        }
        if (isset($_GET['insert_stock'])) {
          include('insert_stock.php');
        }
        if (isset($_GET['orders_detail'])) {
          include('orders_detail.php');
        }
        if (isset($_GET['user_details'])) {
          include('user_details.php');
        }
        if (isset($_GET['view_custom_property'])) {
          include('view_custom_property.php');
        }
        if (isset($_GET['view_variation'])) {
          include('view_variation.php');
        }
        if (isset($_GET['view_categories'])) {
          include('view_categories.php');
        }
        if (isset($_GET['view_price'])) {
          include('view_price.php');
        }
        if (isset($_GET['view_stock'])) {
          include('view_stock.php');
        }
        if (isset($_GET['sales_report'])) {
          include('sales_report.php');
        }
        if (isset($_GET['sold_items'])) {
          include('sold_items.php');
        }
       
        ?>
      </div>

    </div>
  </div>

  <script src="../js/bootstrap.js"></script>
</body>

</html>