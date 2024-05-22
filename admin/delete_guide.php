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

$sql_delete_guide = "DELETE FROM `Guide` WHERE `id`=$id";
if ($conn->query($sql_delete_guide) === TRUE) {
    echo "<script>alert('가이드 정보가 성공적으로 삭제되었습니다.');</script>";
    echo "<script>window.location.href = 'manage_guides.php';</script>";
} else {
    echo "Error deleting guide: " . $conn->error;
}

$conn->close();
?>
