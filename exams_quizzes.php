<?php 
include('server.php');

if (isset($_SESSION["Username"])) {
    $username = $_SESSION["Username"];
    $usertype = $_SESSION["Usertype"];
    
    if ($usertype == 1) {
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
    $username = "";
}

if (isset($_POST["jid"])) {
    // Check for existing guest session or create a new one
    if (!isset($_SESSION["guest_id"])) {
        // Function to create a new guest profile and start a session
        createGuestSession(); // Assuming this function is defined in 'server.php'
    }

    // Save the job ID and redirect to job details page
    $_SESSION["job_id"] = $_POST["jid"];
    header("location: jobDetails.php");
    exit();
}

// SQL query to fetch only "Exams & Quizzes" gigs
$sql = "SELECT * FROM job_offer WHERE type='Exams/Quizzes' AND valid=1 ORDER BY job_id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Exams & Quizzes</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="awesome/css/fontawesome-all.min.css">
    <style>
        body { padding-top: 3%; margin: 0; background-color: #000; }
        .card { box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); background: #000; }
        .gig-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            background-color: #000;
        }
        .gig-card {
            flex: 1 1 calc(33.33% - 20px);
            box-sizing: border-box;
            max-width: calc(33.33% - 20px);
            margin-bottom: 20px;
            background-color: #000;
            border: 2px solid #ddd;
            border-radius: 20px;
            overflow: hidden;
        }
        .gig-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .gig-card-content {
            padding: 20px 0;
            text-align: center;
        }
        .gig-card-content h4 {
            margin: 10px 0;
            font-size: 24px;
            color: white;
        }
        .gig-card-content p {
            margin: 0;
            font-size: 16px; /* Reduced font size */
            color: yellow; /* Changed color to white for better readability */
        }
        .gig-card-content p strong {
            color: #eacc08; /* Color for labels to stand out */
        }
    </style>
</head>
<body>
<!-- Navbar menu -->
<nav class="navbar navbar-fixed-top" id="my-navbar" style="background-color:white;">
    <div class="container" style="background-color:white;">
        
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="index.php" class="navbar-brand" style="color:#a81008">RemyInk!</a>
        
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="exams_quizzes.php" style="color:#eacc08">Exams & Quizzes</a></li>  <!-- New link -->
                <li><a href="research_essays.php" style="color:#eacc08">Research & Essays</a></li>  <!-- New link -->
                <li><a href="tutoring.php" style="color:#eacc08">Tutoring</a></li>  <!-- New link -->
                <li class="dropdown" style="padding:0 20px 0 20px;">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="color:#a81008;">
                        <span class="glyphicon glyphicon-user" style="color:#a81008; font-size:2rem;"></span> <?php echo $username; ?>
                    </a>
                    <ul class="dropdown-menu list-group list-group-item-info">
                        <a href="guest_profile.php" class="list-group-item"><span class="glyphicon glyphicon-home"></span> View profile</a>
                        <a href="message.php" class="list-group-item"><span class="glyphicon glyphicon-envelope"></span> Messages</a>
                        <a href="index.php" class="list-group-item"><span class="glyphicon glyphicon-ok"></span> Logout</a>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!--End Navbar menu-->

<!-- Main content -->
<div class="containe">
    <div class="row">
        <div class="col-lg-9">
            <div class="card" style="padding:20px 20px 5px 20px;margin-top:20px">
                <div class="panel panel-succes">
                    <div class="panel-heading"><h3>Exams & Quizzes</h3></div>
                    <div class="panel-body">
                        <div class="gig-container">
                        <?php 
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $title = $row["title"];
                                    $type = $row["type"];
                                    $subjects = $row["subjects"];
                                    $formats = $row["format"];
                                    $e_username = $row["e_username"];
                                    $image = "https://st2.depositphotos.com/1444927/6033/i/450/depositphotos_60339431-stock-photo-test-time.jpg"; // Example image URL

                                    echo '
                                    <div class="gig-card">
                                        <img src="'.$image.'" alt="Gig Image">
                                        <div class="gig-card-content">
                                            <h4>'.$title.'</h4>
                                            </br>
                                            <p> '.$subjects.'</p>
                                            </br>
                                            <p> '.$formats.'</p>
                                            </br>
                                            <p><strong style="color:white;">By </strong> <i style="color:red;">'.$e_username.'</i></p>
                                            <form action="gigs.php" method="post">
                                            </br>
                                                <input type="hidden" name="jid" value="'.$row["job_id"].'">
                                                <button type="submit" class="btn btn-primary">View Details</button>
                                            </form>
                                        </div>
                                    </div>
                                    ';
                                }

                            } else {
                                echo "<p>No gigs available for Research & Essays.</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <!-- Search Filters -->
            <!-- Same search filter code as the original file -->
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
