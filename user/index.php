<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

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

// 로그인된 사용자 정보 가져오기
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM `Customer` WHERE `id`='$user_id'";
$result = $conn->query($sql);

// 사용자 정보 확인
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome, <?php echo $user['name']; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 600px;
            margin: 50px auto;
        }
        h1 {
            color: #333;
        }
        .menu {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .menu a {
            margin: 0 10px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .menu a:hover {
            background-color: #45a049;
        }
        .logout-btn {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .logout-btn:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo $user['name']; ?>님, 환영합니다.</h1>
        <p>회원 등급: <?php echo ucfirst($user['grade']); ?></p>
        <div class="menu">
            <a href="products.php">여행 상품 보기</a>
            <a href="my_reservations.php">예약 현황</a>
            <a href="update_profile.php">회원 정보 변경</a>
        </div>
        <form action="logout.php" method="post">
            <button type="submit" class="logout-btn">로그아웃</button>
        </form>
    </div>
</body>
</html>
