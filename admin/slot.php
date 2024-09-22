<?php
include './includes/admin.validation.php';
$page_name = 'Slot Panel';
include './includes/dbcon.php';
include './includes/header.php';

$errors = [];
$alert = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $deleteId = isset($_POST['deleteId']) ? trim($_POST['deleteId']) : null;
    $slotid = isset($_POST['slotid']) ? trim($_POST['slotid']) : null;
    $movieid = isset($_POST['movieid']) ? trim($_POST['movieid']) : null;
    $hallid = isset($_POST['hallid']) ? trim($_POST['hallid']) : null;
    $date = isset($_POST['date']) ? trim($_POST['date']) : null;
    $slot = isset($_POST['slot']) ? trim($_POST['slot']) : null;

    if ($deleteId) {
        // Delete slot
        $stmt = $conn->prepare("DELETE FROM slot WHERE slotid = ?");
        $stmt->bind_param("i", $deleteId);
        if ($stmt->execute()) {
            $alert = 'Record deleted successfully';
        } else {
            $alert = 'Database error';
        }
        $stmt->close();
    } else {
        $errors = validationSlotTable($movieid, $hallid, $date, $slot);
        if (empty($errors)) {
            if ($slotid) {
                // Edit existing slot
                $stmt = $conn->prepare("UPDATE slottable SET movieid = ?, hallid = ?, date = ?, slot = ? WHERE slotid = ?");
                $stmt->bind_param("iissi", $movieid, $hallid, $date, $slot, $slotid);
            } else {
                // Add new slot
                $stmt = $conn->prepare("INSERT INTO slottable (movieid, hallid, date, slot) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("iiss", $movieid, $hallid, $date, $slot);
            }

            if ($stmt->execute()) {
                $alert = 'Record saved successfully';
            } else {
                $alert = 'Database error';
            }
            $stmt->close();
        }
    }
}

// Fetch data from the database
$sql = "SELECT s.slotid, s.movieid, s.hallid, s.date, s.slot, h.hallname, m.moviename 
        FROM slottable s
        JOIN halltable h 
        JOIN movietable m
        WHERE s.movieid = m.movieid AND s.hallid = h.hallId";
$result = $conn->query($sql);

$conn->close();
?>
<section class="page-section">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-lg-8 col-xl-6 text-center">
                <h2 class="mt-0">Slots</h2>
                <hr class="divider" />
                <p class="text-muted mb-5">Here we can find all slot entry.</p>
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
                            hideCustomAlertAfterTimeout(3000);
                        });
                        </script>";
                } ?>

                <!-- Add Hall Button -->
                <div class="d-grid">
                    <button class="btn btn-success btn-xl mb-3" id="addSlotBtn">Add Slot</button>
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
                        <th>Date</th>
                        <th>Slot</th>
                        <th>Movie Name</th>
                        <th>Hall Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $count = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $count . "</td>";
                            echo "<td>" . $row["date"] . "</td>";
                            echo "<td>" . $row["slot"] . "</td>";
                            echo "<td>" . $row["moviename"] . "</td>";
                            echo "<td>" . $row["hallname"] . "</td>";
                            echo "<td> 
                            <button class='btn btn-primary btn-sm editSlotBtn'hallid='" . $row["slotid"] . "'slot='" . $row["slot"] . "'date='" . $row["date"] . "'movieid='" . $row["movieid"] . "'hallid='" . $row["hallid"] . "'>Edit</button>
                            <button class='btn btn-danger btn-sm deleteSlotBtn'hallid='" . $row["slotid"] . "'>Delete</button>
                            </td>";
                            echo "</tr>";
                            $count++;
                        }
                    } else {
                        echo "<tr><td colspan='5'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Add/Edit Slot Modal -->
<div id="addEditSlotModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Slot</h5>
            </div>
            <div class="modal-body">
                <form id="addEditSlotForm" method="post" action="save_slot.php">
                    <input type="hidden" id="slotid" name="slotid">
                    <div class="form-floating mb-3">
                        <input class="form-control" type="number" id="movieid" name="movieid" required>
                        <label for="movieid">Movie Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" type="number" id="hallid" name="hallid" required>
                        <label for="hallid">Hall Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" type="date" id="date" name="date" required>
                        <label for="date">Date</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-control" type="text" id="slot" name="slot" required>
                        <option value="" disabled selected>Select Slot</option>
                            <option value="Morning">Morning</option>
                            <option value="Afternoon">Afternoon</option>
                            <option value="Evening">Evening</option>
                            <option value="Night">Night</option>
                        </select>
                        <label for="slot">Slot</label>
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

<!-- Delete Slot Modal -->
<div id="deleteSlotModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Slot</h5>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this slot?</p>
                <form id="deleteSlotForm" method="post" action="delete_slot.php">
                    <input type="hidden" id="deleteSlotId" name="slotid">
                    <button type="submit">Delete</button>
                    <button type="button" class="close">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include './includes/footer.php'; ?>