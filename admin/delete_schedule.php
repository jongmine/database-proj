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
$product_id = $_GET['product_id'];

$sql_check_reservations = "SELECT COUNT(*) AS count FROM `Reservation` WHERE `schedule_id`=$id";
$result_check_reservations = $conn->query($sql_check_reservations);
$row_reservations = $result_check_reservations->fetch_assoc();

if ($row_reservations['count'] > 0) {
    echo "<script>alert('삭제할 수 없습니다. 해당 일정과 관련된 기존 예약이 있습니다.');</script>";
    echo "<script>window.location.href = 'manage_schedules.php?product_id=$product_id';</script>";
} else {
    $sql = "DELETE FROM `TravelSchedule` WHERE `id`=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('여행 일정이 성공적으로 삭제되었습니다.');</script>";
        echo "<script>window.location.href = 'manage_schedules.php?product_id=$product_id';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
