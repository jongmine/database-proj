<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservation</title>
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
        input[type="checkbox"] {
            margin-top: 10px;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>예약 정보 수정</h1>
        <?php
            error_reporting(E_ALL);
            ini_set('display_errors', 1);

            $host = 'localhost:3306';
            $dbUsername = "202001677user";
            $dbPassword = '202001677pw';
            $dbName = 'travelDB';

            function updateReservation($conn, $reservation_id, $customer_id, $schedule_id, $reservation_date, $confirmed) {
                $sql = "UPDATE `Reservation` SET `customer_id`='$customer_id', `schedule_id`='$schedule_id', `reservation_date`='$reservation_date', `confirmed`='$confirmed' WHERE `id`='$reservation_id'";
                if ($conn->query($sql) === TRUE) {
                    return true;
                } else {
                    return "Error: " . $sql . "<br>" . $conn->error;
                }
            }

            function getReservationDetails($conn, $reservation_id) {
                $sql = "SELECT * FROM `Reservation` WHERE `id`='$reservation_id'";
                $result = $conn->query($sql);
                if ($result->num_rows == 1) {
                    return $result->fetch_assoc();
                } else {
                    return null;
                }
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
                $reservation_id = $_POST['id'];
                $customer_id = $_POST['customer_id'];
                $schedule_id = $_POST['schedule_id'];
                $reservation_date = $_POST['reservation_date'];
                $confirmed = isset($_POST['confirmed']) ? 1 : 0;

                $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $result = updateReservation($conn, $reservation_id, $customer_id, $schedule_id, $reservation_date, $confirmed);
                if ($result === true) {
                    header("Location: manage_reservations.php");
                    exit();
                } else {
                    echo "<p>" . $result . "</p>";
                }
                $conn->close();
            } else {
                if (isset($_GET['id'])) {
                    $reservation_id = $_GET['id'];
                    
                    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $reservation = getReservationDetails($conn, $reservation_id);
                    if ($reservation) {
                        $customer_id = $reservation['customer_id'];
                        $schedule_id = $reservation['schedule_id'];
                        $reservation_date = $reservation['reservation_date'];
                        $confirmed = $reservation['confirmed'];
                    } else {
                        echo "<p>Reservation not found.</p>";
                    }
                    $conn->close();
                } else {
                    echo "<p>Please provide a reservation ID.</p>";
                }
            }
        ?>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $reservation_id; ?>">
            <label for="customer_id">고객 ID:</label>
            <input type="text" id="customer_id" name="customer_id" value="<?php echo $customer_id; ?>"><br>
            <label for="schedule_id">일정 코드:</label>
            <input type="text" id="schedule_id" name="schedule_id" value="<?php echo $schedule_id; ?>"><br>
            <label for="reservation_date">예약일:</label>
            <input type="date" id="reservation_date" name="reservation_date" value="<?php echo $reservation_date; ?>"><br>
            <label for="confirmed">출발 확정 여부:</label>
            <input type="checkbox" id="confirmed" name="confirmed" <?php echo $confirmed ? 'checked' : ''; ?>><br>
            <input type="submit" value="Save">
        </form>
    </div>
</body>
</html>
