<?php include('server.php');
if(isset($_SESSION["Username"])){
	$username=$_SESSION["Username"];
}
else{
	$username="";
	//header("location: index.php");
}

if(isset($_POST["jid"])){
	$_SESSION["job_id"]=$_POST["jid"];
	header("location: jobDetails.php");
}

if(isset($_POST["f_user"])){
	$_SESSION["f_user"]=$_POST["f_user"];
	header("location: viewFreelancer.php");
}


$sql = "SELECT * FROM employer WHERE username='$username'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $name=$row["Name"];
        $email=$row["email"];
        $contactNo=$row["contact_no"];
        }
} else {
    echo "0 results";
}

$sql = "SELECT * FROM job_offer WHERE e_username='$username' and valid=1 ORDER BY timestamp DESC";
$result = $conn->query($sql);

 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Employer profile</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="awesome/css/fontawesome-all.min.css">
	<link rel="stylesheet" href="style.css">


<style>
	body{padding-top: 3%;margin: 0; background-color: #000;}
	.card{box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); background:#000; }
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


<!--main body-->
<div style="padding:1% 3% 1% 3%;">
<div class="row">

<!--Column 1-->
	<div class="col-lg-2">

<!--Main profile card-->
		<div class="card" style="padding:20px 20px 5px 20px;margin-top:20px">
			<p></p>
			<img src="image/img04.jpg">
			<h2 style="color:#eacc08"><?php echo $name; ?></h2>
			<p style="color:#a81008; font-size:2rem;"><span class="glyphicon glyphicon-user" style="color:#a81008; font-size:2rem;"></span> <?php echo $username; ?></p>
			<ul class="list-group">
				<a href="postJob.php" class="list-group-item list-group-item-info">Post Gig</a>
				<a href="mygigs.php" class="list-group-item list-group-item-info">My Gigs</a>
	          	<a href="editEmployer.php" class="list-group-item list-group-item-info">Edit Profile</a>
			  	<a href="message.php" class="list-group-item list-group-item-info">Messages</a>
			  	<a href="logout.php" class="list-group-item list-group-item-info">Logout</a>
	        </ul>
	    </div>
<!--End Main profile card-->


	</div>
<!--End Column 1-->

<!--Column 2-->
	<div class="col-lg-7">

<!--Freelancer Profile Details-->	
<div class="card" style="padding:20px 20px 5px 20px;margin-top:20px;">
			<div class="panel panel-primary">
			  <div class="panel-heading"><h3>Dashboard</h3></div>
			</div>
			<div class="panel panel-primary">
			  <div class="panel-heading" style="background-color:#000;">Current Orders</div>
			  <div class="panel-body"><h4>
                  <table style="width:100%">
					  <tr>
                          <td>Order Id</td>
                          <td>Timeline</td>
                          <td>Amount</td>
                      </tr>
                      <?php 
                      	$sql = "SELECT * FROM job_offer,selected WHERE job_offer.job_id=selected.job_id AND selected.f_username='$username' AND selected.valid=1 ORDER BY job_offer.job_id DESC";
						$result = $conn->query($sql);
                      if ($result->num_rows > 0) {
                            // output data of each row
                            while($row = $result->fetch_assoc()) {
                                $job_id=$row["job_id"];
                                $title=$row["title"];
                                $e_username=$row["e_username"];
                                $timestamp=$row["timestamp"];

                                echo '
                                <form action="employerProfile.php" method="post">
                                <input type="hidden" name="jid" value="'.$job_id.'">
                                    <tr>
                                    <td>'.$job_id.'</td>
                                    <td><input type="submit" class="btn btn-link btn-lg" value="'.$title.'"></td>
                                    </form>
                                    <form action="employerProfile.php" method="post">
                                    <input type="hidden" name="e_user" value="'.$e_username.'">
                                    <td><input type="submit" class="btn btn-link btn-lg" value="'.$e_username.'"></td>
                                    <td>'.$timestamp.'</td>
                                    </tr>
                                </form>
                                ';

                                }
                        } else {
                            echo "<tr><td>Nothing to show</td></tr>";
                        }

                       ?>
                  </table>
              </h4></div>
			</div>
					<div class="panel panel-primary">
			  <div class="panel-heading">My Gigs</div>
<!--Services Section-->
<div class="services">
    <div class="services_container">
        <div class="services_card"> 
            <h2>Exams & Quizzes</h2>
            <button><a href="mygigs.php">Explore Gigs</a></button>
        </div>
        <div class="services_card"> 
            <h2>Essays & Research</h2>
            <button><a href="mygigs.php">Explore Gigs</a></button>
        </div>
        <div class="services_card"> 
            <h2>Tutoring</h2>
            <button><a href="mygigs.php">Explore Gigs</a></button>
        </div>
    </div>
</div>
			</div>
		</div>
<!--End Freelancer Profile Details-->

	</div>
<!--End Column 2-->


<!--Column 3-->
	<div class="col-lg-3">
<!--My Wallet-->
		<div class="card" style="padding:20px 20px 5px 20px;margin-top:20px">
			<div class="panel panel-info">
			  <div class="panel-heading"><h3>My Wallet</h3></div>
			</div>
			<ul class="list-group">
			  <li class="list-group-item">Balance: $0.0</li>
			  <li class="list-group-item">Payment Method: </li>
			  <li class="list-group-item">Deposit</li>
			</ul>
		</div>
<!--End My Wallet-->
<!--Reputation-->
<div class="card" style="padding:20px 20px 5px 20px;margin-top:20px">
			<div class="panel panel-warning">
			  <div class="panel-heading"><h4>Reputation</h4></div>
			</div>
			<div class="panel panel-warning">
			  <div class="panel-heading">Reviews</div>
			  <div class="panel-body">Nothing to show</div>
			</div>
		</div>
<!--End Reputation-->
	</div>
<!--End Column 3-->

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


<script type="text/javascript" src="jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>