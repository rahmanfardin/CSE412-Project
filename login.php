<!-- Header -->
<?php include 'includes/header.php'; ?>

<?php
session_start();
session_unset();
session_destroy();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $loggedin = true;
} else {
    $loggedin = false;
}


$login = false;
$showError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'includes/dbcon.php';
    $username = isset($_POST['username']) ? trim($_POST['username']) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;
    $hashed_password = hash('sha256', $password);

    $sql = "Select * from USERTABLE where username='$username' AND password='$hashed_password'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        $login = true;
        session_start();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['usertype'] = $row['userType']; // Store data in $storedData variable
        }
        echo $row;
        echo $_SESSION['usertype'];

        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        if ($_SESSION['usertype'] == 'admin') {
            header("location: admin/index.php");
        } else {
            header("location: index.php");
        }
    } else {
        // echo "Invalid Credentials";
        $showError = true;
    }
}
?>

<!-- login-->
<section class="page-section" id="login">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-lg-8 col-xl-6 text-center">
                <h2 class="mt-0">LOGIN!</h2>
                <hr class="divider" />
                <p class="text-muted mb-5"></p>
            </div>
        </div>
        <div class="row gx-4 gx-lg-5 justify-content-center mb-5">
            <div class="col-lg-6">

                <form action="login.php" method="post">

                    <!-- Error Message-->
                    <?php if ($showError == true) {
                        echo "<div id='alertId' class='alert alert-danger alert-dismissible fade show' role='alert'>
                        Invalid Credentials!
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                      </div>";
                        echo "<script>
                    setTimeout(function() {
                        var alertElement = document.getElementById('alertId');
                        if (alertElement) {
                            alertElement.classList.remove('show');
                            alertElement.classList.add('fade');
                            setTimeout(function() {
                                alertElement.remove();
                            }, 150);
                        }
                    }, " . (3000 + 1 * 1000) . ");
                  </script>";
                    } ?>

                    <!-- userName input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="username" name="username" type="text"
                            placeholder="Enter your username..." data-sb-validations="required" />
                        <label for="name">Username</label>
                    </div>

                    <!-- passwordinput-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="password" name="password" type="password"
                            placeholder="****************" data-sb-validations="required" />
                        <label for="password">Password</label>
                    </div>
                    <!-- Submit Button-->
                    <div class="d-grid"><button class="btn btn-primary btn-xl" id="submitButton"
                            type="submit">Submit</button></div>
                </form>
            </div>

        </div>
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-lg-8 col-xl-6 text-center">
                <h6 class="mt-0">Do not have an account?<br><a href="signup.php">Create an account</a></h6>

            </div>
        </div>
    </div>
</section>
<!-- Footer-->
<?php include 'includes/footer.php'; ?>