<?php
include 'includes/dbcon.php';

// Check if ticket ID is provided
if (!isset($_GET['ticketid'])) {
	echo "<h2>No ticket ID provided.</h2>";
	echo '<meta http-equiv="refresh" content="2;url=index.php">';
	exit;
}

$ticketid = intval($_GET['ticketid']);

// Fetch ticket details from the database
$sql = "SELECT t.ticketid, m.moviename, m.genre, m.movierating, s.date, s.slot, h.hallname, h.location, u.username, u.email, u.name, sta.seatno,
               (SELECT COUNT(*) FROM seattable st WHERE st.ticketid = t.ticketid) AS seat_count
        FROM ticket t
        JOIN slottable s ON t.slotid = s.slotid
        JOIN movietable m ON s.movieid = m.movieid
        JOIN halltable h ON s.hallid = h.hallid
        JOIN usertable u ON t.userid = u.id
		JOIN seattable sta ON t.ticketid = sta.ticketid
        WHERE t.ticketid = $ticketid";
$sql2 = "SELECT t.ticketid, sta.seatno
		FROM ticket t
		JOIN seattable sta ON t.ticketid = sta.ticketid
		WHERE t.ticketid = $ticketid";
$result = $conn->query($sql);
$a = $conn->query($sql2);

if ($result->num_rows == 0) {
	echo "<h2>Ticket not found.</h2>";
	echo '<meta http-equiv="refresh" content="2;url=index.php">';
	exit;
}

$ticket = $result->fetch_assoc();
?>

<html>

<head>
	<meta charset="utf-8">
	<title>Invoice</title>
	<link rel="stylesheet" href="css/ticket.css">
	<script src="js/ticket.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
	<script>
		window.onload = function() {
			var element = document.getElementById('ticketContent');
			html2pdf().from(element).save('ticket.pdf');
		};
	</script>
</head>

<body id="ticketContent">
	<div>

		<header>
			<h1>Invoice</h1>
			<h2>
				<address>
					<p><b>Name: </b><?php echo $ticket['name'] ?></p>
					<p><b>Username: </b><?php echo $ticket['username'] ?></p>
					<p><b>Email: </b><?php echo $ticket['email'] ?></p>
				</address>
			</h2>

			<span><img alt="" src=""><input type="file" accept="image/*"></span>
		</header>

		<!-- <h1>Recipient</h1> -->

		<article>
			<address>
				<img alt="" src="assets/favicon.ico">
				<p style="display: inline-block; margin-top: 17px; padding-left: 5px;">Ticketer</p>

			</address>

			<table class="meta">
				<tr>
					<th><span>Invoice #</span></th>
					<td><span><?php echo $ticket['ticketid'] ?></span></td>
				</tr>
				<tr>
					<th><span>Date</span></th>
					<td><span><?php echo $ticket['date'] ?></span></td>
				</tr>
				<tr>
					<th><span>Total Price</span></th>
					<td><span id="prefix">৳</span><span></span></td>
				</tr>
			</table>
			<table class="inventory">
				<thead>
					<tr>
						<th><span>Movie Name</span></th>
						<th><span>Description</span></th>
						<th><span>Rate</span></th>
						<th><span>Quantity</span></th>
						<th><span>Price</span></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><span><?php echo $ticket['moviename'] ?><br>
								Genre: <?php echo $ticket['genre'] . '<br> IMDB Rating: ' . $ticket['movierating'] ?></span></td>
						<td><span><?php
									$i = 0;

									?>
								Seat No: <?php while ($row = mysqli_fetch_assoc($a)) {
												echo  $row["seatno"] . ',';
											} ?><br>
								Date: <?php echo $ticket['date'] ?><br>
								Slot: <?php echo $ticket['slot'] ?><br>
								Hall Name: <?php echo $ticket['hallname'] ?><br>
								Hall Address: <?php echo $ticket['location'] ?><br>
							</span></td>
						<td><span data-prefix>৳</span><span>350.00</span></td>
						<td><span><?php echo $ticket['seat_count'] ?></span></td>
						<td><span data-prefix>৳</span><span></span></td>
					</tr>
				</tbody>
			</table>
			<table class="balance">
				<tr>
					<th><span>Total</span></th>
					<td><span data-prefix>$</span><span>600.00</span></td>
				</tr>
				<tr>
					<th><span>Amount Paid</span></th>
					<td><span data-prefix>$</span><span>0.00</span></td>
				</tr>
				<tr>
					<th><span>Balance Due</span></th>
					<td><span data-prefix>$</span><span>600.00</span></td>
				</tr>
			</table>
		</article>
		<aside>
			<h1><span></span></h1>
			<div>
				<!-- <p>A finance charge of 1.5% will be made on unpaid balances after 30 days.</p> -->
			</div>
		</aside>
	</div>
</body>

</html>