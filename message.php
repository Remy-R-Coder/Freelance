<?php 
include('server.php');

// Check for logged-in user or guest user
if (isset($_SESSION["Username"])) {
    $username = $_SESSION["Username"];
    if ($_SESSION["Usertype"] == 1) {
        $linkPro = "freelancerProfile.php";
        $linkEditPro = "editFreelancer.php";
    } else {
        $linkPro = "employerProfile.php";
        $linkEditPro = "editEmployer.php";
    }
} else {
    if (!isset($_SESSION['guest_username'])) {
        $_SESSION['guest_username'] = generateGuestUsername($conn);
    }
    $username = $_SESSION['guest_username'];
    $linkPro = "guestProfile.php";
    $linkEditPro = "";
}

// Fetch list of contacts with the last message
$sqlContacts = "SELECT sender, receiver, msg, timestamp FROM message 
        WHERE sender='$username' OR receiver='$username' 
        GROUP BY LEAST(sender, receiver), GREATEST(sender, receiver) 
        ORDER BY timestamp DESC";
$resultContacts = $conn->query($sqlContacts);

// Handle new message submission
if (isset($_GET['user']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $contactUser = $_GET['user'];
    $message = $_POST['message'];

    // Check if it's an offer submission
    if (isset($_POST['offer_title']) && isset($_POST['offer_details']) && isset($_POST['offer_price'])) {
        $offerTitle = $_POST['offer_title'];
        $offerDetails = $_POST['offer_details'];
        $offerPrice = $_POST['offer_price'];

        // Insert the offer into the `offers` table
        $sqlOffer = "INSERT INTO offers (sender, receiver, description, price, timeline, status, created_at) 
                     VALUES ('$username', '$contactUser', '$offerDetails', '$offerPrice', 'Not specified', 'pending', NOW())";
        $conn->query($sqlOffer);

        $message = "Offer sent: $offerTitle\nDetails: $offerDetails\nPrice: \$$offerPrice";
    }

    // Insert the message into the `message` table
    $sqlSend = "INSERT INTO message (sender, receiver, msg, timestamp) VALUES ('$username', '$contactUser', '$message', NOW())";
    $conn->query($sqlSend);
    header("Location: message.php?user=" . $contactUser . "#last_message");
    exit();
}

// Fetch chat history if a user is selected
if (isset($_GET['user'])) {
    $contactUser = $_GET['user'];
    $sqlChat = "SELECT * FROM message 
                WHERE (sender='$username' AND receiver='$contactUser') 
                OR (sender='$contactUser' AND receiver='$username') 
                ORDER BY timestamp ASC";
    $resultChat = $conn->query($sqlChat);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Messages</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="awesome/css/fontawesome-all.min.css">

    <style>
        body {padding-top: 3%; margin: 0; background-color: #000 }
        .card {box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); background: #fff;}
        .chat-container {display: flex; width: 100%; height: 80vh; margin-top: 20px;}
        .contacts {flex: 1; border-right: 1px solid #ddd; padding: 20px;}
        .chatbox {flex: 2; padding: 20px;}
        .chatbox textarea {width: 100%; height: 80px; margin-top: 10px;}
        .chat-history {height: 60vh; overflow-y: scroll; border: 1px solid #ddd; padding: 10px; margin-bottom: 10px;}
        .contact-item {padding: 10px; border-bottom: 1px solid #ddd;}
        .contact-item:hover {background-color: #f9f9f9;}

        .message-left {
            text-align: left;
            margin-bottom: 10px;
            padding: 10px;
            background-color: #eacc08;
            border-radius: 10px;
            max-width: 60%;
        }

        .message-right {
            text-align: right;
            margin-bottom: 10px;
            padding: 10px;
            background-color: #a81008;
            color: #eacc08;
            border-radius: 10px;
            max-width: 60%;
            margin-left: auto;
        }

        /* Style for the typing area */
        .typing-area {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .typing-area textarea {
            flex: 1;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #ddd;
            resize: none;
        }

        .typing-area button {
            margin-left: 10px;
            padding: 10px 20px;
            border-radius: 10px;
            border: none;
            background-color: #28a745;
            color: white;
        }

        /* Style for offer box */
        .offer-box {
            display: none;
            border: 1px solid #ddd;
            padding: 20px;
            background-color: #f9f9f9;
            margin-top: 20px;
        }

        #show-offer-box {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #ffbb33;
            border: none;
            color: white;
            cursor: pointer;
        }

        #cancel-offer {
            margin-top: 10px;
            padding: 5px 10px;
            background-color: #ddd;
            border: none;
            cursor: pointer;
        }

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
<nav class="navbar navbar-fixed-top" id="my-navbar" style="background-color:#fff">
    <div class="container" style="background-color:#fff">
        <a href="index.php" class="navbar-brand" style="color:#a81008">RemyInk!</a>
    </div>
    <div class="collapse navbar-collapse" id="navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
        </ul>
    </div>      
</nav>
<!--End Navbar menu-->
<style>
.back-icon {
    font-size: 24px;
    color: #333;
    text-decoration: none;
    margin-right: 10px;
    margin-top: 20px;
    display: inline-flex;
    align-items: center;
}
.back-icon:hover {
    color: #000;
}
.back-text {
    margin-left: 5px;
    font-size: 18px;
}
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <!-- Backward Arrow Icon -->
            <a href="guest_profile.php" class="back-icon">
                <i class="fas fa-arrow-left"></i> 
                <span class="back-text" style="font-size:2rem; color:#fff">&larr; Back</span>
            </a>
        </div>
    </div>
</div>
<!--Main Body-->
<div class="container">
    <div class="chat-container">
        
        <!--Contacts List-->
        <div class="contacts">
            <h3 style="color:#a81008;">Contacts</h3>
            <?php
            if ($resultContacts->num_rows > 0) {
                while($row = $resultContacts->fetch_assoc()) {
                    $contactUser = $row["sender"] == $username ? $row["receiver"] : $row["sender"];
                    echo '<div class="contact-item" style=" color:#a81008;"><a href="message.php?user='.$contactUser.'" style="font-size:2rem; color:#eacc08;">'.$contactUser.'</a></div>';
                }
            } else {
                echo "<p>No contacts available.</p>";
            }
            ?>
        </div>
        
        <!--Chatbox-->
        <div class="chatbox">
            <h3 style="color:#a81008; font-size:3rem;">Chat</h3>
            <?php if (isset($_GET['user'])): ?>
                <div class="chat-history">
                    <?php
                    if ($resultChat->num_rows > 0) {
                        while($row = $resultChat->fetch_assoc()) {
                            $isSender = $row["sender"] == $username;
                            $messageClass = $isSender ? "message-right" : "message-left";
                            echo '<div class="'.$messageClass.'">'.$row["msg"].'</div>';
                        }
                    } else {
                        echo "<p>No messages available.</p>";
                    }
                    ?>
                    <div id="last_message"></div>
                </div>
                
                <!--Form to submit new messages or offers-->
                <form method="POST" action="">
                    <div class="typing-area">
                        <textarea name="message" placeholder="Type a message..."></textarea>
                        <button type="submit">Send</button>
                    </div>

                    <?php if ($_SESSION["Usertype"] == 2): ?>
                        <!-- Show offer button for employers -->
                        <button type="button" id="show-offer-box">Create Offer</button>
                        <div class="offer-box" id="offer-box">
                            <h4>Create a New Offer</h4>
                            <input type="text" name="offer_title" placeholder="Offer Title" required><br><br>
                            <textarea name="offer_details" placeholder="Offer Details" required></textarea><br><br>
                            <input type="number" name="offer_price" placeholder="Offer Price ($)" required><br><br>
                            <button type="submit">Send Offer</button>
                            <button type="button" id="cancel-offer">Cancel</button>
                        </div>
                    <?php endif; ?>
                </form>

            <?php else: ?>
                <p style="color:#eacc08; font-size:2rem;">Please select a contact to start chatting.</p>
            <?php endif; ?>
        </div>
        
    </div>
</div>

<script>
    document.getElementById('show-offer-box').addEventListener('click', function() {
        document.getElementById('offer-box').style.display = 'block';
    });

    document.getElementById('cancel-offer').addEventListener('click', function() {
        document.getElementById('offer-box').style.display = 'none';
    });
</script>

<!--End Main Body-->
<footer class="footer">
    <p>&copy; RemyInk. All rights reserved 2023</p>
</footer>

</body>
</html>
