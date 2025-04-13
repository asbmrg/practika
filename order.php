<?php
session_start();

$link = mysqli_connect('localhost', 'root', '', 'shoes');
if (!$link) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказы</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
<style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            color: #000;
        }

        .container {
            max-width: 80%;
            margin: 30px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            color: #666;
            margin: 20px 0;
        }

        .success-message {
            font-size: 20px;
            font-weight: bold;
            color: #4caf50;
        }

        .order-link a {
            font-size: 18px;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            background-color: #acdea6;
            color: #000;
            border: 1px solid #acdea6;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .order-link a:hover {
            background-color: #b3e4a0;
            border-color: #b3e4a0;
        }

        .empty-message {
            font-size: 18px;
            color: #e57373;
            margin: 20px 0;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .order-link a {
                font-size: 16px;
                padding: 8px 16px;
            }

            p {
                font-size: 16px;
            }
        }

        @media (max-width: 320px) {
            .order-link a {
                font-size: 14px;
                padding: 6px 12px;
            }

            p {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
        <?php include 'header.php'; ?>
<div class="container">
  <?php
        $user_id = $_SESSION['user_id'] ?? 0;

        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            $query_order = "INSERT INTO orders (user_id, total_price, order_date) VALUES (?, ?, NOW())";
            $stmt_order = mysqli_prepare($link, $query_order);

            $total_price = 0;
            foreach ($_SESSION['cart'] as $item) {
                $item_quantity = isset($item['quantity']) ? $item['quantity'] : 1;
                $total_price += $item['price'] * $item_quantity;
            }

            mysqli_stmt_bind_param($stmt_order, 'id', $user_id, $total_price);
            mysqli_stmt_execute($stmt_order);

            $order_id = mysqli_insert_id($link);

            $query_order_item = "INSERT INTO order_items (order_id, item_id, item_name, item_price, quantity) VALUES (?, ?, ?, ?, ?)";
            $stmt_item = mysqli_prepare($link, $query_order_item);

            foreach ($_SESSION['cart'] as $item_id => $item) {
                $item_quantity = isset($item['quantity']) ? $item['quantity'] : 1;
                mysqli_stmt_bind_param($stmt_item, 'iisdi', $order_id, $item_id, $item['name'], $item['price'], $item_quantity);
                mysqli_stmt_execute($stmt_item);
            }

            unset($_SESSION['cart']);

            echo '<p class="success-message">Ваш заказ успешно оформлен!</p>';
            echo '<div class="order-link"><a href="category.php">Вернуться к покупкам</a></div>';
        } else {
            echo '<p>Ваша корзина пуста.</p>';
        }

        mysqli_close($link);
        ?>
        </div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <?php include 'footer.php'; ?>
</body>
</html>
