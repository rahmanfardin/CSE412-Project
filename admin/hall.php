<!-- Header -->
<!-- Header -->
<?php include './includes/header.php';

include './includes/dbcon.php';
include './includes/hall.validation.php';
$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $hallname = $_POST['hallname'];
    $location = $_POST['location'];
    $rating = $_POST['rating'];
    $type = $_POST['type'];

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

<!-- Masthead-->
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
                        <input class="form-control" id="type" name="type" type="text" placeholder="Enter the type..." />
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

<?php include 'includes/footer.php'; ?>