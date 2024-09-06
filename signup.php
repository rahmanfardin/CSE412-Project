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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
                    </ul>
                </div>
            </div>
        </nav>
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
</body>
</html>