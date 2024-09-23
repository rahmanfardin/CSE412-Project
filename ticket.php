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

// Include your database connection file
include 'includes\dbcon.php';

// Get the movie ID from the query parameter
$movieid = isset($_GET['movieid']) ? intval($_GET['movieid']) : 0;
$moviename = isset($_GET['moviename']) ? $_GET['moviename'] : null;

if ($movieid > 0) {
    // Fetch movie details from the database
    $sql = "SELECT * FROM movietable WHERE movieid = ?";
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
        echo "<p>Movie not found</p>";
        exit;
    }
} else {
    echo "<p>Invalid movie ID</p>";
    exit;
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
                <p class="text-muted mb-5"></p>
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
        <center id="movieSearch">
            <div class="col-md-8">
                <form action="ticket.php" method="get">
                    <div class="form-floating mb-3">
                        <input class="form-control" id="moviename" name="moviename" type="text"
                            data-sb-validations="required" />
                        <span class="password-toggle" type="submit">
                            <i class="bi bi-search"></i>
                        </span>
                        <label for="movieid">Movie Name</label>
                    </div>
                </form>
            </div>
        </center>

        <!-- Movie details -->
        <div class="card mb-3" style="max-width: 540px;">
            <div class="container mt-3 mb-3 mx-2 my-2">
                <div class="row">
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
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'seat.php'; ?>

<script src="js/seat.js"></script>
<?php include 'includes/footer.php'; ?>