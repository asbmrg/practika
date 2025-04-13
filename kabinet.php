<?php
session_start();

$isAuthorized = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <title>Личный кабинет</title>
    <style>
        body {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            background-color: #fff;
            color: #000;
        }

        .container {
            max-width: 80%;
            margin: 30px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
        }

        h1, h2 {
            text-align: center;
        }

        .btn {
            display: inline-block;
            font-size: 18px;
            padding: 10px 20px;
            border-radius: 5px;
            border: 1px solid #acdea6;
            background-color: #acdea6;
            color: #000;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn:hover {
            background-color: #b3e4a0;
            border-color: #b3e4a0;
        }

        .btn.red-link {
            background-color: #acdea6;
            border-color: #acdea6;
            color: #fff;
        }

        .btn.red-link:hover {
            background-color: #acdea6;
            border-color: #acdea6;
        }

        .order {
            border: 1px solid #e0e0e0;
            padding: 15px;
            margin: 20px 0;
            border-radius: 10px;
            background-color: #fff;
        }

        .order h3 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .order p {
            margin: 10px 0;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th, table td {
            border: 1px solid #e0e0e0;
            padding: 10px;
            text-align: left;
        }

        table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .order-divider {
            border: 0;
            height: 1px;
            background: #e0e0e0;
            margin: 20px 0;
        }

        .auth-message {
            text-align: center;
            font-size: 18px;
            margin: 20px 0;
        }

        .auth-message a {
            color: #000;
            text-decoration: underline;
        }

        /* Адаптивность */
        @media (max-width: 768px) {
            .btn {
                font-size: 16px;
                padding: 8px 16px;
            }

            table th, table td {
                font-size: 14px;
                padding: 8px;
            }

            .order h3 {
                font-size: 16px;
            }
        }

        @media (max-width: 480px) {
            .btn {
                font-size: 14px;
                padding: 6px 12px;
            }

            table th, table td {
                font-size: 12px;
            }

            .order h3 {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
        <?php include 'header.php'; ?>
<div class="container">


    <?php if ($isAuthorized): ?>
        <h1>Добро пожаловать в личный кабинет</h1>
        <p>Рады видеть вас, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        <a href="logout.php" class="red-link">Выйти из аккаунта</a>

        <?php
        $conn = mysqli_connect('localhost', 'root', '', 'shoes');
        if (!$conn) {
            die("Ошибка подключения к базе данных: " . mysqli_connect_error());
        }

        $userId = $_SESSION['user_id'];
        $adminQuery = "SELECT is_admin FROM users WHERE id = ?";
        $stmt = $conn->prepare($adminQuery);
        if ($stmt === false) {
            die("Ошибка подготовки запроса: " . mysqli_error($conn));
        }
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $adminResult = $stmt->get_result();
        $user = $adminResult->fetch_assoc();

        if ($user && $user['is_admin'] == 1) {
            echo '<a href="adminka_1.php" class="admin-link">Вернуться в админ-панель</a>';
        }

        $stmt->close();
        ?>

        <h2>Ваши заказы</h2>
        <hr class="order-divider">

        <?php
        $ordersQuery = "SELECT * FROM orders WHERE user_id = ?";
        $stmt = $conn->prepare($ordersQuery);
        if ($stmt === false) {
            die("Ошибка подготовки запроса: " . mysqli_error($conn));
        }

        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $ordersResult = $stmt->get_result();

        if ($ordersResult->num_rows > 0) {
            while ($order = $ordersResult->fetch_assoc()) {
                echo "<div class='order'>";
                echo "<h3>Заказ #" . $order['id'] . " от " . htmlspecialchars($order['order_date']) . "</h3>";
                echo "<p>Сумма: " . htmlspecialchars($order['total_price']) . " руб.</p>";

                $orderId = $order['id'];
                $itemsQuery = "SELECT * FROM order_items WHERE order_id = ?";
                $itemsStmt = $conn->prepare($itemsQuery);
                if ($itemsStmt === false) {
                    die("Ошибка подготовки запроса: " . mysqli_error($conn));
                }

                $itemsStmt->bind_param("i", $orderId);
                $itemsStmt->execute();
                $itemsResult = $itemsStmt->get_result();

                if ($itemsResult->num_rows > 0) {
                    echo "<table>";
                    echo "<tr><th>Название товара</th><th>Цена</th><th>Количество</th></tr>";
                    while ($item = $itemsResult->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($item['item_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($item['item_price']) . " руб.</td>";
                        echo "<td>" . htmlspecialchars($item['quantity']) . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>В этом заказе нет товаров.</p>";
                }
                echo "</div>";
                echo "<hr class='order-divider'>";
            }
        } else {
            echo "<p>У вас еще нет заказов.</p>";
        }

        $stmt->close();
        $conn->close();
        ?>
    <?php else: ?>
        <h2>Вы не авторизованы</h2>
        <p>Пожалуйста, авторизуйтесь, чтобы получить доступ к вашему личному кабинету.</p>
        <div class="register-link">
            <p><a href="registr.php">Зарегистрироваться</a> или <a href="vhod.php">Войти</a></p>
        </div>
    <?php endif; ?>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <?php include 'footer.php'; ?>
</body>
</html>
