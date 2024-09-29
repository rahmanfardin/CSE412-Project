<!-- Header -->
<?php
include './includes/admin.validation.php';
$page_name = 'Admin Home';
include './includes/header.php';

// Database connection
include './includes/dbcon.php';

// Fetch user count
$userCountQuery = "
    SELECT usertype, COUNT(id) as user_count
    FROM usertable
    GROUP BY usertype
";
$userCountResult = $conn->query($userCountQuery);

// Fetch tickets per movie
$movieTicketsQuery = "
    SELECT m.moviename, COUNT(t.ticketid) as ticket_count
    FROM ticket t
    JOIN slottable s ON t.slotid = s.slotid
    JOIN movietable m ON s.movieid = m.movieid
    GROUP BY m.moviename
";
$movieTicketsResult = $conn->query($movieTicketsQuery);

// Fetch tickets per hall
$hallTicketsQuery = "
    SELECT h.hallname, COUNT(t.ticketid) as ticket_count
    FROM ticket t
    JOIN slottable s ON t.slotid = s.slotid
    JOIN halltable h ON s.hallid = h.hallid
    GROUP BY h.hallname
";
$hallTicketsResult = $conn->query($hallTicketsQuery);
?>

<!-- Masthead-->
<header class="masthead">
    <div class="container px-4 px-lg-5 h-100">
        <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-8 align-self-end">
                <h1 class="text-white font-weight-bold">Admin panel for Movie ticket solution</h1>
                <hr class="divider" />
            </div>
            <div class="col-lg-8 align-self-baseline">
                <p class="text-white-75 mb-5">All your movie ticket need under one website.</p>
            </div>
        </div>
    </div>
</header>

<!-- Dashboard-->
<section class="dashboard">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center text-center">
            <div class="col-lg-10">
                <h2 class="text font-weight-bold mt-5">Dashboard</h2>
                <hr class="divider" />

                <!-- User Count -->
                <h3 class="text">User</h3>
                <table class="table table-striped table-light">
                    <thead>
                        <tr>
                            <th>User Type</th>
                            <th>User Count</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = $userCountResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['usertype']; ?></td>
                                <td><?php echo $row['user_count']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <!-- Tickets per Movie -->
                <h3 class="text">Tickets per Movie</h3>
                <table class="table table-striped table-light">
                    <thead>
                        <tr>
                            <th>Movie Name</th>
                            <th>Ticket Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $movieTicketsResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['moviename']; ?></td>
                                <td><?php echo $row['ticket_count']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <!-- Tickets per Hall -->
                <h3 class="text">Tickets per Hall</h3>
                <table class="table table-striped table-light">
                    <thead>
                        <tr>
                            <th>Hall Name</th>
                            <th>Ticket Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $hallTicketsResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['hallname']; ?></td>
                                <td><?php echo $row['ticket_count']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<?php include 'includes/footer.php'; ?>