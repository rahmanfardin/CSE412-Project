<!-- Header -->
<?php
include './includes/admin.validation.php';
$page_name = 'Feedback Panel';
include './includes/header.php';
include './includes/dbcon.php';
$alert = '';

// Handle delete request


// Fetch feedback data
$query = "SELECT * FROM feedback";
$result = mysqli_query($conn, $query);
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        deleteFeedback($id);
    }
}
function deleteFeedback($id) {
    include './includes/dbcon.php';
    $delete_query = "DELETE FROM feedback WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $alert = 'Feedback deleted successfully.';
        header('Location: ./feedback.php');
    } else {
        $alert = 'Error deleting feedback.';
    }
    $stmt->close();
}
?>
<style>
    html,
    body {
        height: 100%;
        margin: 0;
    }

    .content {
        min-height: 100%;
        display: flex;
        flex-direction: column;
    }

    .main-content {
        flex: 1;
    }

    .fixed-footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        background-color: #f8f9fa;
        padding: 10px 0;
        text-align: center;
    }
</style>
<section class="page-section">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-lg-8 col-xl-6 text-center">
                <h2 class="mt-0">Feedback</h2>
                <hr class="divider" />
                <p class="text-muted mb-5">Customer Feedbacks</p>
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
                            hideCustomAlertAfterTimeout(2000);
                        });
                        </script>";
                } ?>

                <!-- Add Movie Button -->
                <!-- <div class="d-grid">
                    <button class="btn btn-success btn-xl mb-3" id="addMovieBtn">Add Movie</button>
                </div> -->
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
                            }
                        }
                        ?>
                    </div>
                </div>

                <!-- Feedback Table -->
                <div class="table-container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>
                                            <td>{$row['id']}</td>
                                            <td>{$row['name']}</td>
                                            <td>{$row['email']}</td>
                                            <td>{$row['phone']}</td>
                                            <td>{$row['message']}</td>";
                                            echo "<td><a class='btn btn-danger btn-sm deleteMovieBtn' href='./feedback.php?id=" . $row["id"] . "'>Delete</a></td>";
                                        echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center'>No feedback found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>

<footer class="fixed-footer">
        <?php include './includes/footer.php'; ?>
    </footer>