<?php
if (!isset($login)) {
    $login = false;
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
            <!-- <img src="./assets/favicon.ico" alt=""> -->
            <a class="navbar-brand" href="../index.php"><img src="./assets/favicon.ico" alt=""> TICKETER</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto my-2 my-lg-0">
                <li class="nav-item"><a class="nav-link" href="../index.php#page-top">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="../index.php#movie">Movie</a></li>
                    <li class="nav-item"><a class="nav-link" href="../ticket.php">Ticket</a></li>
                    <li class="nav-item"><a class="nav-link" href="../index.php#contact">Contact</a></li>



                    <?php if ($login) {
                        echo '
                        <!-- Profile Button -->
                    <button id="profileBtn" class="btn btn-primary">Profile</button>
                        <!-- Profile Modal -->
                        <div id="profileModal" class="modal2">
                            <div class="modal-content-2">
                                <span class="close">&times;</span>
                                <h2>Profile</h2>
                                <p>Name: John Doe</p>
                                <p>Email: john.doe@example.com</p>
                                <!-- Add more profile details as needed -->
                                <li class="nav-item"><a class="nav-link" href="./includes/signout.php">logout</a></li>
                            </div>
                        </div>';
                        echo '<li class="nav-item"><a class="nav-link" href="./includes/signout.php">logout</a></li>';
                    } else {
                        echo '<li class="nav-item"><a class="btn btn-primary" href="login.php">LOGIN/SIGNUP</a></li>';
                    } ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead-->