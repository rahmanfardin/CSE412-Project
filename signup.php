<?php
session_start();
session_unset();
session_destroy();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  $loggedin = true;
} else {
  $loggedin = false;
}


$showAlert = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'includes/dbcon.php';
    include 'includes/signupIC.php';
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $userType = "user";

    $usernameEsistsCheck = usernameExists($username, $conn);
    $emailExistsCheck = emailExists($email, $conn);
    $passwordMatched = passwordCheck($password, $cpassword);
    if (!$usernameEsistsCheck and !$emailExistsCheck and $passwordMatched) {
        $hashedPass = hash('sha256', $password);
        $sql = "INSERT INTO `usertable`( `name`, `email`, `username`, `password`, `userType`) VALUES ('$name','$email','$username','$hashedPass', '$userType')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $showAlert = true;
        }
    } else {
        if ($usernameEsistsCheck)
            $showError = $showError . "| username exists |";
        if ($emailExistsCheck)
            $showError = $showError . "| email exists |";
        if (!$passwordMatched)
            $showError = $showError . "| passwords dont match |";
    }
}

?>

<!-- Header -->
<?php include 'includes/header.php'; ?>

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
                    <!-- * * * * * * * * * * * * * * *-->
                    <!-- * * SB Forms Contact Form * *-->
                    <!-- * * * * * * * * * * * * * * *-->
                    <!-- This form is pre-integrated with SB Forms.-->
                    <!-- To make this form functional, sign up at-->
                    <!-- https://startbootstrap.com/solution/contact-forms-->
                    <!-- to get an API token!-->
                    <form action="signup.php" method="post">

                        <!-- my modification-->

                        <!-- Name input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="name" name="name" type="text" placeholder="Enter your name..." required/>
                            <label for="name">Full Name</label>
                        </div>
                        <!-- userName input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="username" name="username" type="text" placeholder="Enter your username..." required/>
                            <label for="name">Username</label>
                        </div>
                        <!-- Emailinput-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="email" name="email" type="email" placeholder="Enter your email..." required/>
                            <label for="email">Email</label>
                            <div class="invalid-feedback" data-sb-feedback="email:required">An email is required.</div>
                        </div>
                        <!-- passwordinput-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="password" name="password" type="password" placeholder="****************" required/>
                            <label for="password">Password</label>
                        </div>
                        <!-- ConfirmPasswordinput-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="cpassword" name="cpassword" type="password" placeholder="****************" required/>
                            <label for="password">Confirm Password</label>
                        </div>
                        <!-- Submit Button-->
                        <div class="d-grid"><button class="btn btn-primary btn-xl" id="submitButton" type="submit">Submit</button></div>
                    </form>
                </div>

            </div>
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 col-xl-6 text-center">
                    <h6 class="mt-0">Have an account?<br><a href="login.php">Login.</a></h6>
                    
                </div>
            </div>

            <!-- <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-4 text-center mb-5 mb-lg-0">
                    <i class="bi-phone fs-2 mb-3 text-muted"></i>
                    <div>+880 (16) XX-XXXXXX</div>
                </div>
            </div> -->
        </div>
    </section>
    <!-- Footer-->
    <?php include 'includes/footer.php'; ?>


<h2>Sign Up Form</h2>
    <form action="signup.php" method="POST">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <label for="cpassword">Confirm Password:</label><br>
        <input type="password" id="cpassword" name="cpassword" required><br><br>

        <input type="submit" value="Sign Up">
    </form>