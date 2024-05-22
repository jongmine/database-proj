<?php
session_start(); // 세션을 시작합니다.

// 세션이 설정되어 있지 않으면 로그인 페이지로 이동합니다.
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// 데이터베이스 연결 설정
$host = 'localhost:3306'; // 호스트 주소
$dbUsername = "202001677user"; // 데이터베이스 사용자 이름
$dbPassword = '202001677pw'; // 데이터베이스 비밀번호
$dbName = 'travelDB'; // 사용할 데이터베이스 이름

// 데이터베이스 연결
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// 연결 오류 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 예약할 일정의 ID 가져오기
$schedule_id = $_GET['schedule_id'];

// 해당 일정 정보를 가져오는 SQL 쿼리
$sql_schedule = "SELECT ts.id AS schedule_id, tp.name AS product_name, ts.departure_date, ts.arrival_date, ts.airline
                 FROM `TravelSchedule` ts
                 INNER JOIN `TravelProduct` tp ON ts.product_id = tp.id
                 WHERE ts.id = $schedule_id";
$result_schedule = $conn->query($sql_schedule);

if ($result_schedule->num_rows > 0) {
    $schedule = $result_schedule->fetch_assoc();
} else {
    echo "해당 일정이 존재하지 않습니다.";
    exit;
}

// 예약 추가 쿼리 실행
$sql = "INSERT INTO `Reservation` (`customer_id`, `schedule_id`, `reservation_date`, `confirmed`) VALUES ('{$_SESSION['user_id']}', '$schedule_id', CURDATE(), false)";
if ($conn->query($sql) === TRUE) {
    // 예약이 성공적으로 완료되면 아래의 메시지와 예약 정보를 표시합니다.
    $reservation_info = "<div class='reservation-info'>
                            <h2>예약 정보</h2>
                            <p><strong>상품명:</strong> {$schedule['product_name']}</p>
                            <p><strong>출발일:</strong> {$schedule['departure_date']}</p>
                            <p><strong>도착일:</strong> {$schedule['arrival_date']}</p>
                            <p><strong>항공사:</strong> {$schedule['airline']}</p>
                        </div>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Completed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        p {
            text-align: center;
        }
        .reservation-info {
            margin-top: 20px;
            padding: 10px;
            background-color: #f2f2f2;
            border-radius: 5px;
        }
        .reservation-info p {
            margin: 5px 0;
        }
        .link-btn {
            display: block;
            text-align: center;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .link-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>예약이 완료되었습니다!</h1>
        
        <?php if(isset($reservation_info)) echo $reservation_info; ?>
        
        <a class="link-btn" href="my_reservations.php">예약 목록 조회</a>
        <a class="link-btn" href="index.php">메인 페이지로 가기</a>
    </div>
</body>
</html>
