<?php
session_start();
$link = mysqli_connect('localhost', 'root', '', 'shoes');
if (!$link) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'])) {
    $item_id = intval($_POST['item_id']);
    $item_name = mysqli_real_escape_string($link, $_POST['item_name']);
    $item_price = floatval($_POST['item_price']);

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $_SESSION['cart'][] = [
        'id' => $item_id,
        'name' => $item_name,
        'price' => $item_price,
        'quantity' => 1
    ];

    $_SESSION['added_to_cart'] = true;

    header("Location: nike.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
	<title>NIKE</title>
        <style>
                    body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
        }
                .container {
        width: 80%;
        margin: 0 auto;
            margin-top: 30px;
            margin-bottom: 30px;
    }
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }
    .modal-content {
        background-color: #fff;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        border-radius: 10px;
        width: 30%;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }
    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
    }

            .items-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .item-card {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            width: 290px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            border-radius: 10px;
        }
        .item-card:hover {
            transform: translateY(-5px);
        }
        .item-image {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .item-card h2 {
            font-size: 1.5em;
            margin-bottom: 10px;
        }
        .item-card .price {
            font-size: 1.6em;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }
        .item-card .description {
            font-size: 0.9em;
            margin-bottom: 10px;
            color: #555;
        }
        .add-to-cart-btn {
            background-color: #acdea6;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        /* Стиль модального окна */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            text-align: center;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .no-highlight a {
            text-decoration: none;
            color: inherit;
        }

        .no-highlight a:hover {
            text-decoration: none;
            color: inherit;
        }


</style>
</head>
<body>
        <?php include 'header.php'; ?>
<div class="container">
<?php
if (isset($_SESSION['added_to_cart']) && $_SESSION['added_to_cart']) {
    echo '<div id="myModal" class="modal">';
    echo '<div class="modal-content">';
    echo '<span class="close" id="closeModal">&times;</span>';
    echo '<p>Товар добавлен в корзину!</p>';
    echo '<a href="cart.php" class="add-to-cart-btn">Перейти в корзину</a>';
    echo '<button class="add-to-cart-btn" id="continueShopping">Продолжить покупки</button>';
    echo '</div>';
    echo '</div>';

    unset($_SESSION['added_to_cart']);
}

$link = mysqli_connect('localhost', 'root', '', 'shoes');
if (!$link) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

$query = "SELECT id, name, image, price, structure FROM items_nike";
$result = mysqli_query($link, $query);

if (mysqli_num_rows($result) > 0) {
    echo '<div class="items-container">';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="item-card">';
        echo '<h2>' . htmlspecialchars($row['name']) . '</h2>';
        echo '<img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '" class="item-image">';
        echo '<p class="price">Цена: ' . htmlspecialchars($row['price']) . ' руб.</p>';
        echo '<p class="structure">' . htmlspecialchars($row['structure']) . '</p>';

        if (isset($_SESSION['user_id'])) {
            echo '<form method="POST" action="nike.php">';
            echo '<input type="hidden" name="item_id" value="' . $row['id'] . '">';
            echo '<input type="hidden" name="item_name" value="' . $row['name'] . '">';
            echo '<input type="hidden" name="item_price" value="' . $row['price'] . '">';
            echo '<button type="submit" class="add-to-cart-btn">Добавить в корзину</button>';
            echo '</form>';
        } else {
            echo '<p><a href="vhod.php">Войдите</a>, чтобы добавить в корзину.</p>';
        }

        echo '</div>';
    }

    echo '</div>';
} else {
    echo 'Нет доступных товаров.';
}

mysqli_close($link);
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('myModal');
        const closeModal = document.getElementById('closeModal');
        const continueShopping = document.getElementById('continueShopping');

        if (modal) {
            modal.style.display = 'block';

            closeModal.addEventListener('click', function () {
                modal.style.display = 'none';
            });

            continueShopping.addEventListener('click', function () {
                modal.style.display = 'none';
            });

            window.addEventListener('click', function (event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        }
    });
</script>

</div>
    <?php include 'footer.php'; ?>
</body>
</html>