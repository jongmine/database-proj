<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Travel Product</title>
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
        input[type="text"] {
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
        <h1>여행 상품 수정</h1>
        <?php
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $host = 'localhost:3306';
        $dbUsername = "202001677user";
        $dbPassword = '202001677pw';
        $dbName = 'travelDB';

        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $departure = $_POST['departure'];
            $destination = $_POST['destination'];
            $type = $_POST['type'];

            $sql = "UPDATE `TravelProduct` SET `name`='$name', `departure`='$departure', `destination`='$destination', `type`='$type' WHERE `id`=$id";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('여행 상품이 성공적으로 수정되었습니다.'); window.location.href = 'manage_products.php';</script>";
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $conn->close();
        } else {
            $id = $_GET['id'];
            $sql = "SELECT * FROM `TravelProduct` WHERE `id`=$id";
            $result = $conn->query($sql);
            $product = $result->fetch_assoc();
            $conn->close();
        }
        ?>
        <form action="edit_product.php" method="post">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
            <label for="name">상품명:</label>
            <input type="text" id="name" name="name" value="<?php echo $product['name']; ?>" required>
            <label for="departure">출발지:</label>
            <input type="text" id="departure" name="departure" value="<?php echo $product['departure']; ?>" required>
            <label for="destination">여행지:</label>
            <input type="text" id="destination" name="destination" value="<?php echo $product['destination']; ?>" required>
            <label for="type">상품 유형:</label>
            <input type="text" id="type" name="type" value="<?php echo $product['type']; ?>" required>
            <input type="submit" value="수정">
        </form>
        <div class="main-btn-container">
            <a class="btn" href="manage_products.php">상품 목록으로 돌아가기</a>
        </div>
    </div>
</body>
</html>
