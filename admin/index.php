<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Mode</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
        }
        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        li {
            margin-bottom: 10px;
        }
        li a {
            display: block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        li a:hover {
            background-color: #0056b3;
        }
        .main-btn-container {
            text-align: center;
            margin-top: 30px;
        }
        .main-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #f44336;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .main-btn:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>관리자 모드 페이지</h1>
        <ul>
            <li><a href="manage_products.php">여행 상품 관리</a></li>
            <li><a href="manage_reservations.php">예약 관리</a></li>
            <li><a href="manage_customers.php">고객 관리</a></li>
            <li><a href="manage_guides.php">가이드 관리</a></li>
        </ul>
        <div class="main-btn-container">
            <a class="main-btn" href="../index.php">Home</a>
        </div>
    </div>
</body>
</html>
