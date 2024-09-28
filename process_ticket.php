<?php
header('Content-Type: application/json');

// Include your database connection file
include 'includes/dbcon.php';

// Get the JSON data from the request
$data = json_decode(file_get_contents("php://input"), true);

$slotid = isset($data['slotid']) ? intval($data['slotid']) : 0;
$userid = isset($data['userid']) ? intval($data['userid']) : 0;
$seats = isset($data['seats']) ? $data['seats'] : [];

$response = ['success' => false];

if ($slotid > 0 && $userid > 0 && !empty($seats)) {
    // Start a transaction
    $conn->begin_transaction();

    try {
        // Insert into tickettable
        $stmt = $conn->prepare("INSERT INTO ticket (userid, slotid) VALUES (?, ?)");
        $stmt->bind_param("ii", $userid, $slotid);
        $stmt->execute();
        $ticketid = $stmt->insert_id;

        // Insert into seattable
        $stmt = $conn->prepare("INSERT INTO seattable (ticketid, seatno) VALUES (?, ?)");
        foreach ($seats as $seatno) {
            $stmt->bind_param("ii", $ticketid, $seatno);
            $stmt->execute();
        }

        // Commit the transaction
        $conn->commit();
        $response['success'] = true;
    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();
        error_log($e->getMessage());
    } finally {
        $stmt->close();
        $conn->close();
    }
}

echo json_encode($response);
?>