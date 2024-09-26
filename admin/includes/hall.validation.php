<?php

function validationHallTable($hallname, $location, $rating, $type) {
    $errors = [];

    // Validate hallname
    if (empty($hallname)) {
        $errors[] = "Hall name is required.";
    } elseif (strlen($hallname) > 100) {
        $errors[] = "Hall name must be less than 100 characters.";
    }

    // Validate location
    if (empty($location)) {
        $errors[] = "Location is required.";
    } elseif (strlen($location) > 1000) {
        $errors[] = "Location must be less than 1000 characters.";
    }

    // Validate rating
    if (empty($rating)) {
        $errors[] = "Rating is required.";
    } elseif (!is_numeric($rating) || $rating < 1 || $rating > 5) {
        $errors[] = "Rating must be a number between 1 and 5.";
    }

    // Validate type
    if (empty($type)) {
        $errors[] = "Type is required.";
    } elseif (strlen($type) > 100) {
        $errors[] = "Type must be less than 100 characters.";
    }

    return $errors;
}

