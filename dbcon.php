<?php
$db_host = 'localhost'; // Change this to your MySQL server hostname
$db_user = 'root'; // Change this to your MySQL username
$db_pass = ''; // Change this to your MySQL password
$db_name = 'cse412'; // Change this to your MySQL database name

// Create a database connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// Uncomment the following line if you want to set character encoding
// mysqli_set_charset($conn, 'utf8');

// Now you can use $conn for executing queries
// Example: mysqli_query($conn, "SELECT * FROM your_table");

// Close the connection when done
// mysqli_close($conn);
?>
