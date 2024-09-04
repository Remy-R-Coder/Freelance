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
        $textBtn = "Edit Offering";
    }
} else {
    $username = "";
}


// Your existing code to connect to the database

if (isset($_SESSION["job_id"])) {
    $job_id = $_SESSION["job_id"];
} else {
    $job_id = "";
}

$sql = "SELECT * FROM job_offer WHERE job_id='$job_id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $e_username = $row["e_username"];
        $title = $row["title"];
        $subjects = $row["subjects"]; // Change this to retrieve subjects
        $formats = $row["format"]; // Assuming formats are stored as a comma-separated string
        $jv = $row["valid"];
    }
}
$_SESSION["msgRcv"] = $e_username;
?>


<!DOCTYPE html>
<html>
<head>
    <title>Job Details</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="awesome/css/fontawesome-all.min.css">

    <style>
        body { padding-top: 3%; margin: 0; background: #000; }
        .card { box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); background: #fff; }
        .panel-heading { background-color: #a81008; color: #fff; }
        .panel-body { background-color: #fff; color: #000; }
        .formats { color: #000; }
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

<!-- Navbar menu -->
<nav class="navbar navbar-fixed-top" id="my-navbar" style="background-color:white;">
    <div class="container" style="background-color:white;">
        <a href="index.php" class="navbar-brand" style="color:#a81008;">RemyInk!</a>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="allJob.php">Browse all jobs</a></li>
                <li class="dropdown" style="padding:0 20px 0 20px;">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="color:#a81008;">
                        <span class="glyphicon glyphicon-user" style="color:#a81008; font-size:2rem;"></span> <?php echo $username; ?>
                    </a>
                    <ul class="dropdown-menu list-group list-group-item-info">
                        <a href="guest_profile.php" class="list-group-item"><span class="glyphicon glyphicon-home"></span> View profile</a>
                        <?php if ($usertype != 3) { ?>
                        <?php } ?>
                        <a href="message.php" class="list-group-item"><span class="glyphicon glyphicon-envelope"></span> Messages</a>
                        <a href="logout.php" class="list-group-item"><span class="glyphicon glyphicon-ok"></span> Logout</a>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar menu -->
<!-- Add this inside the body, preferably right after the navbar -->
<!-- Main body -->
<div style="padding:1% 3% 1% 3%;">
    <div class="row">
        <!-- Column 1 -->
        <div class="col-lg-8">

            <!-- Job Details -->
            <div class="card" style="padding:20px 20px 5px 20px;margin-top:20px">
                <div class="panel panel-success" style="background-color:#000;">
                    <div class="panel-heading"><h3>Details</h3></div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">Gig Title</div>
                    <div class="panel-body"><h4><?php echo htmlspecialchars($title); ?></h4></div>
                </div>

                <div class="panel panel-success">
                    <div class="panel-heading">Subjects</div>
                    <div class="panel-body"><h4><?php echo htmlspecialchars($subjects); ?></h4></div>
                </div>

                <div class="panel panel-success">
                    <div class="panel-heading">Formats</div>
                    <div class="panel-body">
                        <h4 class="formats"><?php echo htmlspecialchars($formats); ?></h4>
                    </div>
                </div>

                <!-- Edit Job Button -->
                <?php if ($_SESSION["Usertype"] != 1 && $e_username == $username) { ?>
                <div class="panel panel-success">
                    <div class="panel-body">
                        <a href="editJob.php?job_id=<?php echo $job_id; ?>" class="btn btn-warning">Edit Job</a>
                    </div>
                </div>
                <?php } ?>
            </div>
            <!-- End Job Details -->

        </div>
        <!-- End Column 1 -->

        <?php
        // Your existing code for displaying employer profile
        ?>

        <!-- Column 2 -->
        <div class="col-lg-4">



            <!-- Reputation -->
            <div class="card" style="padding:20px 20px 5px 20px;margin-top:20px">
                <div class="panel panel-warning">
                    <div class="panel-heading"><h4>Reputation</h4></div>
                </div>
                <div class="panel panel-warning">
                    <div class="panel-heading">Reviews</div>
                    <div class="panel-body">Nothing to show</div>
                </div>
                <div class="panel panel-warning">
                    <div class="panel-heading">Ratings</div>
                    <div class="panel-body">Nothing to show</div>
                </div>
            </div>
            <!-- End Reputation -->

        </div>
        <!-- End Column 2 -->

    </div>
</div>
<!-- End Main body -->

<!-- Footer -->
<div class="footer">
    <div class="container">
        <p>&copy; 2024 RemyInk! All Rights Reserved.</p>
    </div>
</div>
<!-- End Footer -->

<script type="text/javascript" src="jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

<?php
if ($e_username != $username && $_SESSION["Usertype"] != 1) {
    echo "<script>
            $('#applybtn').hide();
    </script>";
}

if ($_SESSION["Usertype"] == 1 && $jv == 0) {
    echo "<script>
            $('#applybtn').hide();
    </script>";
}

if ($e_username != $username) {
    echo "<script>
            $('#applicant').hide();
    </script>";
}
?>

</body>
</html>
