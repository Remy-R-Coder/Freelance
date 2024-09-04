<?php
include('server.php');

// Ensure the user is logged in
if (!isset($_SESSION['Username'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send-offer'])) {
    // Handle offer creation
    $contactUser = test_input($_POST['contact-user']);
    $description = test_input($_POST['offer-description']);
    $price = test_input($_POST['offer-price']);
    $timeline = test_input($_POST['offer-timeline']);

    $sql = "INSERT INTO offers (sender, receiver, description, price, timeline, status) 
            VALUES ('$username', '$contactUser', '$description', '$price', '$timeline', 'pending')";
    if ($conn->query($sql) === TRUE) {
        echo "Offer sent successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Offer</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#createOfferForm').on('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            $.ajax({
                url: 'create_offer.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    alert(response); // Show success message
                    $('#createOfferModal').modal('hide'); // Hide modal
                }
            });
        });
    });
    </script>
</head>
<body>
    <div class="container">
        <h2>Create Offer</h2>
        <form id="createOfferForm">
            <div class="form-group">
                <label for="contact-user">Receiver Username:</label>
                <input type="text" class="form-control" id="contact-user" name="contact-user" required>
            </div>
            <div class="form-group">
                <label for="offer-description">Description:</label>
                <textarea class="form-control" id="offer-description" name="offer-description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="offer-price">Price:</label>
                <input type="number" class="form-control" id="offer-price" name="offer-price" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="offer-timeline">Timeline (days):</label>
                <input type="number" class="form-control" id="offer-timeline" name="offer-timeline" required>
            </div>
            <button type="submit" class="btn btn-primary">Send Offer</button>
        </form>
    </div>
</body>
</html>
