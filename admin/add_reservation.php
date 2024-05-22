<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Reservation</title>
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
        <h1>예약 추가</h1>
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
                $customer_id = $_POST['customer_id'];
                $schedule_id = $_POST['schedule_id'];

                // 예약 추가 SQL 쿼리
                $sql = "INSERT INTO `Reservation` (`customer_id`, `schedule_id`, `reservation_date`, `confirmed`) 
                        VALUES ('$customer_id', '$schedule_id', NOW(), 0)";

                if ($conn->query($sql) === TRUE) {
                    // 예약 추가 성공 시 팝업 및 리디렉션
                    echo "<script>alert('예약이 성공적으로 추가되었습니다.'); window.location.href = 'manage_reservations.php';</script>";
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }

            $conn->close();
        ?>
        <form action="" method="post">
            <label for="customer_id">고객 ID:</label>
            <input type="text" id="customer_id" name="customer_id" required>
            <label for="schedule_id">일정 코드:</label>
            <input type="text" id="schedule_id" name="schedule_id" required>
            <input type="submit" value="추가">
        </form>
        <div class="main-btn-container">
            <a class="btn" href="manage_reservations.php">예약 목록으로 돌아가기</a>
        </div>
    </div>
</body>
</html>
