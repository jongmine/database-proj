<?php
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

// 상품 ID 가져오기
$product_id = $_GET['product_id'];

// 해당 상품에 해당하는 일정 목록 및 가이드 정보 가져오는 SQL 쿼리
$sql = "SELECT ts.id, tp.name AS product_name, ts.price, ts.departure_date, ts.arrival_date, ts.airline, g.name AS guide_name
        FROM `TravelSchedule` ts
        INNER JOIN `TravelProduct` tp ON ts.product_id = tp.id
        LEFT JOIN `TravelSchedule_Guide` tsg ON ts.id = tsg.schedule
        LEFT JOIN `Guide` g ON tsg.guide = g.id
        WHERE ts.product_id = $product_id";
$result = $conn->query($sql);

// 일정 목록을 배열에 저장
$schedules = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $schedules[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Schedules</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
        .main-btn {
            display: block;
            text-align: center;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .main-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>여행 일정</h1>
        
        <h2>일정 목록</h2>
        <table>
            <tr>
                <th>일정 ID</th>
                <th>상품명</th>
                <th>가격</th>
                <th>출발일</th>
                <th>도착일</th>
                <th>항공사</th>
                <th>가이드</th>
                <th>예약</th>
            </tr>
            <?php foreach ($schedules as $schedule) : ?>
                <tr>
                    <td><?php echo $schedule['id']; ?></td>
                    <td><?php echo $schedule['product_name']; ?></td>
                    <td><?php echo $schedule['price']; ?> 원</td>
                    <td><?php echo $schedule['departure_date']; ?></td>
                    <td><?php echo $schedule['arrival_date']; ?></td>
                    <td><?php echo $schedule['airline']; ?></td>
                    <td><?php echo $schedule['guide_name'] ?? '없음'; ?></td>
                    <td><a href="reservation.php?schedule_id=<?php echo $schedule['id']; ?>">예약</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <a class="main-btn" href="products.php">상품 목록으로 돌아가기</a>
    </div>
</body>
</html>
