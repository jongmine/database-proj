<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 데이터베이스 연결 설정
$host = 'localhost:3306';
$dbUsername = "202001677user";
$dbPassword = '202001677pw';
$dbName = 'travelDB';

// 데이터베이스 연결
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// 연결 오류 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];

$sql_delete_reservations = "DELETE FROM `reservation` WHERE `customer_id`=$id";
if ($conn->query($sql_delete_reservations) === FALSE) {
    echo "Error deleting reservations: " . $conn->error;
}

$sql_delete_customer = "DELETE FROM `Customer` WHERE `id`=$id";
if ($conn->query($sql_delete_customer) === TRUE) {
    echo "<script>alert('고객 정보가 성공적으로 삭제되었습니다.');</script>";
    echo "<script>window.location.href = 'manage_customers.php';</script>";
} else {
    echo "Error deleting customer: " . $conn->error;
}

$conn->close();
?>
