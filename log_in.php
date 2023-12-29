<?php include_once("db.php"); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>LOGIN</title>
    <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-8">
                <img src="pictures/tc.jpg">
            </div>
            <div class="col-4 align-items-center">

                <?php
                if (isset($_GET['error'])) {
                    if ($_GET['error'] == "777") { ?>
                        <div class="alert alert-danger"> Invalid Username and Password </div>
                    <?php }
                }
                if (isset($_GET['msg'])) {
                    if ($_GET['msg'] == 'userregistered') { ?>
                        <div class="alert alert-success">User Successfully Registered. You may log in</div>
                    <?php } else if ($_GET['msg'] == 'notallowed') { ?>
                        <div class="alert alert-warning">You are not allowed there</div>
                    <?php }
                }
                ?>

                <h3 class="display-3">Login Here</h3>

                <form action="login.php" method="post">
                    <div class="mb-3 ">
                        <label for="">Username
                            <input type="text" class="form-control" name="uname">
                        </label>
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
                    <a href="registration.php" class="btn btn-info">Create Account</a>
                </form>
            </div>
        </div>
    </div>
    <script src="bootstrap-5.3.2-dist/js/bootstrap.js"></script>
</body>

</html>