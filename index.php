<?php
session_start();
$login = false;
$alert = '';
if (isset($_SESSION['username'])) {
    $login = true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include './includes/dbcon.php';
    $name = isset($_POST["name"]) ? $_POST["name"] : 'default_user';
    $email = isset($_POST["email"]) ? $_POST["email"] : 'default_email@email.com';
    $phone = isset($_POST["phone"]) ? $_POST["phone"] : '0000000000';
    $message = isset($_POST["message"]) ? $_POST["message"] : 'default_message';

    // Prepare and bind
    if (!empty($name) && !empty($email) && !empty($phone) && !empty($message)) {


        $stmt = $conn->prepare("INSERT INTO feedback (name, email, phone, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $message);
    }
    // Execute the statement
    if ($stmt->execute()) {
        $alert = "New record created successfully";
    } else {
        $alert =  "Error: " . $stmt->error;
    }
    if ($alert) {
        echo "<div id='customAlert' class='alert alert-dismissible alert-success' role='alert'>
                <span id='customAlertMessage'>$alert</span>
                <button type='button' class='btn-close' aria-label='Close'></button>
              </div>";
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    showCustomAlert('$alert'); 
                    hideCustomAlertAfterTimeout(2000);
                });
              </script>";
    }
    // Close connections
    $stmt->close();
    $conn->close();
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
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic"
        rel="stylesheet" type="text/css" />
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
            <a class="navbar-brand" href="#page-top"><img src="./assets/favicon.ico" alt=""> TICKETER</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto my-2 my-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#page-top">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#movie">Movie</a></li>
                    <li class="nav-item"><a class="nav-link" href="#mytickets">My Tickets</a></li>
                    <li class="nav-item"><a class="nav-link" href="./ticket.php">Ticket</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>


                    <!-- Profile Button -->
                    <?php if ($login) {
                        echo '
                    <button id="profileBtn" class="btn btn-primary">Profile</button>
                        <div id="profileModal" class="modal2">
                            <div class="modal-content-2">
                                <h2>Profile</h2>
                                <p>Username: ' . $_SESSION["username"] . '</p>
                                <p><a href="/index.php#mytickets">My Tickets</a></p>
                                <a style="display: inline-block" class="btn btn-danger" href="./includes/signout.php">Logout</a>
                                <button class="btn btn-secondary close">Close</button>
                            </div>
                        </div>';
                    } else {
                        echo '<li class="nav-item"><a class="btn btn-primary" href="login.php">LOGIN/SIGNUP</a></li>';
                    } ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead-->
    <header class="masthead">
        <div class="container px-4 px-lg-5 h-100">
            <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-8 align-self-end">
                    <h1 class="text-white font-weight-bold">Your Favorite Place for Movie ticket solution</h1>
                    <hr class="divider" />
                </div>
                <div class="col-lg-8 align-self-baseline">
                    <p class="text-white-75 mb-5">All your movie ticket need under one website.</p>
                    <a class="btn btn-primary btn-xl" href="#movie">Find Out More</a>
                </div>
            </div>
        </div>
    </header>
    <!-- Movie-->
    <div id="movie">
        <?php
        // Include your database connection file
        include './includes/dbcon.php';

        // Fetch movies from the database
        $sql = "SELECT movieid, moviename, poster, genre FROM movietable LIMIT 6";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<div class="container-fluid p-0">
                <div class="row g-0">';
            while ($row = $result->fetch_assoc()) {
                echo "
                <div class='col-lg-4 col-sm-6'>
                    <a class='movie-box' href='ticket.php?movieid=" . htmlspecialchars($row["movieid"]) . "' title='" . htmlspecialchars($row["moviename"]) . "'>";
                echo '<img class="img-fluid" src="' . 'admin/uploads/posters/' . htmlspecialchars($row["poster"]) . '" alt="' . htmlspecialchars($row["moviename"]) . '">';
                echo "<div class='movie-box-caption'>
                            <div class='project-category text-white-50'>" . $row['genre'] . "</div>
                            <div class='project-name'>" . $row['moviename'] . "</div>
                        </div>
                    </a>
                </div> 
                ";
            }
            echo '</div>
            </div>';
        }

        ?>
    </div>

    <!-- My Tickets-->
    <section class="page-section bg-primary" id="mytickets">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="text-white mt-0">My Tickets</h2>
                    <hr class="divider divider-light" />
                    <p class="text-light mb-5">From here you can view ticket details also print ticket!</p>
                </div>
            </div>
            <?php
            // Fetch tickets from the database
            if (isset($_SESSION['userid'])) {
                $sql = "SELECT m.moviename, m.genre, m.movierating, s.date, s.slot, t.ticketid
                FROM ticket t JOIN movietable m JOIN slottable s
                WHERE t.userid = " . $_SESSION['userid'] . " AND t.slotid = s.slotid AND s.movieid = m.movieid";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo '<div class="row row-cols-1 row-cols-md-3 g-4">';
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($row['moviename']); ?></h5>
                                    <p class="card-text">
                                        Genre: <?php echo htmlspecialchars($row['genre']); ?><br>
                                        Rating: <?php echo htmlspecialchars($row['movierating']); ?><br>
                                        Date: <?php echo htmlspecialchars($row['date']); ?><br>
                                        Slot: <?php echo htmlspecialchars($row['slot']); ?>
                                    </p>
                                    <a href="./printTicket.php?ticketid=<?php echo $row['ticketid'] ?>" target="_blank" class="btn btn-primary">Download</a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
            } else if(!$login) {
                echo '<div class="col text-center">
                <p class="text-light">Login to see your Tickets</p>
            </div>';

            }
            else {
                echo '<div class="col text-center">
                <p class="text-light">No tickets found.</p>
            </div>';
            }
            echo '</div>';
            ?>
        </div>
    </section>

    <!-- Services-->
    <!-- <section class="page-section" id="services">
        <div class="container px-4 px-lg-5">
            <h2 class="text-center mt-0">At Your Service</h2>
            <hr class="divider" />
            <div class="row gx-4 gx-lg-5">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <div class="mb-2"><i class="bi-gem fs-1 text-primary"></i></div>
                        <h3 class="h4 mb-2">Sturdy Themes</h3>
                        <p class="text-muted mb-0">Our themes are updated regularly to keep them bug free!</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <div class="mb-2"><i class="bi-laptop fs-1 text-primary"></i></div>
                        <h3 class="h4 mb-2">Up to Date</h3>
                        <p class="text-muted mb-0">All dependencies are kept current to keep things fresh.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <div class="mb-2"><i class="bi-globe fs-1 text-primary"></i></div>
                        <h3 class="h4 mb-2">Ready to Publish</h3>
                        <p class="text-muted mb-0">You can use this design as is, or you can make changes!</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <div class="mb-2"><i class="bi-heart fs-1 text-primary"></i></div>
                        <h3 class="h4 mb-2">Made with Love</h3>
                        <p class="text-muted mb-0">Is it really open source if it's not made with love?</p>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <!-- Call to action-->

    <!-- Contact-->
    <section class="page-section" id="contact" style="background-color: rgba(244, 98, 58,0.1);">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 col-xl-6 text-center">
                    <h2 class="mt-0">Let's Get In Touch!</h2>
                    <hr class="divider" />
                    <p class="text-muted mb-5">Do you have any query, or suggestion?</p>
                </div>
            </div>
            <div class="row gx-4 gx-lg-5 justify-content-center mb-5">
                <div class="col-lg-6">
                    <form id="contactForm" action="index.php" method="post">
                        <!-- Name input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="name" name="name" type="text"
                                placeholder="Enter your name..." data-sb-validations="required" required />
                            <label for="name">Full name</label>
                            <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div>
                        </div>
                        <!-- Email address input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="email" name="email" type="email"
                                placeholder="name@example.com" data-sb-validations="required,email" required />
                            <label for="email">Email address</label>
                            <div class="invalid-feedback" data-sb-feedback="email:required">An email is required.</div>
                            <div class="invalid-feedback" data-sb-feedback="email:email">Email is not valid.</div>
                        </div>
                        <!-- Phone number input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="phone" name="phone" type="tel"
                                placeholder="(880) 1601 - XXXXXX" data-sb-validations="required" required />
                            <label for="phone">Phone number</label>
                            <div class="invalid-feedback" data-sb-feedback="phone:required">A phone number is required.
                            </div>
                        </div>
                        <!-- Message input-->
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="message" name="message" type="text"
                                placeholder="Enter your message here..." style="height: 10rem"
                                data-sb-validations="required" required></textarea>
                            <label for="message">Message</label>
                            <div class="invalid-feedback" data-sb-feedback="message:required">A message is required.
                            </div>
                        </div>
                        <!-- Submit success message-->
                        <div class="d-none" id="submitSuccessMessage">
                            <div class="text-center mb-3">
                                <div class="fw-bolder">Form submission successful!</div>

                            </div>
                        </div>
                        <!-- Submit success message-->
                        <!---->
                        <!-- This is what your users will see when the form-->
                        <!-- has successfully submitted-->
                        <div class="d-none" id="submitSuccessMessage">
                            <div class="text-center mb-3">
                                <div class="fw-bolder">Form submission successful!</div>
                                To activate this form, sign up at
                                <br />

                            </div>
                        </div>
                        <!-- Submit error message-->
                        <!---->
                        <!-- This is what your users will see when there is-->
                        <!-- an error submitting the form-->
                        <div class="d-none" id="submitErrorMessage">
                            <div class="text-center text-danger mb-3">Error sending message!</div>
                        </div>
                        <!-- Submit Button-->
                        <div class="d-grid"><button class="btn btn-primary btn-xl" id="submitButton"
                                type="submit">Submit</button></div>
                    </form>
                </div>
            </div>
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-4 text-center mb-5 mb-lg-0">
                    <i class="bi-phone fs-2 mb-3 text-muted"></i>
                    <div>+880 (16) XX-XXXXXX</div>
                </div>
            </div>
        </div>
    </section>
    <script>
        function validateForm() {
            let isValid = true;

            // Name validation
            const name = document.getElementById('name').value;
            if (name === "") {
                document.querySelector('[data-sb-feedback="name:required"]').style.display = 'block';
                isValid = false;
            } else {
                document.querySelector('[data-sb-feedback="name:required"]').style.display = 'none';
            }

            // Email validation
            const email = document.getElementById('email').value;
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email === "") {
                document.querySelector('[data-sb-feedback="email:required"]').style.display = 'block';
                isValid = false;
            } else if (!emailPattern.test(email)) {
                document.querySelector('[data-sb-feedback="email:email"]').style.display = 'block';
                isValid = false;
            } else {
                document.querySelector('[data-sb-feedback="email:required"]').style.display = 'none';
                document.querySelector('[data-sb-feedback="email:email"]').style.display = 'none';
            }

            // Phone validation
            const phone = document.getElementById('phone').value;
            if (phone === "") {
                document.querySelector('[data-sb-feedback="phone:required"]').style.display = 'block';
                isValid = false;
            } else {
                document.querySelector('[data-sb-feedback="phone:required"]').style.display = 'none';
            }

            // Message validation
            const message = document.getElementById('message').value;
            if (message === "") {
                document.querySelector('[data-sb-feedback="message:required"]').style.display = 'block';
                isValid = false;
            } else {
                document.querySelector('[data-sb-feedback="message:required"]').style.display = 'none';
            }

            return isValid;
        }
    </script>
    <!-- Footer-->
    <?php include 'includes/footer.php'; ?>