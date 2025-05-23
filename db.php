<?php
$host = 'localhost'; // your database host
$username = 'root'; // your database username
$password = ''; // your database password
$dbname = 'razer_store'; // your database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
