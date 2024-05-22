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

// 가이드 목록을 가져오는 SQL 쿼리
$sql = "SELECT * FROM `Guide`";
$result = $conn->query($sql);

// 가이드 목록을 배열에 저장
$guides = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $guides[] = $row;
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
        <h1>가이드 목록</h1>
        <div class="top-bar">
            <h2></h2>
            <a class="btn" href="add_guide.php">가이드 추가</a>
        </div>
        <table>
            <tr>
                <th>ID</th>
                <th>이름</th>
                <th>전화번호</th>
                <th>이메일</th>
                <th>등급</th>
                <th>수정</th>
                <th>삭제</th>
            </tr>
            <?php foreach ($guides as $guide) : ?>
                <tr>
                    <td><?php echo $guide['id']; ?></td>
                    <td><?php echo $guide['name']; ?></td>
                    <td><?php echo $guide['phone']; ?></td>
                    <td><?php echo $guide['email']; ?></td>
                    <td><?php echo $guide['rank']; ?></td>
                    <td><a class="btn" href="edit_guide.php?id=<?php echo $guide['id']; ?>">수정</a></td>
                    <td><a class="btn btn-danger" href="delete_guide.php?id=<?php echo $guide['id']; ?>" onclick="return confirm('정말로 삭제하시겠습니까?')">삭제</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
        
        <div class="main-btn-container">
            <a class="btn" href="index.php">관리자 모드 홈으로 돌아가기</a>
        </div>
    </div>
</body>
</html>
