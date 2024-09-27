<!-- Header -->
<?php include 'includes/header.php'; ?>

<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $loggedin = true;
} else {
    $loggedin = false;
}
?>

<!DOCTYPE html>
<html lang="en"></html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>No Ticket Available</title>
    <style>
        .message-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            background-color: #f8f9fa;
        }

        .message-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .message-box h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .message-box p {
            font-size: 1rem;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="message-container">
        <div class="message-box">
            <h1>No Ticket Available</h1>
            <p>Sorry, there are no tickets available at the moment. Please check back later.</p>
        </div>
    </div>

<!-- Footer -->
<?php include 'includes/footer.php'; ?>