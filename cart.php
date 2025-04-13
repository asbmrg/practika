<?php
session_start();

$isAuthorized = isset($_SESSION['user_id']);
$user_id = $isAuthorized ? $_SESSION['user_id'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['quantity'])) {
        foreach ($_POST['quantity'] as $item_id => $quantity) {
            if (isset($_SESSION['cart'][$item_id])) {
                $quantity = max(0, intval($quantity));
                if ($quantity > 0) {
                    $_SESSION['cart'][$item_id]['quantity'] = $quantity;
                } else {
                    unset($_SESSION['cart'][$item_id]);
                }
            }
        }
    }
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    echo json_encode(['total' => $total]);
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
    font-family: 'Montserrat', sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 0;
}
    .container {
        width: 80%;
        margin: 0 auto;
            margin-top: 30px;
            margin-bottom: 30px;
            padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    background-color: #f9f9f9;
    }

.cart-container {
    max-width: 800px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.cart-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.cart-item p {
    margin: 0;
    font-size: 16px;
}

.quantity-input {
    width: 60px;
    padding: 5px;
    border: 1px solid #ddd;
    border-radius: 4px;
    text-align: center;
}

.action-btn, .clear-btn, .order-btn {
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    padding: 10px 20px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.action-btn:hover, .clear-btn:hover, .order-btn:hover {
    background-color: #45a049;
}

.cart-total {
    font-size: 18px;
    font-weight: bold;
    text-align: right;
    margin: 20px 0;
}

.order-btn {
    width: 100%;
    display: block;
    margin-top: 20px;
}

.giff {
    display: block;
    margin: 0 auto;
    width: 50%;
    max-width: 200px;
}

@media (max-width: 768px) {
    .cart-container {
        padding: 10px;
    }

    .cart-item {
        flex-direction: column;
        align-items: flex-start;
    }

    .quantity-input {
        margin-top: 10px;
    }

    .action-btn {
        margin-top: 10px;
        width: 100%;
    }
}body {
    margin: 0;
    font-family: 'Montserrat', sans-serif;
    background-color: #fff;
    color: #000;
}

.cart-container {
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

.cart-item {
    border: 1px solid #e0e0e0;
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 8px;
    background-color: #fff;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.cart-item p {
    margin: 0;
    font-size: 16px;
    color: #333;
}

.cart-total {
    font-size: 18px;
    font-weight: bold;
    text-align: right;
    margin: 20px 0;
}

.quantity-input {
    width: 60px;
    padding: 5px;
    border: 1px solid #ddd;
    border-radius: 4px;
    text-align: center;
}

.btn, .clear-btn, .order-btn {
    display: inline-block;
    font-size: 16px;
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

.btn:hover, .clear-btn:hover, .order-btn:hover {
    background-color: #b3e4a0;
    border-color: #b3e4a0;
}

.clear-btn {
    background-color: #acdea6;
    border-color: #acdea6;
    color: #fff;
}

.clear-btn:hover {
    background-color: #acdea6;
    border-color: #acdea6;
}

.giff {
    display: block;
    margin: 0 auto;
    max-width: 300px;
    border-radius: 10px;
}

@media (max-width: 768px) {
    .cart-item {
        flex-direction: column;
        align-items: flex-start;
    }

    .quantity-input {
        margin-top: 10px;
    }

    .btn {
        margin-top: 10px;
        width: 100%;
    }
}


    </style>
</head>
<body>
    <?php include 'header.php'; ?>
<div class="container">
        <?php
        $total = 0;
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            echo '<form id="cart-form" method="POST" action="cart.php">';
            foreach ($_SESSION['cart'] as $item_id => $item) {
                echo '<div class="cart-item">';
                echo '<p><strong>' . htmlspecialchars($item['name']) . '</strong></p>';
                echo '<p>Цена: ' . htmlspecialchars($item['price']) . ' руб.</p>';
                $quantity = isset($item['quantity']) ? htmlspecialchars($item['quantity']) : 1;
                echo '<label for="quantity">Количество: </label>';
                echo '<input type="number" name="quantity[' . $item_id . ']" value="' . $quantity . '" class="quantity-input" min="0" data-item-id="' . $item_id . '">';
                echo '<button type="button" class="action-btn remove-item" data-item-id="' . $item_id . '">Удалить</button>';
                echo '</div>';
                $total += $item['price'] * $quantity;
            }
            echo '</form>';
            echo '<div class="cart-total">';
            echo '<p>Общая сумма: <span id="total-amount">' . htmlspecialchars($total) . '</span> руб.</p>';
            echo '</div>';
            echo '<form method="POST" action="order.php">';
            echo '<input type="hidden" name="user_id" value="' . htmlspecialchars($user_id) . '">';
            echo '<button type="submit" class="order-btn">Оформить заказ</button>';
            echo '</form>';
        } else {
            echo '<p>Ваша корзина пуста.<br></p>';
        }
        ?>
        <br>
        <form method="POST" action="clear_cart.php">
            <button type="submit" class="clear-btn">Очистить корзину</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            function updateCart(item_id, quantity) {
                $.ajax({
                    url: "cart.php",
                    type: "POST",
                    data: { quantity: { [item_id]: quantity } },
                    success: function(response) {
                        const data = JSON.parse(response);
                        if (data.total !== undefined) {
                            $('#total-amount').text(data.total.toFixed(2));
                        }
                    },
                    error: function() {
                        alert("Ошибка обновления корзины. Попробуйте снова.");
                    }
                });
            }

            $(document).on('input', '.quantity-input', function() {
                const item_id = $(this).data('item-id');
                const quantity = $(this).val();
                updateCart(item_id, quantity);
            });

            $(document).on('click', '.remove-item', function() {
                const item_id = $(this).data('item-id');
                updateCart(item_id, 0); // Удаляем товар при количестве 0
                $(this).closest('.cart-item').remove();
            });
        });
    </script>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <?php include 'footer.php'; ?>
</body>
</html>
