<!-- Header -->
<?php
include 'includes/header.php';


if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

$alert = null;
$display = null;

// Include your database connection file
include 'includes\dbcon.php';

// Get the the query parameter
$movieid = isset($_GET['movieid']) ? intval($_GET['movieid']) : 0;
$hallid = isset($_POST['hallid']) ? intval($_POST['hallid']) : 0;
$slotid = isset($_POST['slotid']) ? intval($_POST['slotid']) : 0;
$userid = $_SESSION['userid'];

if ($movieid > 0) {
    // Fetch movie details from the database
    $sql = "SELECT m.moviename, m.releasedate, m.genre, m.rating, m.movierating, m.poster
    FROM movietable m JOIN slottable s
    WHERE m.movieid = s.movieid AND m.movieid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $movieid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Display movie details
        $moviename = htmlspecialchars($row["moviename"]);
        $releasedate = htmlspecialchars($row["releasedate"]);
        $genre = htmlspecialchars($row["genre"]);
        $rating = htmlspecialchars($row["rating"]);
        $movierating = htmlspecialchars($row["movierating"]);
        $poster = htmlspecialchars($row["poster"]);
    } else {
        header("Location: noticket.php");
    }
} else {
    $display = "style='display: none;'";
}

// Close the database connection
$conn->close();
?>

<!-- Buy Ticket -->
<section class="page-section" id="ticket">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-lg-8 col-xl-6 text-center">
                <h2 class="mt-0">Buy Ticket</h2>
                <hr class="divider" />
                <p class="text-muted mb-5">Select available movie</p>
            </div>
        </div>
        <!-- Custom Alert -->
        <?php if ($alert) {
            echo "<div id='customAlert' class='alert alert-dismissible alert-success' role='alert'>
                    <span id='customAlertMessage'></span>
                    <button type='button' class='btn-close' aria-label='Close'></button>
                </div>";
            echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showCustomAlert('$alert'); 
                            hideCustomAlertAfterTimeout(3000);
                        });
                        </script>";
        } ?>
        <!-- Select Movie -->
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <form action="" method="get">
                <div class="form-floating mb-3">
                    <select class="form-control" name="movieid" id="movieid" required>
                        <option value="" disabled selected>Select Movie</option>
                        <?php include 'includes/dbcon.php';
                        $sql = "SELECT s.movieid, m.moviename
                            FROM movietable m JOIN slottable s
                            WHERE m.movieid = s.movieid GROUP BY m.movieid";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['movieid'] . "'>" . $row['moviename'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                    <label for="movieid">Movie Name</label>
                </div>
            </form>
        </div>

        <!-- Movie details -->
        <div class="card mb-3" <?php echo $display ?>;>
            <div class="container mt-3 mb-3 mx-2 my-2">
                <div class="row" style=<?php $display; ?>>
                    <div class="col-md-4">
                        <img src="admin/uploads/posters/<?php echo $poster; ?>" class="img-fluid rounded-start"
                            alt="<?php echo $moviename; ?>">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $moviename; ?></h5>
                            <p class="card-text">Release Date: <?php echo $releasedate; ?></p>
                            <p class="card-text">Genre: <?php echo $genre; ?></p>
                            <p class="card-text">Rating: <?php echo $rating; ?></p>
                            <p class="card-text">Movie Rating: <?php echo $movierating; ?></p>
                            <p class="card-text"><b><i>Select a hall to view available seats</i></b>
                            <form method="post">
                                <div class="form-floating mb-3">
                                    <select style="width: 42%" class="form-control" id="hallid" name="hallid" required>
                                        <option value="" disabled selected>Select Hall</option>
                                        <?php
                                        include 'includes\dbcon.php';
                                        $sql = "SELECT s.hallid, h.hallname, s.slotid 
                                        FROM slottable s JOIN halltable h JOIN movietable m
                                        WHERE s.movieid = m.movieid AND s.hallid = h.hallid AND s.movieid = $movieid";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='" . $row['hallid'] . "' slotid='" . $row['slotid'] . "'>" . $row['hallname'] . "</option>";
                                            }
                                        }
                                        $conn->close();
                                        ?>
                                    </select>
                                    <label for="hallid">Choose Hall</label>
                                    <input type="hidden" name="slotid" id="slotid">
                                </div>
                            </form>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seat Layout -->
        <div id="seat" <?php echo $display ?>;>
            <ul class="showcase">
                <li>
                    <div class="seat"></div>
                    <small>Available</small>
                </li>
                <li>
                    <div class="seat selected"></div>
                    <small>Selected</small>
                </li>
                <li>
                    <div class="seat occupied"></div>
                    <small>Occupied</small>
                </li>
            </ul>
            <div class="screen shadow p-3 bg-body rounded">Screen <?php echo $hallid ?></div>
            <?php
            include 'includes\dbcon.php';
            $sql = "SELECT se.seatno
            FROM slottable s JOIN ticket t JOIN seattable se
            WHERE s.movieid = $movieid AND s.hallid = $hallid AND s.slotid = t.slotid";
            $result = $conn->query($sql);
            $occupiedSeats = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($occupiedSeats, $row['seatno']);
                }
            }
            $conn->close();
            // Generate the seat layout
            $seatNumber = 1;
            for ($i = 0; $i < 8; $i++) {
                echo '<div class="row justify-content-center">';
                for ($j = 0; $j < 8; $j++) {
                    if ($seatNumber <= 48) {
                        $class = (in_array($seatNumber, $occupiedSeats)) ? 'seat occupied' : 'seat';
                        echo "<div class='$class' seatNumber='$seatNumber'></div>";
                        $seatNumber++;
                    }
                }
                echo '</div>';
            }
            ?>
            <button class="btn btn-primary" id="checkout">Checkout</button>
        </div>
    </div>
</section>

<script src="js/seat.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const checkoutButton = document.getElementById("checkout");

        checkoutButton.addEventListener("click", function () {
            const selectedSeats = Array.from(document.querySelectorAll(".row .seat.selected")).map(seat => seat.getAttribute('seatNumber'));
            const slotid = <?php echo isset($slotid) ? $slotid : 'null'; ?>;
            const userid = <?php echo isset($userid) ? $userid : 'null'; ?>;

            if (selectedSeats.length === 0) {
                alert("Please select at least one seat.");
                return;
            }

            const data = {
                slotid: slotid,
                userid: userid,
                seats: selectedSeats
            };
            console.log(data);

            fetch("process_ticket.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        $alert = "Tickets booked successfully!";
                        // downloadTicket(data.ticketid);
                        window.location.href = "printTicket.php?ticketid=" + data.ticketid;
                    } else {
                        alert("Failed to book tickets. Please try again.");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("An error occurred. Please try again.");
                });
        });
    });

    function downloadTicket(ticketid) {
        var link = document.createElement('a');
        link.href = "printTicket.php?ticketid=" + data.ticketid;
        link.download = 'ticket.pdf'; // You can set the desired file name here
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
<?php include 'includes/footer.php'; ?>