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

// 여행 상품 목록을 가져오는 SQL 쿼리
$sql = "SELECT * FROM `TravelProduct`";
$result = $conn->query($sql);

// 여행 상품 목록을 담을 배열 초기화
$travelProducts = [];

// 쿼리 결과를 배열에 저장
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $travelProducts[] = $row;
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
        <h1>판매 상품 목록</h1>
        <div class="top-bar">
            <h2></h2>
            <a class="btn" href="add_product.php">여행 상품 추가</a>
        </div>
        <table>
            <tr>
                <th>상품 코드</th>
                <th>상품명</th>
                <th>출발지</th>
                <th>도착지</th>
                <th>상품 유형</th>
                <th>일정 보기</th>
                <th>수정</th>
                <th>삭제</th>
            </tr>
            <?php foreach ($travelProducts as $product) : ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['departure']; ?></td>
                    <td><?php echo $product['destination']; ?></td>
                    <td><?php echo $product['type']; ?></td>
                    <td><a class="btn" href="manage_schedules.php?product_id=<?php echo $product['id']; ?>">일정 보기</a></td>
                    <td><a class="btn" href="edit_product.php?id=<?php echo $product['id']; ?>">수정</a></td>
                    <td><a class="btn btn-danger" href="delete_product.php?id=<?php echo $product['id']; ?>" onclick="return confirm('정말로 삭제하시겠습니까?')">삭제</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="main-btn-container">
            <a class="btn" href="index.php">관리자 모드 홈으로 돌아가기</a>
        </div>
    </div>
</body>
</html>
