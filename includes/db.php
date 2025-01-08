<?php
$host = 'localhost';    // Host name
$user = '';         // Database username
$password = '';         // Database password
$dbname = ''; // Database name

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>