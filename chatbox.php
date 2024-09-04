<?php include('server.php');

// Check for logged-in user or guest user
if (isset($_SESSION["Username"])) {
    $username = $_SESSION["Username"];
    $contactUser = $_GET['user'];
} else {
    if (!isset($_SESSION['guest_username'])) {
        $_SESSION['guest_username'] = generateGuestUsername($conn);
    }
    $username = $_SESSION['guest_username'];
    $contactUser = $_GET['user'];
}

// Fetch chat history between logged-in user and contact user
$sql = "SELECT * FROM message 
        WHERE (sender='$username' AND receiver='$contactUser') 
        OR (sender='$contactUser' AND receiver='$username') 
        ORDER BY timestamp ASC";
$result = $conn->query($sql);

// Handle new message submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'];
    $sql = "INSERT INTO message (sender, receiver, msg, timestamp) VALUES ('$username', '$contactUser', '$message', NOW())";
    if ($conn->query($sql) === TRUE) {
        header("Location: chatbox.php?user=" . $contactUser);
    }
}

function formatTimestamp($timestamp) {
    $current_time = time();
    $time_difference = $current_time - strtotime($timestamp);

    if ($time_difference < 3600) {
        return round($time_difference / 60) . " minutes ago";
    } elseif ($time_difference < 86400) {
        return round($time_difference / 3600) . " hours ago";
    } elseif ($time_difference < 172800) {
        return "Yesterday at " . date("h:i A", strtotime($timestamp));
    } else {
        return date("M d, Y h:i A", strtotime($timestamp));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with <?php echo htmlspecialchars($contactUser); ?></title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="awesome/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Assuming you have a styles.css -->
    <style>
        body { 
            padding-top: 5px; 
            background-color: black; 
            color: #333; 
            font-family: Arial, sans-serif; 
        }
        .navbar { 
            margin-bottom: 0; 
            border-radius: 0; 
            background-color: #fff; 
            border: none; 
        }
        .navbar-brand { 
            color: #333 !important; 
        }
        .navbar-nav > li > a { 
            color: #333 !important; 
        }
        .chat-container { 
            display: flex; 
            flex-direction: column; 
            height: calc(80vh - 150px); 
            width: 100%; 
            max-width: 900px; 
            margin: 0 auto;
            padding-top: 50px; 
        }
        .chatbox { 
            display: flex; 
            flex-direction: column; 
            height: 120%; 
            background: #fff; 
            border-radius: 10px; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
        }
        .chat-header { 
            background: #a81008; 
            color: #eacc08; 
            padding: 15px; 
            border-radius: 10px 10px 0 0; 
            font-size: 18px; 
            font-weight: bold; 
            text-align: center; 
        }
        .chat-body { 
            flex: 1; 
            overflow-y: auto; 
            padding: 15px; 
            display: flex; 
            flex-direction: column; 
        }
        .message-container { 
            margin-bottom: 15px; 
            display: flex; 
            align-items: flex-start; 
            max-width: 80%; 
        }
        .left-message { 
            background: #a81008; 
            color: #eacc08;
            border-radius: 20px 20px 20px 0; 
            padding: 10px 15px; 
            margin-right: auto; 
        }
        .right-message { 
            background: #eacc08; 
            color: #a81008; 
            border-radius: 20px 20px 0 20px; 
            padding: 10px 15px; 
            margin-left: auto; 
        }
        .profile-icon { 
            width: 35px; 
            height: 35px; 
            border-radius: 50%; 
            color: #fff; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 16px; 
            font-weight: bold; 
            margin-right: 10px; 
        }
        .message-time { 
            font-size: 12px; 
            color: #aaa; 
            margin-top: 5px; 
        }
        .chat-input { 
            padding: 10px; 
            background: #f1f3f4; 
            border-top: 1px solid #ddd; 
            display: flex; 
            align-items: center; 
        }
        .chat-input textarea { 
            width: calc(200% - 10px); 
            height: 50px; 
            border: 1px solid #ddd; 
            border-radius: 20px; 
            padding: 10px; 
            font-size: 14px; 
            resize: none; 
            margin-right: 10px; 
        }
        .chat-input button { 
            background: #007bff; 
            color: #fff; 
            border: none; 
            border-radius: 20px; 
            padding: 10px 20px; 
            font-size: 14px; 
            cursor: pointer; 
        }
        .chat-input button:hover { 
            background: #0056b3; 
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Freelance Marketplace</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="allJob.php">Browse all jobs</a></li>
                <li><a href="allFreelancer.php">Browse Freelancers</a></li>
                <li><a href="allEmployer.php">Browse Employers</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <span class="glyphicon glyphicon-user"></span> <?php echo htmlspecialchars($username); ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="profile.php"><span class="glyphicon glyphicon-home"></span> View Profile</a></li>
                        <li><a href="message.php"><span class="glyphicon glyphicon-envelope"></span> Messages</a></li>
                        <li><a href="logout.php"><span class="glyphicon glyphicon-off"></span> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->

<!-- Chatbox -->
<div class="chat-container">
    <div class="chatbox">
        <div class="chat-header">
            Chat with <?php echo htmlspecialchars($contactUser); ?>
        </div>

        <div class="chat-body">
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="message-container <?php echo ($row['sender'] == $username) ? 'right-message' : 'left-message'; ?>">
                        <div class="profile><?php echo htmlspecialchars(substr(($row['sender'] == $username) ? $username : $contactUser, 0, 1)); ?></div>
                        <div class="message-content">
                            <p><?php echo htmlspecialchars($row['msg']); ?></p>
                            <small class="message-time"><?php echo formatTimestamp($row['timestamp']); ?></small>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No messages to display.</p>
            <?php endif; ?>
        </div>

        <div class="chat-input">
            <form method="post" action="chatbox.php?user=<?php echo htmlspecialchars($contactUser); ?>">
                <textarea name="message" placeholder="Type your message here..."></textarea>
                <button type="submit">Send</button>
            </form>
        </div>
    </div>
</div>
<!-- End Chatbox -->

<script src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
