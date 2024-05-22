<?php
$servername = "localhost";
$username = "202012345user";
$password = "202012345pw";
$dbname = "traveldb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
