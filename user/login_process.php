<?php
session_start();

// 데이터베이스 연결 설정
$host = 'localhost:3306';
$dbUsername = "202001677user";
$dbPassword = '202001677pw';
$dbName = 'travelDB';

// 사용자가 제출한 양식 데이터 가져오기
$email = $_POST['email'];
$password = $_POST['password'];

// 데이터베이스 연결
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// 연결 오류 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 사용자가 입력한 이메일과 비밀번호를 사용하여 데이터베이스에서 사용자를 찾음
$sql = "SELECT * FROM `Customer` WHERE `email`='$email' AND `password`='$password'";
$result = $conn->query($sql);

// 결과 확인
if ($result->num_rows > 0) {
    // 로그인 성공: 세션에 사용자 ID 저장
    $user = $result->fetch_assoc();
    $_SESSION['user_id'] = $user['id'];
    header("Location: index.php"); // 로그인 후 메인 페이지로 이동
    exit();
} else {
    // 로그인 실패: 로그인 페이지로 다시 리다이렉트
    header("Location: login.php?error=1"); // 실패한 경우 에러 메시지를 전달할 수 있음
    exit();
}
?>
