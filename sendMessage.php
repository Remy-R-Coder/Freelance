<?php 
include('server.php');

if (isset($_SESSION["Username"])) {
    $username = $_SESSION["Username"];
    if ($_SESSION["Usertype"] == 1) {
        $linkPro = "freelancerProfile.php";
        $linkEditPro = "editFreelancer.php";
        $linkBtn = "applyJob.php";
        $textBtn = "Apply for this job";
    } else {
        $linkPro = "employerProfile.php";
        $linkEditPro = "editEmployer.php";
        $linkBtn = "editJob.php";
        $textBtn = "Edit the job offer";
    }
} else {
    // If no user is logged in, assume guest profile management
    $username = getOrCreateGuestProfile($conn);  // Automatically create or retrieve a guest profile
}

if (isset($_SESSION["msgRcv"])) {
    $msgRcv = $_SESSION["msgRcv"];
}

if (isset($_POST["send"])) {
    $msgTo = $_POST["msgTo"];
    $msgBody = $_POST["msgBody"];
    $sql = "INSERT INTO message (sender, receiver, msg) VALUES ('$username', '$msgTo', '$msgBody')";
    $result = $conn->query($sql);
    if ($result == true) {
        header("location: message.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Send Message</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="awesome/css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="dist/css/bootstrapValidator.css">

    <style>
        body {padding-top: 3%; margin: 0; background-color: #000;}
        .card {box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); background: #fff;}
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
                <li><a href="allJob.php">Browse all jobs</a></li>
                <li class="dropdown" style="padding:0 20px 0 20px;">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <span class="glyphicon glyphicon-user"></span> <?php echo $username; ?>
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


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="page-header">
                <h2 style="color:#a81008;">Write Message</h2>
            </div>

            <form id="registrationForm" method="post" class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-4 control-label" style="color:yellow;">To</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="msgTo" value="<?php echo $msgRcv; ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label" style="color:yellow;">Message Body</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" rows="12" name="msgBody"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-9 col-sm-offset-3">
                        <!-- Do NOT use name="submit" or id="submit" for the Submit button -->
                        <button type="submit" name="send" class="btn btn-info btn-lg">Send Message</button>
                    </div>
                </div>
            </form>
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

<script type="text/javascript" src="jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="dist/js/bootstrapValidator.js"></script>

<script>
$(document).ready(function() {
    $('#registrationForm').bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            msgTo: {
                validators: {
                    notEmpty: {
                        message: 'This is required and cannot be empty'
                    }
                }
            },
            msgBody: {
                validators: {
                    notEmpty: {
                        message: 'This is required and cannot be empty'
                    }
                }
            }
        }
    });
});
</script>

</body>
</html>
