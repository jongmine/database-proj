<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Travel Schedule</title>
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
        input[type="text"], input[type="date"] {
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
        <h1>여행 일정 수정</h1>
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
            $product_id = $_POST['product_id'];
            $price = $_POST['price'];
            $departure_date = $_POST['departure_date'];
            $arrival_date = $_POST['arrival_date'];
            $airline = $_POST['airline'];
            $guide_id = $_POST['guide_id'];

            $sql = "UPDATE `TravelSchedule` SET `price`='$price', `departure_date`='$departure_date', `arrival_date`='$arrival_date', `airline`='$airline' WHERE `id`=$id";
            if ($conn->query($sql) === TRUE) {
                // 여행 일정 수정 후 가이드와의 연결 업데이트
                $sql_update_guide = "UPDATE `TravelSchedule_Guide` SET `guide`='$guide_id' WHERE `schedule`='$id'";
                if ($conn->query($sql_update_guide) === TRUE) {
                    echo "<script>alert('여행 일정이 성공적으로 수정되었습니다.'); window.location.href = 'manage_schedules.php?product_id=$product_id';</script>";
                    exit();
                } else {
                    echo "Error updating guide: " . $conn->error;
                }
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $conn->close();
        } else {
            $id = $_GET['id'];
            $product_id = $_GET['product_id'];
            $sql = "SELECT * FROM `TravelSchedule` WHERE `id`=$id";
            $result = $conn->query($sql);
            $schedule = $result->fetch_assoc();

            // 가이드 목록 가져오기
            $sql_guides = "SELECT * FROM `Guide`";
            $result_guides = $conn->query($sql_guides);
            $guides = [];
            if ($result_guides->num_rows > 0) {
                while ($row_guide = $result_guides->fetch_assoc()) {
                    $guides[] = $row_guide;
                }
            }
            $conn->close();
        }
        ?>
        <form action="edit_schedule.php" method="post" onsubmit="return confirm('수정하시겠습니까?')">
            <input type="hidden" name="id" value="<?php echo $schedule['id']; ?>">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <label for="price">가격:</label>
            <input type="text" id="price" name="price" value="<?php echo $schedule['price']; ?>" required>
            <label for="departure_date">출발일:</label>
            <input type="date" id="departure_date" name="departure_date" value="<?php echo $schedule['departure_date']; ?>" required>
            <label for="arrival_date">도착일:</label>
            <input type="date" id="arrival_date" name="arrival_date" value="<?php echo $schedule['arrival_date']; ?>" required>
            <label for="airline">항공사:</label>
            <input type="text" id="airline" name="airline" value="<?php echo $schedule['airline']; ?>" required>
            <label for="guide_id">가이드:</label>
            <select id="guide_id" name="guide_id">
                <option value="">가이드 선택</option>
                <?php foreach ($guides as $guide) : ?>
                    <option value="<?php echo $guide['id']; ?>" <?php if ($guide['id'] == $schedule['guide_id']) echo 'selected'; ?>><?php echo $guide['name']; ?></option>
                <?php endforeach; ?>
            </select><br>
            <input type="submit" value="수정">
        </form>
        <div class="main-btn-container">
            <a class="btn" href="manage_schedules.php?product_id=<?php echo $product_id; ?>">일정 목록으로 돌아가기</a>
        </div>
    </div>
</body>
</html>

