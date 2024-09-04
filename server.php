<?php
session_start();

// Create connection
$conn = new mysqli("localhost", "root", "", "fmarket");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $name = $email = $password = $contactNo = $usertype = "";

// Registration process
if (isset($_POST["register"])) {
    $username = test_input($_POST["username"]);
    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
    $repassword = test_input($_POST["repassword"]);
    $contactNo = test_input($_POST["contactNo"]);
    $usertype = test_input($_POST["usertype"]);

    $sql = "SELECT * FROM freelancer WHERE username = '$username' UNION SELECT * FROM employer WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION["errorMsg2"] = "The username is already taken";
    } else {
        unset($_SESSION["errorMsg2"]);
        if ($usertype == "freelancer") {
            $sql = "INSERT INTO freelancer (username, password, Name, email, contact_no) VALUES ('$username', '$password', '$name','$email','$contactNo')";
        } else {
            $sql = "INSERT INTO employer (username, password, Name, email, contact_no) VALUES ('$username', '$password', '$name','$email','$contactNo')";
        }
        $result = $conn->query($sql);

        if ($result == true) {
            $_SESSION["Username"] = $username;
            $_SESSION["Usertype"] = ($usertype == "freelancer") ? 1 : 2;
            header("location: " . (($usertype == "freelancer") ? "freelancerProfile.php" : "employerProfile.php"));
        }
    }
}

// Login process
if (isset($_POST["login"])) {
    session_unset();
    $username = test_input($_POST["username"]);
    $password = test_input($_POST["password"]);
    $usertype = test_input($_POST["usertype"]);

    if ($usertype == "freelancer") {
        $sql = "SELECT * FROM freelancer WHERE username = '$username' AND password = '$password'";
    } else {
        $sql = "SELECT * FROM employer WHERE username = '$username' AND password = '$password'";
    }

    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $_SESSION["Username"] = $username;
        $_SESSION["Usertype"] = ($usertype == "freelancer") ? 1 : 2;
        unset($_SESSION["errorMsg"]);
        header("location: " . (($usertype == "freelancer") ? "freelancerProfile.php" : "employerProfile.php"));
    } else {
        $_SESSION["errorMsg"] = "Username/password is incorrect";
    }
}

// Handle the AJAX request for guest session check
if (isset($_POST['checkGuestSession']) && $_POST['checkGuestSession'] == 'true') {
    $guestUsername = getOrCreateGuestProfile($conn);
    echo json_encode(['guest_id' => $guestUsername]);
    exit;
}

// Handle offer creation
if (isset($_POST['send-offer'])) {
    $contactUser = test_input($_POST['contact-user']);
    $description = test_input($_POST['offer-description']);
    $price = test_input($_POST['offer-price']);
    $timeline = test_input($_POST['offer-timeline']);

    $sql = "INSERT INTO offers (sender, receiver, description, price, timeline, status) 
            VALUES ('$username', '$contactUser', '$description', '$price', '$timeline', 'pending')";
    if ($conn->query($sql) === TRUE) {
        header("Location: message.php?user=" . $contactUser);
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle offer acceptance
if (isset($_GET['accept_offer'])) {
    $offerId = (int)$_GET['accept_offer'];
    $sql = "UPDATE offers SET status = 'accepted' WHERE id = $offerId";
    if ($conn->query($sql) === TRUE) {
        // Redirect to checkout or other necessary action
        header("Location: checkout.php?offer_id=" . $offerId);
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle offer rejection
if (isset($_GET['reject_offer'])) {
    $offerId = (int)$_GET['reject_offer'];
    $sql = "UPDATE offers SET status = 'rejected' WHERE id = $offerId";
    if ($conn->query($sql) === TRUE) {
        header("Location: message.php?user=" . $_SESSION['Username']);
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Error message handling
$errorMsg = $_SESSION["errorMsg"] ?? "";
$errorMsg2 = $_SESSION["errorMsg2"] ?? "";

// Function to sanitize input
function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Function to generate a unique guest username
function generateGuestUsername($conn) {
    $guestPrefix = 'Client';
    $query = "SELECT MAX(CAST(SUBSTRING(username, LENGTH('$guestPrefix') + 1) AS UNSIGNED)) AS max_id FROM guest_profile WHERE username LIKE '$guestPrefix%'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $newId = $row['max_id'] + 1;
    return $guestPrefix . str_pad($newId, 3, '0', STR_PAD_LEFT);
}

// Function to create a new guest profile
function createGuestProfile($conn) {
    $guestUsername = generateGuestUsername($conn);
    $sessionId = session_id();

    $stmt = $conn->prepare("INSERT INTO guest_profile (username, session_id) VALUES (?, ?)");
    $stmt->bind_param("ss", $guestUsername, $sessionId);
    $stmt->execute();
    $stmt->close();

    return $guestUsername;
}

// Function to retrieve or create guest profile
function getOrCreateGuestProfile($conn) {
    if (isset($_SESSION['guest_username'])) {
        return $_SESSION['guest_username'];
    }

    $sessionId = session_id();
    $query = "SELECT username FROM guest_profile WHERE session_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $sessionId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $_SESSION['guest_username'] = $row['username'];
        return $row['username'];
    } else {
        $guestUsername = createGuestProfile($conn);
        $_SESSION['guest_username'] = $guestUsername;
        return $guestUsername;
    }
}

// Rest of your existing code...

// $conn->close();
?>
