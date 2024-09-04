<?php
include('server.php');

if (!isset($_SESSION["Username"])) {
    header("location: index.php");
    exit();
}
if (isset($_GET['job_id'])) {
    echo "Job ID: " . $_GET['job_id'];
} else {
    echo "Job ID not set!";
}


$username = $_SESSION["Username"];
$job_id = isset($_GET['job_id']) ? intval($_GET['job_id']) : 0;

if ($job_id > 0) {
    // Use the correct column name in the WHERE clause
    $sql = "DELETE FROM job_offer WHERE job_id = $job_id AND e_username = '$username'";
    if ($conn->query($sql) === TRUE) {
        header("location: mygigs.php");
        exit();
    } else {
        echo "Error deleting job: " . $conn->error;
    }
} else {
    echo "Invalid job ID.";
}
?>
