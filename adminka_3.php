<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ Панель</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    body {
        margin: 0;
        font-family: 'Montserrat', sans-serif;
        background-color: #fff;
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
        max-width: 1000px;
        margin: 20px auto;
        padding: 15px;
        background-color: #fff;
        border: 1px solid #000;
        border-radius: 8px;
    }
    h2 {
        color: #000;
        margin-bottom: 20px;
    }
    h2 a {
        text-decoration: none;
        color: #000;
        font-weight: bold;
    }
    h2 a:hover {
        text-decoration: underline;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    table th, table td {
        border: 1px solid #000;
        padding: 10px;
        text-align: left;
    }
    table th {
        background-color: #f0f0f0;
    }
    table td {
        background-color: #fff;
    }
    table tr:nth-child(even) td {
        background-color: #f9f9f9;
    }
    .but_1 {
        display: inline-block;
        background-color: #acdea6;
        color: #fff;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        cursor: pointer;
    }
    .but_1:hover {
        background-color: #86bf88;
    }
    @media (max-width: 768px) {
        .container {
            padding: 10px;
        }
        table th, table td {
            font-size: 14px;
            padding: 8px;
        }
        h2 {
            font-size: 18px;
        }
    }
    @media (max-width: 320px) {
        header p {
            font-size: 16px;
        }
        h2 {
            font-size: 16px;
        }
        table th, table td {
            font-size: 12px;
            padding: 5px;
        }
        .but_1 {
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
     <h2> <a href="adminka_1.php">Вернуться</a></h2>
    <h2>Список аккаунтов</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Имя пользователя</th>
            <th>Email</th>
            <th>Администратор</th>
            <th>Действия</th>
        </tr>

        <?php
        $link = mysqli_connect('localhost', 'root', '', 'shoes');
        if (!$link) {
            die("Ошибка подключения к базе данных: " . mysqli_connect_error());
        }

        $sql = "SELECT id, username, email, is_admin FROM users";
        $result = $link->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['username']}</td>
                        <td>{$row['email']}</td>
                        <td>" . ($row['is_admin'] ? 'Да' : 'Нет') . "</td>
                        <td>
                            <form method='POST' action=''>
                                <input type='hidden' name='user_id' value='{$row['id']}'>
                                <button type='submit' name='delete_user' class='but_1'>Удалить</button>
                            </form>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Нет аккаунтов</td></tr>";
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
            $user_id = (int)$_POST['user_id'];
            $check_user_sql = "SELECT * FROM users WHERE id = $user_id";
            $check_result = $link->query($check_user_sql);
            if ($check_result->num_rows > 0) {
                $delete_user_sql = "DELETE FROM users WHERE id = $user_id";

                if ($link->query($delete_user_sql) === TRUE) {
                    echo "<script>window.location.reload();</script>";
                } else {
                    echo "<script>alert('Ошибка при удалении аккаунта: " . $link->error . "');</script>";
                }
            } else {
                echo "<script>alert('Пользователь не найден');</script>";
            }
        }

        $link->close();
        ?>
    </table>
</div>
</body>
</html>
