<?php
// db.php
$servername = "localhost";
$username = "root";      // Default XAMPP username
$password = "";          // Default XAMPP password is empty
$dbname = "personal_blog"; // Name of the database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
