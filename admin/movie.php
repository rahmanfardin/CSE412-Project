<!-- Header -->
<?php include './includes/header.php';

include './includes/dbcon.php';
include './includes/movie.validation.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $moviename = isset($_POST['moviename']) ? trim($_POST['moviename']) : null;
    $releasedate = isset($_POST['releasedate']) ? trim($_POST['releasedate']) : null;
    $genre = isset($_POST['genre']) ? trim($_POST['genre']) : null;
    $movierating = isset($_POST['movierating']) ? trim($_POST['movierating']) : null;
    $rating = isset($_POST['rating']) ? trim($_POST['rating']) : null;
    $poster = isset($_FILES['poster']['name']) ? $_FILES['poster']['name'] : null;

    $errors = validationMovieTable($moviename, $releasedate, $genre, $movierating, $rating, $poster);

    // If there are no errors, proceed with the database insertion
    if (empty($errors)) {
        $target_dir = "uploads/posters/";
        $target_file = $target_dir . basename($poster);

        $stmt = $conn->prepare("INSERT INTO movietable (moviename, releasedate, genre, movierating, rating, poster) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiss", $moviename, $releasedate, $genre, $movierating, $rating, $target_file);

        if ($stmt->execute()) {
            echo "New record created successfully";
            header("location: index.php");
        } else {
            echo "Error: " . $stmt->error;
            header("location: error.php");
        }

        $stmt->close();
    } else {
    }
}

?>

<!-- Masthead-->
<section class="page-section" id="signup">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-lg-8 col-xl-6 text-center">
                <h2 class="mt-0">New Movie</h2>
                <hr class="divider" />
                <p class="text-muted mb-5">This form is to create a new movie entry.</p>
            </div>
        </div>
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
                <form action="movie.php" method="post" enctype="multipart/form-data">


                    <!-- moviename-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="moviename" name="moviename" type="text"
                            placeholder="Enter your movie name..." />
                        <label for="name">Movie Name</label>
                    </div>
                    <!-- releasedate -->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="releasedate" name="releasedate" type="date" min="1900-01-01" max="2099-12-31"
                            placeholder="" />
                        <label for="name">Release Date</label>
                    </div>

                    <!-- genre-->
                    <div class="form-floating mb-3">
                        <select class="form-control" id="genre" name="genre">
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
                        <select class="form-control" id="rating" name="rating">
                            <option value="">Select Rating</option>
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
                        <input class="form-control" id="movierating" name="movierating" type="number" step="0.1" min="0" max="10"
                            placeholder="Enter IMDb rating..." />
                        <label for="imdbRating">IMDb Rating</label>
                    </div>
                    <!-- poster -->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="poster" name="poster" type="file" accept="image/*" required />
                        <label for="poster">Poster</label>
                    </div>


                    <div class="d-grid"><button class="btn btn-primary btn-xl" id="submitButton"
                            type="submit">Submit</button></div>
                </form>
            </div>

        </div>


    </div>
</section>

<?php include 'includes/footer.php'; ?>