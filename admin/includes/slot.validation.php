<?php
function validationSlotTable($movieid, $hallid, $date, $slot) {
    $errors = [];

    if (empty($movieid)) {
        $errors[] = 'Movie ID is required';
    }
    if (empty($hallid)) {
        $errors[] = 'Hall ID is required';
    }
    if (empty($date)) {
        $errors[] = 'Date is required';
    }
    if (empty($slot)) {
        $errors[] = 'Slot is required';
    }

    return $errors;
}