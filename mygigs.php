<?php 
include('server.php');

if (!isset($_SESSION["Username"])) {
    header("location: index.php");
    exit();
}

$username = $conn->real_escape_string($_SESSION["Username"]);

$sql = "SELECT * FROM job_offer WHERE e_username = '$username'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Gigs</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="awesome/css/fontawesome-all.min.css">
    <style>
        body { padding-top: 3%; margin: 0; background: #000;}
        .card { 
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 
                        0 6px 20px 0 rgba(0, 0, 0, 0.19); 
            background: #fff;
            margin-bottom: 20px;
        }
        .card img { 
            max-width: 100%; 
            height: auto; 
        }
        .card-body {
            padding: 15px;
        }
        .btn {
            margin-right: 5px;
        }
    </style>
</head>
<body>

<!--Navbar menu-->
<nav class="navbar navbar-fixed-top" id="my-navbar" style="background-color:white;">
	<div class="container" style="background-color:white;">
		
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="index.php" class="navbar-brand" style="color:#a81008;">RemyInk!</a>
		
		<div class="collapse navbar-collapse" id="navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="allJob.php" style="color:#eacc08">Browse all jobs</a></li>
				
				<li class="dropdown" style="padding:0 20px 0 20px;">
			        <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="color:#a81008;"><span class="glyphicon glyphicon-user" style="color:#a81008; font-size:2rem;"></span> <?php echo $username; ?>
			        </a>
			        <ul class="dropdown-menu list-group list-group-item-info">
			        	<a href="employerProfile.php" class="list-group-item"><span class="glyphicon glyphicon-home"></span>  View profile</a>
			          	<a href="editEmployer.php" class="list-group-item"><span class="glyphicon glyphicon-inbox"></span>  Edit Profile</a>
					  	<a href="message.php" class="list-group-item"><span class="glyphicon glyphicon-envelope"></span>  Messages</a> 
					  	<a href="logout.php" class="list-group-item"><span class="glyphicon glyphicon-ok"></span>  Logout</a>
			        </ul>
			    </li>
			</ul>
		</div>		
	</div>	
</nav>
<!--End Navbar menu-->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h2 style="background: #fff;">My Gigs</h2>
            </div>

            <?php if ($result->num_rows > 0): ?>
                <div class="row">
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="col-md-4">
                            <div class="card">
                                <img src="https://st2.depositphotos.com/1444927/6033/i/450/depositphotos_60339431-stock-photo-test-time.jpg" alt="Gig Image">
                                <div class="card-body">
                                    <h4 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h4>
                                    <p class="card-text">
                                        Type: <?php echo htmlspecialchars($row['type']); ?><br>
                                        Subjects: <?php echo htmlspecialchars($row['subjects']); ?><br>
                                        Format: <?php echo htmlspecialchars($row['format']); ?><br>
                                    </p>
                                    <!-- Edit Job Button -->
                                    <?php if ($_SESSION["Usertype"] != 1 && $row['e_username'] == $username) { ?>
                                    
                                        
                                            <a href="editJob.php?job_id=<?php echo urlencode($row['job_id']); ?>" class="btn btn-warning">Edit Job</a>
                                        
                                    
                                    <?php } ?>
                                    <a href="deleteJob.php?job_id=<?php echo urlencode($row['job_id']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this job?');">Delete</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    You have not posted any gigs yet.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
