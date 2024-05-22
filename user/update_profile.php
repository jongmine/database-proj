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

// 사용자 정보 업데이트
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    
    $sql_update = "UPDATE `Customer` SET `name`='$name', `phone`='$phone', `email`='$email' WHERE `id`='$user_id'";
    if ($conn->query($sql_update) === TRUE) {
        $user['name'] = $name;
        $user['phone'] = $phone;
        $user['email'] = $email;
        echo "<script>alert('사용자 정보가 업데이트되었습니다.');</script>";
    } else {
        echo "Error: " . $sql_update . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
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
        form {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        input {
            margin: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .link-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .link-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>회원 정보 변경</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" name="name" placeholder="이름" value="<?php echo $user['name']; ?>" required>
            <input type="text" name="phone" placeholder="전화번호" value="<?php echo $user['phone']; ?>" required>
            <input type="email" name="email" placeholder="이메일" value="<?php echo $user['email']; ?>" required>
            <button type="submit">변경</button>
        </form>
        <a href="index.php" class="link-btn">메인 페이지로 가기</a>
    </div>
</body>
</html>
