<!-- Header -->
<?php include 'includes/header.php'; ?>

<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $loggedin = true;
} else {
    $loggedin = false;
}

$alert = null;
$display = null;

// Include your database connection file
include 'includes\dbcon.php';

// Get the movie ID from the query parameter
$movieid = isset($_GET['movieid']) ? intval($_GET['movieid']) : 0;

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
            <form action="ticket.php" method="get">
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
                            <div class="form-floating mb-3">
                                <select class="form-control" id="hallid" name="hallid" required>
                                    <option value="" disabled selected>Select Hall</option>
                                    <?php
                                    include 'includes\dbcon.php';
                                    $sql = "SELECT s.slotid, s.movieid, s.hallid, s.date, s.slot, h.hallname, m.moviename 
                                    FROM slottable s
                                    JOIN halltable h 
                                    JOIN movietable m
                                    WHERE s.movieid = m.movieid AND s.hallid = h.hallId AND s.movieid = $movieid";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['hallid'] . "'>" . $row['hallname'] . "</option>";
                                        }
                                    }
                                    $conn->close();
                                    ?>
                                </select>
                                <label for="hallid">Choose Hall</label>
                            </div>
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
            <div class="screen shadow p-3 bg-body rounded">Screen</div>
            <?php
            // Generate the seat layout
            $seatNumber = 1;
            for ($i = 0; $i < 8; $i++) {
                echo '<div class="row justify-content-center">';
                for ($j = 0; $j < 8; $j++) {
                    if ($seatNumber <= 48) {
                        // Randomly mark some seats as occupied for demonstration
                        $class = (rand(0, 4) === 0) ? 'seat occupied' : 'seat';
                        echo "<div class='$class' seatNumber='$seatNumber'></div>";
                        $seatNumber++;
                    }
                }
                echo '</div>';
            }
            ?>

            <p class="text">
                You have selected <span id="count">0</span> movies for price of $<span id="total">0</span>
            </p>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const movieSelect = document.getElementById("movieid");
        movieSelect.addEventListener("change", function () {
            this.form.submit();
        });
    });
</script>
<script src="seat.js"></script>
<?php include 'includes/footer.php'; ?>