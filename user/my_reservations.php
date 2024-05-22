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

// 예약 취소 처리
if (isset($_GET['cancel_id'])) {
    $cancel_id = $_GET['cancel_id'];
    $sql_cancel = "DELETE FROM `Reservation` WHERE id = $cancel_id";
    if ($conn->query($sql_cancel) === TRUE) {
        echo "<script>alert('예약이 취소되었습니다.');</script>";
        // 새로고침 없이 예약 목록을 갱신하기 위해 JavaScript로 페이지 리로드
        echo "<script>window.location.href = 'my_reservations.php';</script>";
    } else {
        echo "Error: " . $sql_cancel . "<br>" . $conn->error;
    }
}

// 로그인된 사용자의 예약 정보 가져오기
$user_id = $_SESSION['user_id'];
$sql = "SELECT r.id, r.reservation_date, r.confirmed, tp.name AS product_name, ts.departure_date, ts.arrival_date
        FROM `Reservation` r
        INNER JOIN `TravelSchedule` ts ON r.schedule_id = ts.id
        INNER JOIN `TravelProduct` tp ON ts.product_id = tp.id
        WHERE r.customer_id = '$user_id'";
$result = $conn->query($sql);

// 예약 정보를 배열에 저장
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
    <title>My Reservations</title>
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
            max-width: 800px;
            margin: 50px auto;
        }
        h1 {
            color: #333;
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
        .link-btn {
            display: inline-block;
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
        .cancel-btn {
            background-color: #f44336;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
        }
        .cancel-btn:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>나의 예약</h1>
        <?php if (count($reservations) > 0) : ?>
            <table>
                <tr>
                    <th>예약 코드</th>
                    <th>예약일</th>
                    <th>상품명</th>
                    <th>출발일</th>
                    <th>도착일</th>
                    <th>예약 상태</th>
                    <th>취소</th>
                </tr>
                <?php foreach ($reservations as $reservation) : ?>
                    <tr>
                        <td><?php echo $reservation['id']; ?></td>
                        <td><?php echo $reservation['reservation_date']; ?></td>
                        <td><?php echo $reservation['product_name']; ?></td>
                        <td><?php echo $reservation['departure_date']; ?></td>
                        <td><?php echo $reservation['arrival_date']; ?></td>
                        <td><?php echo $reservation['confirmed'] ? '출발 확정' : '예약 대기'; ?></td>
                        <td><a href="#" onclick="confirmCancellation(<?php echo $reservation['id']; ?>)" class="cancel-btn">Cancel</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else : ?>
            <p>No reservations found.</p>
        <?php endif; ?>
        <a href="index.php" class="link-btn">Back to Home</a>
    </div>

    <script>
        function confirmCancellation(reservationId) {
            if (confirm("예약을 취소하시겠습니까?")) {
                window.location.href = "my_reservations.php?cancel_id=" + reservationId;
            }
        }
    </script>
</body>
</html>
