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
    include 'includes/db.inc.php';
    include 'includes/signup.inc.php';
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $userType = "user";

    $usernameEsistsCheck = usernameEsists($username, $conn);
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


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Ticketer - Movie Ticket Solution</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap Icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
    <!-- SimpleLightbox plugin CSS-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#page-top">TICKETER</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto my-2 my-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#movie">Movie</a></li>
                    <li class="nav-item"><a class="nav-link" href="#portfolio">TODO</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="#loginsignup">LOGIN/SIGNUP</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead-->


    <!-- Contact-->
    <section class="page-section" id="loginsignup">
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

                        <div class="form-floating mb-3">
                            <input class="form-control" id="username" name="username" type="text" placeholder="Enter your username..." data-sb-validations="required" />
                            <label for="name">Username</label>
                            <div class="invalid-feedback" data-sb-feedback="name:required">A username is required.</div>
                        </div>


                        <!-- userName input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="username" name="username" type="text" placeholder="Enter your username..." data-sb-validations="required" />
                            <label for="name">Username</label>
                            <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div>
                        </div>
                        <!-- passwordinput-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="password" name="password" type="password" placeholder="****************" data-sb-validations="required" />
                            <label for="password">Password</label>
                            <div class="invalid-feedback" data-sb-feedback="email:required">An email is required.</div>
                            <div class="invalid-feedback" data-sb-feedback="email:email">Email is not valid.</div>
                        </div>
                        <!-- Submit Button-->
                        <div class="d-grid"><button class="btn btn-primary btn-xl disabled" id="submitButton" type="submit">Submit</button></div>
                    </form>
                </div>

            </div>
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 col-xl-6 text-center">
                    <h6 class="mt-0">Do not have an account?<br><a href="signup.php">Create an account.</a></h6>
                    
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
    <footer class="bg-light py-5">
        <div class="container px-4 px-lg-5">
            <div class="small text-center text-muted">Copyright &copy; 2023 - Company Name</div>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SimpleLightbox plugin JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>


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