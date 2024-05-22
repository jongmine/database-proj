<?php
// 데이터베이스 연결 설정
$host = 'localhost:3306';
$dbUsername = "202001677user";
$dbPassword = '202001677pw';
$dbName = 'travelDB';

// 사용자가 제출한 양식 데이터 가져오기
$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$password = $_POST['password'];
$grade = 'bronze'; // 회원 가입 시 기본 등급 설정

// 데이터베이스 연결
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// 연결 오류 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 회원가입 쿼리 실행
$sql = "INSERT INTO `Customer` (`name`, `phone`, `email`, `password`, `grade`) VALUES ('$name', '$phone', '$email', '$password', '$grade')";
if ($conn->query($sql) === TRUE) {
    echo "새로운 고객이 추가되었습니다.";
    header("Location: login.php"); // 회원가입 후 로그인 페이지로 이동
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
