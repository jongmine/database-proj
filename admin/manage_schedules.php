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

$product_id = $_GET['product_id'];

// 여행 일정 목록을 가져오는 SQL 쿼리
$sql = "SELECT ts.*, GROUP_CONCAT(g.name SEPARATOR ', ') AS guides FROM `TravelSchedule` ts LEFT JOIN `TravelSchedule_Guide` tsg ON ts.id = tsg.schedule LEFT JOIN `Guide` g ON tsg.guide = g.id WHERE ts.`product_id`=$product_id GROUP BY ts.id";
$result = $conn->query($sql);

// 여행 일정 목록을 담을 배열 초기화
$travelSchedules = [];

// 쿼리 결과를 배열에 저장
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $travelSchedules[] = $row;
    }
}

// 데이터베이스 연결 종료
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Travel Schedules</title>
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
        h1, h2 {
            text-align: center;
            color: #333;
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
        .top-bar-right {
            margin-left: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>여행 일정 목록[상품코드: <?php echo $product_id; ?>]</h1>
        <div class="top-bar">
            <h2></h2>
            <a class="btn top-bar-right" href="add_schedule.php?product_id=<?php echo $product_id; ?>">여행 일정 추가</a>
        </div>
        <table>
            <tr>
                <th>일정 코드</th>
                <th>상품 코드</th>
                <th>가격</th>
                <th>출발일</th>
                <th>도착일</th>
                <th>항공사</th>
                <th>가이드</th>
                <th>수정</th>
                <th>삭제</th>
            </tr>
            <?php foreach ($travelSchedules as $schedule) : ?>
                <tr>
                    <td><?php echo $schedule['id']; ?></td>
                    <td><?php echo $schedule['product_id']; ?></td>
                    <td><?php echo $schedule['price']; ?> 원</td>
                    <td><?php echo $schedule['departure_date']; ?></td>
                    <td><?php echo $schedule['arrival_date']; ?></td>
                    <td><?php echo $schedule['airline']; ?></td>
                    <td><?php echo $schedule['guides'] != null ? $schedule['guides'] : '없음'; ?></td>
                    <td><a class="btn" href="edit_schedule.php?id=<?php echo $schedule['id']; ?>&product_id=<?php echo $product_id; ?>">수정</a></td>
                    <td><a class="btn btn-danger" href="delete_schedule.php?id=<?php echo $schedule['id']; ?>&product_id=<?php echo $product_id; ?>" onclick="return confirm('정말로 삭제하시겠습니까?')">삭제</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="main-btn-container">
            <a class="btn" href="manage_products.php">상품 목록으로 돌아가기</a>
        </div>
    </div>
</body>
</html>
