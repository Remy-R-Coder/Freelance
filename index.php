<?php include('server.php');
if(isset($_SESSION["Username"])){
	$username=$_SESSION["Username"];
	if ($_SESSION["Usertype"]==1) {
		header("location: freelancerProfile.php");
	}
	else{
		header("location: employerProfile.php");
	}
}
else{
    $username="";
	//header("location: index.php");
}

 ?>


<!DOCTYPE html>
<html>
<head>
	<title>RemyInk!</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="awesome/css/fontawesome-all.min.css">
	<link rel="stylesheet" href="styl.css">
	
	

<style>
	body{padding-top: 3%;margin: 0; background-color:black;}
	.header1{background-color: black;padding-left: 1%;}
	.header2{padding:20px 40px 20px 40px;background-color:black;}
	.card{box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); background-color:black;}
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
<nav class="navbar navbar-inverse navbar-fixed-top" id="my-navbar" style="background-color:white;">
	<div class="container">
		<div>
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="index.php" class="navbar-brand" style="color:#a81008"> Welcome to RemyInk!</a>
		</div>
		<div class="collapse navbar-collapse" id="navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
				<li><a href="#services" style="color:#eacc08">Services</a></li>
				<li><a href="#how" style="color:#eacc08">How it works</a></li>

				<a class="dropdown-toggle" data-toggle="dropdown" href="#" style="margin-left: 15px; margin-top: 45px; font-size: 30px; color:#a81008;">
    <span class="glyphicon glyphicon-user"></span>
</a>
			        <ul class="dropdown-menu list-group list-group-item-info">
						<a href="#" class="list-group-item" id="clientLink"><span class="glyphicon glyphicon-home"></span> Client</a>

<script type="text/javascript">
    document.getElementById('clientLink').addEventListener('click', function(e) {
        e.preventDefault();

        // Make an AJAX request to the server
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'server.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Redirect to the guest profile page after response
                window.location.href = 'guest_Profile.php';
            }
        };

        // Send request with a flag to indicate this is for guest profile check
        xhr.send('contactEmployer=true');
    });
</script>

			          	<a href="loginReg.php" class="list-group-item"><span class="glyphicon glyphicon-inbox"></span> User</a>	
			</ul>
		</div>		
	</div>	
</nav>
<!--End Navbar menu-->



<!--Header and slider-->

<!--Header-->
<div class="row header1" style="width:100%; background-color:black;" >
	<div class="col-lg-6" style="background-color:black; margin:0px;">
		<div class="jumbotron" style="background-color:black;">
			<div class="container text-center">
			<div class="main" style="width:120%;">
    <div class="main_container" style="background-color:black;">
    <div class="main_content">
	<div class="main_img--container" style="width:160%; padding:0; height:500px;">    
        <img src="https://api.logo.com/api/v2/images?design=logo_8306aba4-a17e-4f60-bc88-6ed8b47f4e44&u=2024-09-02T08%3A01%3A41.126Z&format=svg&margins=166&width=1000&height=750&fit=contain" alt="logo" id="main_img">
		</div>
        </div>
		</div>
		</div>
			</div>
		</div>	
	</div>
<!--End Header-->

<!--slider-->
	<div class="col-lg-6" style="margin: 0; padding-left: 250px; padding-top:10px;">
		<div id="myCarousel" class="carousel slide" data-ride="carousel">
		  <!-- Indicators -->
		  <ol class="carousel-indicators">
		    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		    <li data-target="#myCarousel" data-slide-to="1"></li>
		    <li data-target="#myCarousel" data-slide-to="2"></li>
		  </ol>

		  <!-- Wrapper for slides -->
		  <div class="carousel-inner" role="listbox" >
		    <div class="item active">
		      <img src="https://assets.quillbot.com/pageq/QBWebapp/ai-detector-class-assignments-ai-refined-light-en.png" style="height:570px;" alt="Chania">
		      <div class="carousel-caption">
		        <h3 class="caption" style="margin-bottom: 490px;">0% AI USE</h3>
		      </div>
		    </div>

		    <div class="item">
		      <img src="https://qph.cf2.quoracdn.net/main-qimg-75a183c3a9777cd04855c3814dbec887" style="height:570px;" alt="Chania">
		      <div class="carousel-caption">
		        <h3 class="caption">Submission is accompanied by Plag report</h3>
		      </div>
		    </div>

		    <div class="item">
		      <img src="https://www.minitool.com/images/uploads/2022/09/grammarly-check-thumbnail.png" style="height:570px;" alt="Flower">
		      <div class="carousel-caption">
		        <h3 id="caption1" style="margin-bottom: 420px;">Standard Grammar Use supported by Grammarly</h3>
		      </div>
		    </div>

			<div class="item">
		      <img src="https://ucmwriting.weebly.com/uploads/5/9/1/2/59121359/citation-style-world-cloud-1_orig.png" style="height:570px;" alt="Flower">
		      <div class="carousel-caption">
		      </div>
		    </div>
		  </div>

		  <!-- Left and right controls -->
		  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
		    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		    <span class="sr-only">Previous</span>
		  </a>
		  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
		    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		    <span class="sr-only">Next</span>
		  </a>
		</div>
	</div>
</div>
<!--End slider-->
<!--End Header and slider-->

<!--Services Section-->
<div class="services" id="services" style="margin-top: 0px;">
    <div class="services_container">
        <div class="services_card"> 
            <h2 style="margin-top: 20px; color: #a81008;">Exams & Quizzes</h2>
            <p>Achieve high grades</p>
            <button class="main_btn" style="padding: 15px 30px; font-size: 18px;" onclick="handleGetStarted('exams_quizzes.php')">Get Started</button>
        </div>
        <div class="services_card"> 
            <h2 style="margin-top: 20px;">Essays & Research</h2>
            <p>Standard Papers with no AI and plagiarism</p>
            <button class="main_btn" style="padding: 15px 30px; font-size: 18px;" onclick="handleGetStarted('research_essays.php')">Get Started</button>
        </div>
        <div class="services_card"> 
            <h2 style="margin-top: 20px;">Tutoring</h2>
            <p>We help you understand challenging concepts</p>
            <button class="main_btn" style="padding: 15px 30px; font-size: 18px;" onclick="handleGetStarted('tutoring.php')">Get Started</button>
        </div>
    </div>
</div>

<script type="text/javascript">
function handleGetStarted(redirectPage) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'server.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.guest_id) {
                window.location.href = redirectPage;
            } else {
                alert('Error generating guest session.');
            }
        }
    };
    xhr.send('checkGuestSession=true');
}
</script>

<!-- How it works -->
<div style="background:#000000">
  <div class="container text-center" style="padding:0%; background:#000000" id="how">
    <h1 class="card header2" style="color:#a81008">How it works</h1>
    
      <div class="col-lg-12" style="background:black"> <!-- Changed to col-lg-12 for full-width alignment -->
        <div class="flex-container" style="background:black">
          <div class="flex-item">
            <h3 style="color:#eacc08">Explore our services</h3>
            <img src="image/img01.jpg" alt="Post Projects">
          </div>
          <div class="flex-item">
            <h3 style="color:#eacc08">Place an Order and make a safe payment. We have a good refund policy to ensure satisfaction with the completed project.</h3>
            <img src="image/img02.jpg" alt="Deposit Money">
          </div>
          <div class="flex-item">
            <h3 style="color:#eacc08">Communicate with us in real-time, to place an order and track the work progress</h3>
            <img src="image/img03.jpg" alt="Communicate with us">
          </div>
        </div>
      </div>
    
  </div>
</div>
<!-- End How it works -->

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