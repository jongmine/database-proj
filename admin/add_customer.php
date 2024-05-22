<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
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
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin: 10px 0 5px;
            color: #333;
        }
        input[type="text"], select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
            width: calc(100% - 22px);
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            text-align: center;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .main-btn-container {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>고객 추가</h1>
        <?php
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $host = 'localhost:3306';
        $dbUsername = "202001677user";
        $dbPassword = '202001677pw';
        $dbName = 'travelDB';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $grade = $_POST['grade'];

            $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "INSERT INTO `Customer` (`name`, `phone`, `email`, `password`, `grade`) VALUES ('$name', '$phone', '$email', '$password', '$grade')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('새로운 고객이 추가되었습니다.'); window.location.href = 'manage_customers.php';</script>";
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $conn->close();
        }
        ?>
        <form action="add_customer.php" method="post">
            <label for="name">이름:</label>
            <input type="text" id="name" name="name" required>
            <label for="phone">전화번호:</label>
            <input type="text" id="phone" name="phone" required>
            <label for="email">이메일:</label>
            <input type="text" id="email" name="email" required>
            <label for="password">비밀번호:</label>
            <input type="text" id="password" name="password" required>
            <label for="grade">등급:</label>
            <select id="grade" name="grade" required>
                <option value="bronze">Bronze</option>
                <option value="silver">Silver</option>
                <option value="gold">Gold</option>
                <option value="vip">VIP</option>
            </select>
            <input type="submit" value="추가">
        </form>
        <div class="main-btn-container">
            <a class="btn" href="customer_list.php">고객 목록으로 돌아가기</a>
        </div>
    </div>
</body>
</html>
