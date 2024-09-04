<?php
include('server.php');

$username = $_SESSION["Username"];
$chat_with = $_POST['chat_with'];

// Fetch new messages after the last fetched timestamp
$sql = "SELECT * FROM message WHERE 
        (sender='$username' AND receiver='$chat_with') OR 
        (sender='$chat_with' AND receiver='$username') 
        ORDER BY timestamp ASC";
$result = $conn->query($sql);

$new_messages = [];
while($row = $result->fetch_assoc()) {
    $new_messages[] = $row;
}

echo json_encode($new_messages);
?>
