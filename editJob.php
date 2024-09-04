<?php
include('server.php');

if (isset($_SESSION["Username"])) {
    $username = $_SESSION["Username"];
} else {
    $username = "";
    //header("location: index.php");
}

if (isset($_POST["editJob"])) {
    $title = test_input($_POST["title"]);
    $type = test_input($_POST["type"]);
    $subjects = implode(', ', $_POST["subjects"]);
    $format = implode(', ', $_POST["format"]); // Handle multiple formats

            // Update SQL query to insert the data
            $sql = "UPDATE job_offer SET title='$title', type='$type', subjects='$subjects', format='$format' WHERE job_id='$_SESSION[job_id]'";
            $result = $conn->query($sql);
            if ($result == true) {
                header("location: jobDetails.php");
            }
        } 


// Fetch job details for editing
if (isset($_SESSION["job_id"])) {
    $job_id = $_SESSION["job_id"];
    $sql = "SELECT * FROM job_offer WHERE job_id='$job_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $title = $row["title"];
            $type = $row["type"];
            $subjects = explode(', ', $row["subjects"]);
            $format = explode(', ', $row["format"]);
            
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Job</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="awesome/css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="dist/css/bootstrapValidator.css">
    <style>
        body { padding-top: 3%; margin: 0; }
        .card { box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); background: #fff; }
    </style>
</head>
<body>

<!--Navbar menu-->
<nav class="navbar navbar-inverse navbar-fixed-top" id="my-navbar">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="index.php" class="navbar-brand">Freelance Marketplace</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="allJob.php">Browse all jobs</a></li>
                <li><a href="allFreelancer.php">Browse Freelancers</a></li>
                <li><a href="allEmployer.php">Browse Employers</a></li>
                <li class="dropdown" style="background:#000;padding:0 20px 0 20px;">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $username; ?></a>
                    <ul class="dropdown-menu list-group list-group-item-info">
                        <a href="employerProfile.php" class="list-group-item"><span class="glyphicon glyphicon-home"></span> View profile</a>
                        <a href="editEmployer.php" class="list-group-item"><span class="glyphicon glyphicon-inbox"></span> Edit Profile</a>
                        <a href="message.php" class="list-group-item"><span class="glyphicon glyphicon-envelope"></span> Messages</a>
                        <a href="logout.php" class="list-group-item"><span class="glyphicon glyphicon-ok"></span> Logout</a>
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
                <h2>Edit Job Offer</h2>
            </div>

            <form id="editJobForm" method="post" class="form-horizontal" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Gig Title</label>
                    <div class="col-sm-5">
                        <select class="form-control" name="title">
                            <option value="Essay Writing" <?php echo ($title == "Essay Writing") ? 'selected' : ''; ?>>Essay Writing</option>
                            <option value="Research Paper Assistance" <?php echo ($title == "Research Paper Assistance") ? 'selected' : ''; ?>>Research Paper Assistance</option>
                            <option value="Homework Help" <?php echo ($title == "Homework Help") ? 'selected' : ''; ?>>Homework Help</option>
                            <option value="Thesis & Dissertation Support" <?php echo ($title == "Thesis & Dissertation Support") ? 'selected' : ''; ?>>Thesis & Dissertation Support</option>
                            <option value="Coursework Guidance" <?php echo ($title == "Coursework Guidance") ? 'selected' : ''; ?>>Coursework Guidance</option>
                            <option value="Tutoring Sessions" <?php echo ($title == "Tutoring Sessions") ? 'selected' : ''; ?>>Tutoring Sessions</option>
                            <option value="Exam Preparation" <?php echo ($title == "Exam Preparation") ? 'selected' : ''; ?>>Exam Preparation</option>
                            <option value="Proofreading & Editing" <?php echo ($title == "Proofreading & Editing") ? 'selected' : ''; ?>>Proofreading & Editing</option>
                            <option value="Presentation Design" <?php echo ($title == "Presentation Design") ? 'selected' : ''; ?>>Presentation Design</option>
                            <option value="Study Plan Development" <?php echo ($title == "Study Plan Development") ? 'selected' : ''; ?>>Study Plan Development</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Type</label>
                    <div class="col-sm-5">
                        <select class="form-control" name="type">
                            <option value="Exams & Quizzes" <?php echo ($type == "Exams & Quizzes") ? 'selected' : ''; ?>>Exams & Quizzes</option>
                            <option value="Essays & Research" <?php echo ($type == "Essays & Research") ? 'selected' : ''; ?>>Essays & Research</option>
                            <option value="Tutoring" <?php echo ($type == "Tutoring") ? 'selected' : ''; ?>>Tutoring</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Subjects</label>
                    <div class="col-sm-5">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="subjects[]" value="Mathematics" <?php echo in_array('Mathematics', $subjects) ? 'checked' : ''; ?>> Mathematics
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="subjects[]" value="Physics" <?php echo in_array('Physics', $subjects) ? 'checked' : ''; ?>> Physics
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="subjects[]" value="Chemistry" <?php echo in_array('Chemistry', $subjects) ? 'checked' : ''; ?>> Chemistry
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="subjects[]" value="Biology" <?php echo in_array('Biology', $subjects) ? 'checked' : ''; ?>> Biology
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="subjects[]" value="History" <?php echo in_array('History', $subjects) ? 'checked' : ''; ?>> History
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="subjects[]" value="Literature" <?php echo in_array('Literature', $subjects) ? 'checked' : ''; ?>> Literature
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="subjects[]" value="Economics" <?php echo in_array('Economics', $subjects) ? 'checked' : ''; ?>> Economics
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="subjects[]" value="Geography" <?php echo in_array('Geography', $subjects) ? 'checked' : ''; ?>> Geography
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="subjects[]" value="Computer Science" <?php echo in_array('Computer Science', $subjects) ? 'checked' : ''; ?>> Computer Science
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="subjects[]" value="Political Science" <?php echo in_array('Political Science', $subjects) ? 'checked' : ''; ?>> Political Science
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Format</label>
                    <div class="col-sm-5">
                        <select class="form-control" name="format[]" multiple size="7" onchange="limitSelection(this, 4)">
                            <option value="APA" <?php echo in_array('APA', $format) ? 'selected' : ''; ?>>APA</option>
                            <option value="MLA" <?php echo in_array('MLA', $format) ? 'selected' : ''; ?>>MLA</option>
                            <option value="Chicago/Turabian" <?php echo in_array('Chicago/Turabian', $format) ? 'selected' : ''; ?>>Chicago/Turabian</option>
                            <option value="Harvard" <?php echo in_array('Harvard', $format) ? 'selected' : ''; ?>>Harvard</option>
                            <option value="IEEE" <?php echo in_array('IEEE', $format) ? 'selected' : ''; ?>>IEEE</option>
                            <option value="AMA" <?php echo in_array('AMA', $format) ? 'selected' : ''; ?>>AMA</option>
                            <option value="Vancouver" <?php echo in_array('Vancouver', $format) ? 'selected' : ''; ?>>Vancouver</option>
                        </select>
                        <small class="form-text text-muted">Select up to 4 formats.</small>
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-5">
                        <button type="submit" name="editJob" class="btn btn-primary" href="mygigs.php">Update Job</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function limitSelection(select, max) {
    var options = select.options;
    var selectedCount = 0;
    
    for (var i = 0; i < options.length; i++) {
        if (options[i].selected) {
            selectedCount++;
        }
    }
    
    if (selectedCount > max) {
        alert('You can only select up to ' + max + ' formats.');
        select.options[select.selectedIndex].selected = false;
    }
}
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
