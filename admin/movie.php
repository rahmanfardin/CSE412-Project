<!-- Header -->
<?php
include './includes/admin.validation.php';
$page_name = 'Movie Panel';
include './includes/header.php';
include './includes/dbcon.php';
include './includes/movie.validation.php';

$errors = [];
$alert = null;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $deleteId = isset($_POST['deleteId']) ? trim($_POST['deleteId']) : null;
    $movieid = isset($_POST['movieid']) ? trim($_POST['movieid']) : null;
    $moviename = isset($_POST['moviename']) ? trim($_POST['moviename']) : null;
    $releasedate = isset($_POST['releasedate']) ? trim($_POST['releasedate']) : null;
    $genre = isset($_POST['genre']) ? trim($_POST['genre']) : null;
    $movierating = isset($_POST['movierating']) ? trim($_POST['movierating']) : null;
    $rating = isset($_POST['rating']) ? trim($_POST['rating']) : null;
    $poster = isset($_FILES['poster']['name']) ? $_FILES['poster']['name'] : null;

    // Delete Movie
    if (isset($_POST['deleteId'])) {
        $movieid = isset($_POST['deleteId']) ? trim($_POST['deleteId']) : null;

        // Fetch the poster file path
        $stmt = $conn->prepare("SELECT poster FROM movietable WHERE movieid = ?");
        $stmt->bind_param("i", $movieid);
        $stmt->execute();
        $stmt->bind_result($posterPath);
        $stmt->fetch();
        $stmt->close();

        // Delete the poster file from the server
        if ($posterPath && file_exists($posterPath)) {
            unlink($posterPath);
        }

        // Delete the movie record from the database
        $stmt = $conn->prepare("DELETE FROM movietable WHERE movieid = ?");
        $stmt->bind_param("i", $movieid);

        if ($stmt->execute()) {
            $alert = "Movie and associated poster deleted successfully";
        } else {
            $errors[] = "Failed to delete movie";
        }

        $stmt->close();
    } else {

        $errors = validationMovieTable($movieid, $moviename, $releasedate, $genre, $movierating, $movierating, $poster);
        // If there are no errors, proceed with the database insertion
        if ($movieid) {
            $stmt = $conn->prepare("SELECT poster FROM movietable WHERE movieid = ?");
            $stmt->bind_param("i", $movieid);
            $stmt->execute();
            $stmt->bind_result($currentPoster);
            $stmt->fetch();
            $stmt->close();

            if ($poster) {
                if ($currentPoster && file_exists($currentPoster)) {
                    unlink($currentPoster);
                }
            } else {
                $poster = $currentPoster;
            }

            $stmt = $conn->prepare("UPDATE movietable SET moviename = ?, releasedate = ?, genre = ?, rating = ?, movierating = ?, poster = ? WHERE movieid = ?");
            $stmt->bind_param("ssssisi", $moviename, $releasedate, $genre, $rating, $movierating, $poster, $movieid);

            if ($stmt->execute()) {
                $alert = "Movie updated successfully";
            } else {
                $errors[] = "Failed to update movie";
            }

            $stmt->close();
        } else if (empty($errors)) {
            $target_dir = "uploads/posters/";
            $target_file = $target_dir . basename($poster);

            $stmt = $conn->prepare("INSERT INTO movietable (moviename, releasedate, genre, rating, movierating, poster) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssis", $moviename, $releasedate, $genre, $rating, $movierating, $target_file);

            if ($stmt->execute()) {

            } else {
                $errors[] = "Failed to insert data into the database";
            }

            $stmt->close();
        }
    }
}
?>

<?php
include './includes/dbcon.php';

// Fetch data from the database
$sql = "SELECT movieid, moviename, releasedate, genre, rating, movierating, poster FROM movietable";
$result = $conn->query($sql);
?>
<section class="page-section">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-lg-8 col-xl-6 text-center">
                <h2 class="mt-0">Movies</h2>
                <hr class="divider" />
                <p class="text-muted mb-5">Here we can find all hall entry.</p>
            </div>
            <div class="container px-4 px-lg-5">
                <!-- Custom Alert -->
                <?php if ($alert) {
                    echo "<div id='customAlert' class='alert alert-dismissible alert-success' role='alert'>
                    <span id='customAlertMessage'></span>
                    <button type='button' class='btn-close' aria-label='Close'></button>
                </div>";
                    echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            showCustomAlert('$alert'); 
                            hideCustomAlertAfterTimeout(2000);
                        });
                        </script>";
                } ?>

                <!-- Add Movie Button -->
                <div class="d-grid">
                    <button class="btn btn-success btn-xl mb-3" id="addMovieBtn">Add Movie</button>
                </div>
                <!-- Error Messages -->
                <div class="row gx-4 gx-lg-5 justify-content-center mb-5">
                    <div class="col-lg-6">
                        <?php
                        if (!empty($errors)) {
                            foreach ($errors as $index => $error) {
                                $alertId = "alert-$index";
                                echo "<div id='$alertId' class='alert alert-danger alert-dismissible fade show' role='alert'>
                    $error
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
                                echo "<script>
                    setTimeout(function() {
                        var alertElement = document.getElementById('$alertId');
                        if (alertElement) {
                            alertElement.classList.remove('show');
                            alertElement.classList.add('fade');
                            setTimeout(function() {
                                alertElement.remove();
                            }, 150);
                        }
                    }, " . (2000 + $index * 1000) . ");
                  </script>";
                            }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Movie Name</th>
                        <th>releasedate</th>
                        <th>Genre</th>
                        <th>Rating</th>
                        <th>Movie Rating</th>
                        <th>Poster</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $count = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["movieid"] . "</td>";
                            echo "<td>" . $row["moviename"] . "</td>";
                            echo "<td>" . $row["releasedate"] . "</td>";
                            echo "<td>" . $row["genre"] . "</td>";
                            echo "<td>" . $row["rating"] . "</td>";
                            echo "<td>" . $row["movierating"] . "</td>";
                            echo "<td><img src='" . $row["poster"] . "' alt='Poster' style='width: 50px; height: auto;'></td>";
                            echo "<td> 
                            <button class='btn btn-primary btn-sm editMovieBtn' movieid='" . $row["movieid"] . "' moviename='" . $row["moviename"] . "' releasedate='" . $row["releasedate"] . "' genre='" . $row["genre"] . "' movierating='" . $row["movierating"] . "' rating='" . $row["rating"] . "' poster='" . $row["poster"] . "'>Edit</button>
                            <button class='btn btn-danger btn-sm deleteMovieBtn' movieid='" . $row["movieid"] . "'>Delete</button>
                            </td>";
                            echo "</tr>";
                            $count++;
                        }
                    } else {
                        echo "<tr><td colspan='7'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>


<!-- Add Movie Modal-->
<div id="addEditMovieModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
            </div>
            <div class="modal-body">
                <form id="addEditMovieForm" action="movie.php" method="post" enctype="multipart/form-data">
                    <!-- movieid -->
                    <input class="form-control" id="movieid" name="movieid" type="hidden" />
                    <!-- moviename -->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="moviename" name="moviename" type="text"
                            placeholder="Enter your movie name..." required />
                        <label for="moviename">Movie Name</label>
                    </div>
                    <!-- releasedate -->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="releasedate" name="releasedate" type="date" min="1900" max="2099"
                            placeholder="Enter releasedate..." required>
                        <label for="releasedate">Release Date</label>
                    </div>
                    <!-- genre -->
                    <div class="form-floating mb-3">
                        <select class="form-control" id="genre" name="genre" required>
                            <option value="" disabled selected>Select Genre</option>
                            <option value="action">Action</option>
                            <option value="adventure">Adventure</option>
                            <option value="animation">Animation</option>
                            <option value="comedy">Comedy</option>
                            <option value="crime">Crime</option>
                            <option value="documentary">Documentary</option>
                            <option value="drama">Drama</option>
                            <option value="fantasy">Fantasy</option>
                            <option value="horror">Horror</option>
                            <option value="musical">Musical</option>
                            <option value="mystery">Mystery</option>
                            <option value="romance">Romance</option>
                            <option value="sci-fi">Science Fiction</option>
                            <option value="thriller">Thriller</option>
                            <option value="war">War</option>
                            <option value="western">Western</option>
                        </select>
                        <label for="genre">Genre</label>
                    </div>
                    <!-- rating -->
                    <div class="form-floating mb-3">
                        <select class="form-control" id="rating" name="rating" required>
                            <option value="" disabled selected>Select Rating</option>
                            <option value="G">G - General Audience</option>
                            <option value="PG">PG - Parental Guidance</option>
                            <option value="PG-13">PG-13 - Parents Strongly Cautioned</option>
                            <option value="R">R - Restricted</option>
                            <option value="NC-17">NC-17 - Adults Only</option>
                        </select>
                        <label for="rating">Age Rating</label>
                    </div>
                    <!-- IMDb rating -->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="movierating" name="movierating" type="number" step="0.1" min="0"
                            max="10" placeholder="Enter IMDb rating..." required />
                        <label for="movierating">IMDb Rating</label>
                    </div>
                    <!-- poster -->
                    <div class="mb-3">
                        <label for="poster" id="posterLabel"></label>
                        <img id="currentPoster" src="" alt="Current Poster"
                            style="width: 100px; height: auto; display: block; margin-bottom: 10px;">
                        <input class="form-control" id="poster" name="poster" type="file" accept="image/*">
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary btn-xl" id="submitButton" type="submit"></button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger close">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Movie Modal -->
<div id="deleteMovieModal" class="modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Movie</h5>
            </div>
            <div class="modal-body">
                <form action="movie.php" method="post">
                    <p>Are you sure you want to delete this movie?</p>
                    <input class="form-control" id="movieDeleteId" name="deleteId" type="hidden" />
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger" id="deleteButton">Delete</button>
                        <button type="button" class="btn btn-secondary close">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>