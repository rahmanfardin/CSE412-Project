<?php
function validationMovieTable($movieid, $moviename, $releasedate, $genre, $movierating, $rating, $poster) {
    $errors = [];

    // Validate moviename
    if (empty($moviename)) {
        $errors[] = "Movie name is required.";
    } else {
        $moviename = htmlspecialchars($moviename, ENT_QUOTES, 'UTF-8');
    }

    // Validate releasedate
    if (empty($releasedate)) {
        $errors[] = "Release date is required.";
    }

    // Validate genre
    if (empty($genre)) {
        $errors[] = "Genre is required.";
    } else {
        $genre = htmlspecialchars($genre, ENT_QUOTES, 'UTF-8');
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
    } else {
        $rating = htmlspecialchars($rating, ENT_QUOTES, 'UTF-8');
    }

    // Validate poster
    if (empty($poster) && empty($movieid)) {
        $errors[] = "Poster is required.";
    } else if (!empty($poster) && !empty($movieid)) {
        $target_dir = "uploads/posters/";
        $target_file = $target_dir . basename($poster);
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the uploads/posters directory exists, if not, create it
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Allow certain file formats
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($file_type, $allowed_types)) {
            $errors[] = "Only JPG, JPEG, PNG & GIF files are allowed.";
        }

        // Check for file upload errors
        if ($_FILES['poster']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = "Error uploading file: " . $_FILES['poster']['error'];
        }

        if (empty($errors) && !move_uploaded_file($_FILES['poster']['tmp_name'], $target_file)) {
            $errors[] = "Sorry, there was an error uploading your file.";
        }
    }

    return $errors;
}
?>