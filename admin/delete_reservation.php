<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost:3306';
$dbUsername = "202001677user";
$dbPassword = '202001677pw';
$dbName = 'travelDB';

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];

$sql = "DELETE FROM `Reservation` WHERE `id`=$id";
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('예약이 성공적으로 취소되었습니다.');</script>";
    echo "<script>window.location.href = 'manage_reservations.php';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
