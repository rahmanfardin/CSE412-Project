<?php
session_start();
include 'includes/dbcon.php';

// Check if ticket ID is provided
if (!isset($_GET['ticketid'])) {
    echo "<h2>No ticket ID provided.</h2>";
    echo '<meta http-equiv="refresh" content="2;url=index.php">';
    exit;
}

$ticketid = intval($_GET['ticketid']);

// Fetch ticket details from the database
$sql = "SELECT t.ticketid, m.moviename, m.genre, m.movierating, s.date, s.slot, h.hallname, u.username, u.email
        FROM ticket t
        JOIN slottable s ON t.slotid = s.slotid
        JOIN movietable m ON s.movieid = m.movieid
        JOIN halltable h ON s.hallid = h.hallid
        JOIN usertable u ON t.userid = u.id
        WHERE t.ticketid = $ticketid";
$tickets = $conn->query($sql);


if ($tickets->num_rows == 0) {
    echo "<h2>Ticket not found.</h2>";
    echo '<meta http-equiv="refresh" content="2;url=index.php">';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Ticket</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .ticket-container {
            max-width: 842px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .ticket-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .ticket-details {
            margin-bottom: 20px;
        }

        .ticket-details p {
            margin: 5px 0;
        }

        .print-button {
            text-align: center;
        }
    </style>
</head>

<body>
    <?php foreach ($tickets as $ticket): ?>
        <div id="ticket-container-<?php echo htmlspecialchars($ticket['ticketid']); ?>" class="ticket-container">
            <div class="ticket-header">
                <h2>Movie Ticket</h2>
            </div>
            <div class="ticket-details">
                <p><strong>Ticket ID:</strong> <?php echo htmlspecialchars($ticket['ticketid']); ?></p>
                <p><strong>Movie Name:</strong> <?php echo htmlspecialchars($ticket['moviename']); ?></p>
                <p><strong>Genre:</strong> <?php echo htmlspecialchars($ticket['genre']); ?></p>
                <p><strong>Rating:</strong> <?php echo htmlspecialchars($ticket['movierating']); ?></p>
                <p><strong>Date:</strong> <?php echo htmlspecialchars($ticket['date']); ?></p>
                <p><strong>Slot:</strong> <?php echo htmlspecialchars($ticket['slot']); ?></p>
                <p><strong>Hall Name:</strong> <?php echo htmlspecialchars($ticket['hallname']); ?></p>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($ticket['username']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($ticket['email']); ?></p>
            </div>
            <div class="print-button">
                <button onclick="printTicket('ticket-container-<?php echo htmlspecialchars($ticket['ticketid']); ?>')"
                    class="btn btn-primary">Print Ticket</button>
            </div>
        </div>
    <?php endforeach; ?>

    <script>
        function printTicket(containerId) {
            var printContents = document.getElementById(containerId).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
</body>

</html>

<?php
$conn->close();
?>