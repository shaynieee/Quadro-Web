<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
         <title>Document</title>
        <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="style.css"/>
    </head>

    <body>
        <div class="container">
            <div class ="row justify-content-center">
                <div class="col-12">
                <form action="register.php" method="post">
            <div class="mb-3">

                <label for="">Full Name

                    <input type="text" class="form-control" name="fullname">
                </label>
            </div>
            <div class="mb-3">
                <label for="">Username
                    <input type="text" class="form-control" name="uname"> </label>
            </div>
            <div class="mb-3">
                <label for="">Contact Number
                    <input type="text" class="form-control" name="contact_number"> </label>
            </div>
            <div class="mb-3">
                <label for="">Address
                    <input type="text" class="form-control" name="address"> </label>
            </div>
            <div class="mb-3">
                <label for="">Email Address
                    <input type="text" class="form-control" name="email_address"> </label>
            </div>
            <div class="mb-3">
                <label for="">Password
                    <input type="Password" class="form-control" name="pass1">
                 </label>
            </div>
            <div class="mb-3">
                 <label for="">Confirm Password
                    <input type="Password" class="form-control" name="pass2">
                </label>
            </div>
            <div class="mb-3">
                    <input type="submit" class="btn btn-success">
            </div>
                <p>Already have an account? <a href="login.php">Login here</a>.</p>
            </div>
            </div>    
        </form>
    </body>
        <script src="bootstrap-5.3.2-dist/js/bootstrap.js"></script>
        </html>