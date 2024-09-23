<!-- Header -->
<?php
include './includes/admin.validation.php';
$page_name = 'Hall Panel';
include './includes/header.php';
include './includes/dbcon.php';
include './includes/hall.validation.php';

$errors = [];
$alert = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $deleteId = isset($_POST['deleteId']) ? trim($_POST['deleteId']) : null;
    $hallId = isset($_POST['hallId']) ? trim($_POST['hallId']) : null;
    $hallname = isset($_POST['hallname']) ? trim($_POST['hallname']) : null;
    $location = isset($_POST['location']) ? trim($_POST['location']) : null;
    $rating = isset($_POST['rating']) ? trim($_POST['rating']) : null;
    $type = isset($_POST['type']) ? trim($_POST['type']) : null;
    $capacity = isset($_POST['capacity']) ? trim($_POST['capacity']) : null;


    if ($deleteId) {
        // Delete hall
        echo $deleteId;
        $stmt = $conn->prepare("DELETE FROM halltable WHERE hallId = ?");
        $stmt->bind_param("i", $deleteId);
        if ($stmt->execute()) {
            $alert = 'Record delete successfully';
        } else {
            $alert = 'Database error';
        }
        $stmt->close();
    } else {
        $errors = validationHallTable($hallname, $location, $rating, $type, $capacity);
        if (empty($errors)) {
            if ($hallId) {
                // Edit existing hall
                $stmt = $conn->prepare("UPDATE halltable SET hallname = ?, location = ?, rating = ?, type = ?, capacity = ? WHERE hallId = ?");
                $stmt->bind_param("ssssii", $hallname, $location, $rating, $type, $capacity, $hallId);
            } else {
                // Add new hall
                $stmt = $conn->prepare("INSERT INTO halltable (hallname, location, rating, type, capacity) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssssi", $hallname, $location, $rating, $type, $capacity);
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
$conn->close();
?>


<!-- Hall Modal Form -->
<div id="addHallModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
            </div>
            <div class="modal-body">
                <form id="addEditHallForm" action="hall.php" method="post">
                    <!-- hallId -->
                    <input type="hidden" name="hallId" id="hallId">
                    <!-- hallname -->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="hallname" name="hallname" type="text"
                            placeholder="Enter your hall name..." />
                        <label for="hallname">Hall Name</label>
                    </div>
                    <!-- location -->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="location" name="location" type="text"
                            placeholder="Enter the location..." />
                        <label for="location">Location</label>
                    </div>
                    <!-- rating -->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="rating" name="rating" type="number"
                            placeholder="Enter the rating..." />
                        <label for="rating">Rating</label>
                    </div>
                    <!-- type -->
                    <div class="form-floating mb-3">
                        <select class="form-control" id="type" name="type">
                            <option value="" disabled selected>Hall Type</option>
                            <option value="3D">3D</option>
                            <option value="2D">2D</option>
                        </select>
                        <label for="type">Type</label>
                    </div>
                    <!-- capacity -->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="capacity" name="capacity" type="number"
                            placeholder="Enter the capacity..." />
                        <label for="capacity">Capacity</label>
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

<?php
include './includes/dbcon.php';

// Fetch data from the database
$sql = "SELECT hallId, hallname, location, rating, type, capacity FROM halltable";
$result = $conn->query($sql);
?>
<section class="page-section">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-lg-8 col-xl-6 text-center">
                <h2 class="mt-0">Halls</h2>
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
                            hideCustomAlertAfterTimeout(3000);
                        });
                        </script>";
                } ?>

                <!-- Add Hall Button -->
                <div class="d-grid">
                    <button class="btn btn-success btn-xl mb-3" id="AddHallBtn">Add Hall</button>
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
                        <th>Hall Name</th>
                        <th>Location</th>
                        <th>Rating</th>
                        <th>Type</th>
                        <th>Capacity</th>
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
                            echo "<td>" . $row["hallname"] . "</td>";
                            echo "<td>" . $row["location"] . "</td>";
                            echo "<td>" . $row["rating"] . "</td>";
                            echo "<td>" . $row["type"] . "</td>";
                            echo "<td>" . $row["capacity"] . "</td>";
                            echo "<td> 
                            <button class='btn btn-primary btn-sm editHallBtn'hallid='" . $row["hallId"] . "'hallname='" . $row["hallname"] . "'location='" . $row["location"] . "'rating='" . $row["rating"] . "'type='" . $row["type"] . "'capacity='" . $row["capacity"] . "'>Edit</button>
                            <button class='btn btn-danger btn-sm deleteHallBtn'hallid='" . $row["hallId"] . "'>Delete</button>
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



<!-- Hall delete form modal -->
<div id="deleteHallModal" class="modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Caution!</h5>
            </div>
            <div class="modal-body">
                <form id="deleteForm" action="hall.php" method="post">
                    <input type="hidden" name="deleteId" id="deleteId">
                    <div class="form-floating mb-3">
                        Do you want to delete this hall?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="submit">Delete</button>
                        <button type="button" class="btn btn-secondary close">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>