<?php
include('server.php');

// Check if the guest username exists in the session
if(isset($_SESSION['guest_username'])){
    $username = $_SESSION['guest_username'];
} else {
    // Redirect to the home page if no guest profile is found
    header("location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Client Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="awesome/css/fontawesome-all.min.css">
    <style>
        body { padding-top: 3%; margin: 0; background:#000;}
        .card { box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); background:#000; }
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

    </style>
</head>
<body>

<!--Navbar menu-->
<nav class="navbar navbar-fixed-top" id="my-navbar" style="background-color:white;" >
    <div class="container" style="background-color:white;">
            <a href="index.php" class="navbar-brand" style="color:#a81008;">RemyInk!</a>
        
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="allJob.php" style="color:#eacc08">Browse all jobs</a></li>
                <li class="dropdown" style="padding:0 20px 0 20px;">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="color:#a81008">
                        <span class="glyphicon glyphicon-user" style="color:#a81008"></span> <?php echo $username; ?>
                    </a>
                    <ul class="dropdown-menu list-group list-group-item-info">
                        <li><a href="index.php" class="list-group-item"><span class="glyphicon glyphicon-ok"></span> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>      
    </div>  
</nav>
<!--End Navbar menu-->

<!--Main body-->
<div style="padding:1% 3% 1% 3%;">
    <div class="row">

    <!--Column 1-->
        <div class="col-lg-12">
    <!--Guest Profile Details-->    
            <div class="card" style="padding:20px 20px 5px 20px;margin-top:20px;">
                <div class="panel panel-succes" style="background-color:re;">
                  <div class="panel-heading" style="background-color:#000;"><h3 style="color:#eacc08">Guest Profile</h3></div>
                  <div class="panel-body"><h4>
                      <p><strong>Username:<i></strong> <?php echo $username; ?></i></p>
                          <!--Column 2-->
        <div class="col-lg-1">
            <form action="message.php" method="post">
                <div class="form-group">
                  <center><button type="submit" name="inbox" class="btn btn-info">View Messages</button></center>
                </div>
            </form>
        </div>
        <div class="col-lg-2">
            <form action="message.php" method="post">
                <div class="form-group">
                  <center><button type="submit" name="inbox" class="btn btn-info">View Orders</button></center>
                </div>
            </form>
        </div>
<!--End Main profile card-->

    </div>
                  </h4></div>
                </div>
                <img src="https://api.logo.com/api/v2/images?design=logo_8306aba4-a17e-4f60-bc88-6ed8b47f4e44&u=2024-09-02T08%3A01%3A41.126Z&format=svg&margins=166&width=1000&height=750&fit=contain" alt="logo" id="main_img" style="height:420px; width:fit-content; display:flex; justify-content:center; padding-left:400px;">
                  
            </div>
    <!--End Guest Profile Details-->

        </div>
    <!--End Column 1-->


    <!--End Column 2-->
    </div>
</div>
<!--End main body-->
<!-- Footer -->
<div class="footer">
    <div class="container">
        <p>&copy; 2024 RemyInk! All Rights Reserved.</p>
    </div>
</div>
<!-- End Footer -->
<!-- Include jQuery before Bootstrap's JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
