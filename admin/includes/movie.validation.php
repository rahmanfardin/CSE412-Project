<?php
function validationMovieTable($moviename, $releasedate, $genre, $movierating, $rating, $poster)
{
    $errors = [];

    // Validate moviename
    if (empty($moviename)) {
        $errors[] = "Movie name is required.";
    }

    // Validate releasedate
    if (empty($releasedate)) {
        $errors[] = "Release date is required.";
    }

    // Validate genre
    if (empty($genre)) {
        $errors[] = "Genre is required.";
    }

    // Validate movierating
    if (empty($movierating)) {
        $errors[] = "IMDb rating is required.";
    } elseif (!is_numeric($movierating) || $movierating < 0 || $movierating > 10) {
        $errors[] = "IMDb rating must be a number between 0 and 10.";
    }

    // Validate rating
    if (empty($rating)) {
        $errors[] = "Rating is required.";
    }

    // Validate poster
    if (empty($poster)) {
        $errors[] = "Poster is required.";
    } else {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($poster);

        // Check if the uploads directory exists, if not, create it
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        if (!move_uploaded_file($_FILES['poster']['tmp_name'], $target_file)) {
            $errors[] = "Sorry, there was an error uploading your file.";
        }
    }
    return $errors;
}
