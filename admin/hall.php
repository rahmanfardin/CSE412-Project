<!-- Header -->
<!-- Header -->
<?php include './includes/header.php';

include './includes/dbcon.php';
include './includes/hall.validation.php';
$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $hallname = isset($_POST['hallname']) ? trim($_POST['hallname']) : null;
    $location = isset($_POST['location']) ? trim($_POST['location']) : null;
    $rating = isset($_POST['rating']) ? trim($_POST['rating']) : null;
    $type = isset($_POST['type']) ? trim($_POST['type']) : null;

    $errors = validationHallTable($hallname, $location, $rating, $type);
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO halltable (hallname, location, rating, type) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $hallname, $location, $rating, $type);

        if ($stmt->execute()) {
            echo "<script>alert('New record created successfully');</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!-- Hall Form-->
<section class="page-section" id="signup">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-lg-8 col-xl-6 text-center">
                <h2 class="mt-0">Add Hall</h2>
                <hr class="divider" />
                <p class="text-muted mb-5">This form is to create a new hall entry.</p>
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
                    }, " . (3000 + $index * 1000) . ");
                  </script>";
                    }
                } ?>
                <form action="hall.php" method="post">
                    <!-- hallname-->
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
                            <option value="" disabled selected>Hall Type
                            <option>
                            <option value="3D">3D</option>
                            <option value="2D">2D</option>
                        </select>
                        <label for="type">Type</label>
                    </div>
                    <div class="d-grid"><button class="btn btn-primary btn-xl" id="submitButton"
                            type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php
include './includes/dbcon.php';

// Fetch data from the database
$sql = "SELECT hallId, hallname, location, rating, type FROM halltable";
$result = $conn->query($sql);
?>
<section class="page-section" id="signup">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-lg-8 col-xl-6 text-center">
                <h2 class="mt-0">Add Hall</h2>
                <hr class="divider" />
                <p class="text-muted mb-5">This form is to create a new hall entry.</p>
            </div>
        </div>
        <h2>Hall Table</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Hall Name</th>
                        <th>Location</th>
                        <th>Rating</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["hallname"] . "</td>";
                            echo "<td>" . $row["location"] . "</td>";
                            echo "<td>" . $row["rating"] . "</td>";
                            echo "<td>" . $row["type"] . "</td>";
                            echo "<td>
                                        <a href='# calss='editBtn' data-id'=" . $row["hallId"] . "'>Edit</a> |
                                        <a href='delete_hall.php?id=" . $row["hallId"] . "' onclick='return confirm(\"Are you sure you want to delete this item?\");'>Delete</a>
                                      </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
</section>

<div id="editHallModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <section class="page-section" id="signup">
                <div class="container px-4 px-lg-5">
                    <div class="row gx-4 gx-lg-5 justify-content-center">
                        <div class="col-lg-8 col-xl-6 text-center">
                            <h2 class="mt-0">Edit Hall</h2>
                            <hr class="divider" />
                            <p class="text-muted mb-5">This form is to edit hall entry.</p>
                        </div>
                    </div>
                    <div class="row gx-4 gx-lg-5 justify-content-center mb-5">
                        <div class="col-lg-6">
                            <form id="editForm" action="edit_hall.php" method="post">
                                <input type="hidden" name="hallId" id="hallId">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="hallname" name="hallname" type="text" required />
                                    <label for="hallname">Hall Name</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="location" name="location" type="text" required />
                                    <label for="location">Location</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="rating" name="rating" type="number" required />
                                    <label for="rating">Rating</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <select class="form-control" id="type" name="type" required>
                                        <option value="3D">3D</option>
                                        <option value="2D">2D</option>
                                    </select>
                                    <label for="type">Type</label>
                                </div>
                                <button type="submit">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("editHallModal");

        // Get the button that opens the modal
        var editButtons = document.getElementsByClassName("editBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        for (var i = 0; i < editButtons.length; i++) {
            editButtons[i].onclick = function() {
                var hallId = this.getAttribute("data-id");
                // Fetch data for the selected hall
                fetch('get_hall.php?id=' + hallId)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById("hallId").value = data.hallId;
                        document.getElementById("hallname").value = data.hallname;
                        document.getElementById("location").value = data.location;
                        document.getElementById("rating").value = data.rating;
                        document.getElementById("type").value = data.type;
                        modal.style.display = "block";
                    });
            }
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

<?php include 'includes/footer.php'; ?>