<?php


if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $loggedin = true;
    header('Location: index.php');
} else {
    $loggedin = false;
}


$showAlert = false;
$showError = [];
$valueCheck = true;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'includes/dbcon.php';
    include 'includes/signupIC.php';
    $name = isset($_POST['name']) ? trim($_POST['name']) : null;
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $username = isset($_POST['username']) ? trim($_POST['username']) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;
    $cpassword = isset($_POST['cpassword']) ? trim($_POST['cpassword']) : null;
    $userType = "user";

    

    $usernameEsistsCheck = usernameExists($username, $conn);
    $emailExistsCheck = emailExists($email, $conn);
    $passwordMatched = passwordCheck($password, $cpassword);
    $notnull = notNull($name, $email, $username, $password, $cpassword);
    if (!$usernameEsistsCheck and !$emailExistsCheck and $passwordMatched and $valueCheck and $notnull) {
        $hashedPass = hash('sha256', $password);
        $sql = "INSERT INTO `usertable`( `name`, `email`, `username`, `password`, `userType`) VALUES ('$name','$email','$username','$hashedPass', '$userType')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $showAlert = true;
        }
    } else {
        if ($usernameEsistsCheck)
            $showError[] = "Username already exists";
        if ($emailExistsCheck)
            $showError[] = "Email already exists";
        if (!$passwordMatched)
            $showError[] = "Passwords dont match";
    }
}

?>

<!-- Header -->
<?php include 'includes/header.php'; ?>
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
<!-- Contact-->
<section class="page-section" id="signup">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-lg-8 col-xl-6 text-center">
                <h2 class="mt-0">SIGN UP!</h2>
                <hr class="divider" />
                <p class="text-muted mb-5"></p>
            </div>
        </div>
        <div class="row gx-4 gx-lg-5 justify-content-center mb-5">
            <div class="col-lg-6">

                <form action="signup.php" method="post">

                    <!-- Error Message-->
                    <?php if (!$valueCheck) {
                        echo "<div id='alertId' class='alert alert-danger alert-dismissible fade show' role='alert'>
                    Fill all the fields!
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
                    }
                    if (!empty($showError)) {
                        foreach ($showError as $index => $error) {
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
                    }
                    ?>

                    <!-- Name input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="name" name="name" type="text"
                            placeholder="Enter your name..." />
                        <label for="name">Full Name</label>
                    </div>
                    <!-- userName input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="username" name="username" type="text"
                            placeholder="Enter your username..." />
                        <label for="name">Username</label>
                    </div>
                    <!-- Emailinput-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="email" name="email" type="email"
                            placeholder="Enter your email..." />
                        <label for="email">Email</label>
                    </div>
                    <!-- passwordinput-->
                    <!-- <div class="form-floating mb-3">
                        <input class="form-control" id="password" name="password" type="password"
                            placeholder="****************" />
                        <label for="password">Password</label>
                    </div> -->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="password" name="password" type="password"
                            placeholder="****************" data-sb-validations="required" />
                        <span class="password-toggle" onclick="togglePasswordVisibility('password', 'togglePasswordIcon')">
                            <i class="bi bi-eye-slash-fill" id="togglePasswordIcon"></i>
                        </span>
                        <label for="password">Password</label>
                    </div>
                    <!-- ConfirmPasswordinput-->
                    <!-- <div class="form-floating mb-3">
                        <input class="form-control" id="cpassword" name="cpassword" type="password"
                            placeholder="****************" />
                        <label for="password">Confirm Password</label>
                    </div> -->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="cpassword" name="cpassword" type="password"
                            placeholder="****************" />
                        <span class="password-toggle" onclick="togglePasswordVisibility('cpassword', 'toggleCPasswordIcon')">
                            <i class="bi bi-eye-slash-fill" id="toggleCPasswordIcon"></i>
                        </span>
                        <label for="cpassword">Confirm Password</label>
                    </div>

                    <!-- Submit Button-->
                    <div class="d-grid"><button class="btn btn-primary btn-xl" id="submitButton"
                            type="submit">SING UP!</button></div>
                </form>
            </div>

        </div>
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-lg-8 col-xl-6 text-center">
                <h6 class="mt-0">Have an account? <a href="login.php">Login</a></h6>

            </div>
        </div>

    </div>
</section>

<!-- Footer-->
        <?php include './includes/footer.php'; ?>
    