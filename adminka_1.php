<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}

$link = mysqli_connect('localhost', 'root', '', 'shoes');
if (!$link) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

//удаление
if (isset($_GET['delete_product'])) {
    $product_id = intval($_GET['delete_product']);
    $category = isset($_GET['category']) ? $_GET['category'] : '';

    if ($category == 'nike') {
        $query = "DELETE FROM items_nike WHERE id = ?";
    } elseif ($category == 'adidas') {
        $query = "DELETE FROM items_adidas WHERE id = ?";
    } elseif ($category == 'puma') {
        $query = "DELETE FROM items_puma WHERE id = ?";
    }

    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "i", $product_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

//добавление
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $product_name = isset($_POST['product_name']) ? mysqli_real_escape_string($link, $_POST['product_name']) : '';
    $product_price = isset($_POST['product_price']) ? floatval($_POST['product_price']) : 0;
    $product_structure = isset($_POST['product_structure']) ? mysqli_real_escape_string($link, $_POST['product_structure']) : '';
    $product_image = isset($_POST['product_image']) ? mysqli_real_escape_string($link, $_POST['product_image']) : '';
    $product_category = isset($_POST['product_category']) ? mysqli_real_escape_string($link, $_POST['product_category']) : '';

    if (!empty($product_name) && $product_price > 0 && !empty($product_structure) && !empty($product_image)) {
        if ($product_category == 'nike') {
            $query = "INSERT INTO items_nike (name, price, structure, image) VALUES (?, ?, ?, ?)";
        } elseif ($product_category == 'adidas') {
            $query = "INSERT INTO items_adidas (name, price, structure, image) VALUES (?, ?, ?, ?)";
        } elseif ($product_category == 'puma') {
            $query = "INSERT INTO items_puma (name, price, structure, image) VALUES (?, ?, ?, ?)";
        }

        $stmt = mysqli_prepare($link, $query);
        mysqli_stmt_bind_param($stmt, "sdss", $product_name, $product_price, $product_structure, $product_image);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

//редактирование
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_product'])) {
    $product_id = intval($_POST['product_id']);
    $product_name = mysqli_real_escape_string($link, $_POST['product_name']);
    $product_price = floatval($_POST['product_price']);
    $product_structure = mysqli_real_escape_string($link, $_POST['product_structure']);
    $product_image = mysqli_real_escape_string($link, $_POST['product_image']);
    $product_category = mysqli_real_escape_string($link, $_POST['product_category']);

    if ($product_category == 'nike') {
        $query = "UPDATE items_nike SET name = ?, price = ?, structure = ?, image = ? WHERE id = ?";
    } elseif ($product_category == 'adidas') {
        $query = "UPDATE items_adidas SET name = ?, price = ?, structure = ?, image = ? WHERE id = ?";
    } elseif ($product_category == 'puma') {
        $query = "UPDATE items_puma SET name = ?, price = ?, structure = ?, image = ? WHERE id = ?";
    }

    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "sdssi", $product_name, $product_price, $product_structure, $product_image, $product_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

//фильтрация
$filter_category = isset($_GET['category']) ? $_GET['category'] : 'all';
if ($filter_category == 'nike') {
    $products_result = mysqli_query($link, "SELECT 'nike' AS category, id, name, price, structure AS structure, image FROM items_nike");
} elseif ($filter_category == 'adidas') {
    $products_result = mysqli_query($link, "SELECT 'adidas' AS category, id, name, price, structure AS structure, image FROM items_adidas");
} elseif ($filter_category == 'puma') {
    $products_result = mysqli_query($link, "SELECT 'puma' AS category, id, name, price, structure AS structure, image FROM items_puma");
} else {
    $products_result = mysqli_query($link, "
        SELECT 'nike' AS category, id, name, price, structure AS structure, image FROM items_nike
        UNION ALL
        SELECT 'adidas', id, name, price, structure AS structure, image FROM items_adidas
        UNION ALL
        SELECT 'puma', id, name, price, structure AS structure, image FROM items_puma
    ");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <title>Админ Панель</title>
    <style>
    body {
        margin: 0;font-family: 'Montserrat', sans-serif;        background-color: #fff;
        color: #000;
    }
    header {
        background-color: #acdea6;
        padding: 15px;
        text-align: center;
    }
    header p {
        margin: 0;
        font-size: 18px;
        font-weight: bold;
        color: #fff;
    }
    header p a {
        text-decoration: none;
        color: #fff;
    }
    .container {
        max-width: 800px;
        margin: 20px auto;
        padding: 15px;
        background-color: #fff;
        border: 1px solid #000;
        border-radius: 8px;
    }
    h1, h2 {
        color: #000;
    }
    ul {
        list-style: none;
        padding: 0;
    }
    li {
        margin: 15px 0;
        padding: 10px;
        border: 1px solid #000;
        border-radius: 5px;
        background-color: #f9f9f9;
    }
    li img {
        margin: 10px 0;
        display: block;
    }
    a {
        text-decoration: none;
        color: #000;
        font-weight: bold;
    }
    a:hover {
        text-decoration: underline;
    }
    form {
        margin-top: 10px;
    }
    input[type="text"], input[type="number"], select {
        display: block;
        margin: 5px 0;
        width: calc(100% - 20px);
        padding: 10px;
        border: 1px solid #000;
        border-radius: 5px;
        box-sizing: border-box;
    }
    input[type="submit"] {
        background-color: #acdea6;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;
    }
    input[type="submit"]:hover {
        background-color: #86bf88;
    }
    .but_1, .but_2, .but_3 {
        display: inline-block;
        background-color: #acdea6;
        color: #fff;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        cursor: pointer;
    }
    .but_1:hover, .but_2:hover, .but_3:hover {
        background-color: #86bf88;
    }
    @media (max-width: 768px) {
        .container {
            padding: 10px;
        }
        h1, h2 {
            font-size: 18px;
        }
        input[type="text"], input[type="number"], select {
            width: 100%;
        }
        ul li {
            font-size: 14px;
        }
    }
    @media (max-width: 320px) {
        header p {
            font-size: 16px;
        }
        h1, h2 {
            font-size: 16px;
        }
        ul li {
            font-size: 12px;
        }
        a, input[type="submit"], .but_1, .but_2, .but_3 {
            font-size: 12px;
            padding: 5px;
        }
    }
</style>


</head>
<body>
<header>
    <p><a href="index.php">Главная</a></p>
</header>
<div class="container">
    <h1>Админ Панель: Товары</h1>
    <a href="adminka_2.php"><h2>Управление заказами</h2></a>
    <a href="adminka_3.php"><h2>Управление аккаунтами</h2></a>

    <h2>Фильтр по категориям</h2>
    <a href="?category=all" class="but_1">Все</a>
    <a href="?category=puma" class="but_1">PUMA</a>
    <a href="?category=adidas" class="but_1">Adidas</a>
    <a href="?category=nike" class="but_1">NIKE</a>

    <h2>Добавить товар</h2>
    <form method="POST">
        <input type="text" name="product_name" required placeholder="Название товара">
        <input type="number" step="0.01" name="product_price" required placeholder="Цена">
        <input type="text" name="product_structure" required placeholder="Цвет">
        <input type="text" name="product_image" required placeholder="Ссылка на изображение">
        <select name="product_category" required>
            <option value="puma">PUMA</option>
            <option value="adidas">Adidas</option>
            <option value="nike">NIKE</option>
        </select>
        <input class="but_1" type="submit" name="add_product" value="Добавить товар">
    </form>

    <h2>Список товаров</h2>
    <ul>
        <?php while ($row = mysqli_fetch_assoc($products_result)): ?>
            <li>
                <strong><?= htmlspecialchars($row['name']); ?></strong> - <?= htmlspecialchars($row['price']); ?> руб.
                <br>Фирма: <?= htmlspecialchars($row['structure']); ?>
                <img src="<?= htmlspecialchars($row['image']); ?>" alt="<?= htmlspecialchars($row['name']); ?>" style="width:50px;height:50px;">
                <a class="but_2" href="?delete_product=<?= $row['id']; ?>&category=<?= $row['category']; ?>">Удалить</a>
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="product_id" value="<?= $row['id']; ?>">
                    <input type="hidden" name="product_category" value="<?= $row['category']; ?>">
                    <input type="text" name="product_name" value="<?= htmlspecialchars($row['name']); ?>" required>
                    <input type="number" step="0.01" name="product_price" value="<?= $row['price']; ?>" required>
                    <input type="text" name="product_structure" value="<?= htmlspecialchars($row['structure']); ?>" required>
                    <input type="text" name="product_image" value="<?= htmlspecialchars($row['image']); ?>" required>
                    <input class="but_3" type="submit" name="edit_product" value="Редактировать">
                </form>
            </li>
        <?php endwhile; ?>
    </ul>
</div>

<?php mysqli_close($link); ?>
</body>
</html>
