<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// 예약 목록 가져오는 SQL 쿼리
$sql = "SELECT r.id, r.customer_id, r.schedule_id, r.reservation_date, r.confirmed, c.name AS customer_name, ts.departure_date, ts.arrival_date, tp.name AS product_name
        FROM `Reservation` r
        INNER JOIN `Customer` c ON r.customer_id = c.id
        INNER JOIN `TravelSchedule` ts ON r.schedule_id = ts.id
        INNER JOIN `TravelProduct` tp ON ts.product_id = tp.id";
$result = $conn->query($sql);

// 예약 목록을 배열에 저장
$reservations = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reservations[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Travel Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1000px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .top-bar h2 {
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            color: #0056b3;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .main-btn-container {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>총 예약 목록</h1>
        <div class="top-bar">
            <h2></h2>
            <a class="btn" href="add_reservation.php">예약 추가</a>
        </div>
        <table>
            <tr>
                <th>예약 코드</th>
                <th>고객명</th>
                <th>상품명</th>
                <th>출발일</th>
                <th>도착일</th>
                <th>예약일</th>
                <th>예약 상태</th>
                <th>수정</th>
                <th>취소</th>
            </tr>
            <?php foreach ($reservations as $reservation) : ?>
                <tr>
                    <td><?php echo $reservation['id']; ?></td>
                    <td><?php echo $reservation['customer_name']; ?></td>
                    <td><?php echo $reservation['product_name']; ?></td>
                    <td><?php echo $reservation['departure_date']; ?></td>
                    <td><?php echo $reservation['arrival_date']; ?></td>
                    <td><?php echo $reservation['reservation_date']; ?></td>
                    <td><?php echo $reservation['confirmed'] ? '출발 확정' : '예약 대기'; ?></td>
                    <td><a class="btn" href="edit_reservation.php?id=<?php echo $reservation['id']; ?>">수정</a></td>
                    <td><a class="btn btn-danger" href="delete_reservation.php?id=<?php echo $reservation['id']; ?>" onclick="return confirm('Are you sure you want to delete this reservation?')">취소</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="main-btn-container">
            <a class="btn" href="index.php">관리자 모드 홈으로 돌아가기</a>
        </div>
    </div>
</body>
</html>
