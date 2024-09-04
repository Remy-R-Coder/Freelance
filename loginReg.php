<?php include('server.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>RemyInk!</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="dist/css/bootstrapValidator.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        body {
            padding-top: 5%;
            margin: 0;
            background-color: #000;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #ECF0F1;
        }

        .header1 {
            background-color: #2C3E50;
            padding: 1%;
            color: #fff;
            text-align: center;
        }

        .navbar {
            background-color: #fff;
            border-color: #000;
        }

        .navbar .navbar-brand {
            color: #a81008;
        }

        .navbar .navbar-nav > li > a {
            color: #eacc08;
        }

        .card {
            background: #000;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-top: 40px;
        }

        .page-header h2 {
            color: #ECF0F1;
        }

        .form-control {
            border-radius: 5px;
            background-color: #555;
            border: 1px solid #777;
            color: #ECF0F1;
        }

        .form-control:focus {
            background-color: #444;
            color: #ECF0F1;
        }

        .btn-info {
            background-color: #2980B9;
            border-color: #2980B9;
            border-radius: 5px;
            padding: 10px 20px;
        }

        .btn-info:hover {
            background-color: #3498DB;
            border-color: #3498DB;
        }

        .footer {
            padding: 4%;
            background: #000;
            color: #fff;
            margin-top: 40px;
            text-align: center;
        }

        .footer h3 {
            margin-bottom: 20px;
        }

        .footer a {
            color: #ECF0F1;
            text-decoration: none;
        }

        .footer a:hover {
            color: #3498DB;
            text-decoration: underline;
        }

        .social-icons i {
            margin: 10px;
            font-size: 24px;
            color: #ECF0F1;
        }

        .social-icons i:hover {
            color: #3498DB;
        }
    </style>
</head>
<body>

<!-- Navbar menu -->
<nav class="navbar navbar-fixed-top" id="my-navbar">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="index.php" class="navbar-brand">RemyInk!</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="index.php">Home</a></li>
                <li><a href="loginReg.php" data-toggle="modal" data-target="#loginModal">Login</a></li>
            </ul>
        </div>      
    </div>  
</nav>
<!-- End Navbar menu -->

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="page-header text-center">
                <h2>Login</h2>
            </div>
            <div class="card">
                <form id="loginForm" method="post" class="form-horizontal">
                    <div style="color:red; text-align: center;">
                        <p><?php echo $errorMsg; ?></p>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Username</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="username" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" name="password" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Usertype</label>
                        <div class="col-sm-9">
                        <div class="radio">
                                <label>
                                    <input type="radio" name="usertype" value="employer" required /> User
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="usertype" value="freelancer" required /> Guest
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <button type="submit" name="login" class="btn btn-info btn-lg">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<div class="footer">
    <div class="container">
        <p>&copy; 2024 RemyInk! All Rights Reserved.</p>
    </div>
</div>
<!-- End Footer -->

<script src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="dist/js/bootstrapValidator.js"></script>

<script>
    $(document).ready(function() {
        $('#loginForm').bootstrapValidator();
    });
</script>
</body>
</html>
