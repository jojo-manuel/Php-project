<?php
// test_db.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "personal_blog";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully";
}

$conn->close();
?>