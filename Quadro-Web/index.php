<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Homepage</title>
    <link rel="stylesheet" href="/bootstrap-5.3.2-dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../style.css" />
    <!-- Add other CSS stylesheets if needed -->
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
            margin-right: 5%; 
            margin-bottom: 15%;
            font-size: 30px;
        }
        
       

    </style>
</head>
<header>

<body style="background-color: rgb(238, 237, 226);">

    <div class="container-fluid navbar-container">
        <div class="navbar-logo">
            <a><img src="tc.jpg" alt="Logo" width="40" height="24" class="d-inline-block align-text-top">TOKEN CORE</a>
    </div>
            <nav class="nav-item" style="margin-left: 80%">  
                <a class="nav-link" href="index.php">Login</a>
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
      
    <div class="container-fluid picture-container">
        <div class="img">
            <img src="token core logo.jpg" />
        </div>
       <div class="text">
                <h1>TOKEN CORE</h1><span>
                    <h3 style="font-size:20px"> The merchandise in which full of surprises awaits you. </h3>
                </span><span><button style="background-color:beige"  href="visitor_explore.php">Explore</button>
                    </span> 
    </div>   

    <script src="/bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
   
    
</body>
    

</html>
