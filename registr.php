<?php
session_start();  // Старт сессии должен быть на самом начале

// Проверка, что пользователь уже зарегистрирован
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register_submit'])) {
    $link = mysqli_connect('localhost', 'root', '', 'shoes');
    if (!$link) {
        die("Ошибка подключения к базе данных: " . mysqli_connect_error());
    }

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $is_admin = 0;

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error_message = "Все поля обязательны для заполнения.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Пароли не совпадают!";
    } else {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($link, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $error_message = "Пользователь с таким email уже существует.";
        } else {
            $insert_query = "INSERT INTO users (username, email, password, is_admin) VALUES (?, ?, ?, ?)";
            $insert_stmt = mysqli_prepare($link, $insert_query);
            mysqli_stmt_bind_param($insert_stmt, "sssi", $username, $email, $password, $is_admin);

            if (mysqli_stmt_execute($insert_stmt)) {
                $_SESSION['username'] = $username;
                // Перенаправление после успешной регистрации
                header("Location: index.php");
                exit();  // Важно! После header() следует завершить выполнение скрипта
            } else {
                $error_message = "Ошибка при регистрации: " . mysqli_error($link);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <title>Регистрация</title>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="submit"] {
            width: 95%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #acdea6;
            outline: none;
        }

        input[type="submit"] {
            background-color: #acdea6;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #8cb78b;
        }

        .error-message {
            color: red;
            text-align: center;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<?php
// Подключение файла header.php после всех PHP операций с сессиями
include 'header.php';
?>

<div class="container">
    <h2>Зарегистрироваться</h2>
    <form method="POST" action="">
        <label for="username">Имя пользователя:</label>
        <input type="text" id="username" name="username" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Подтвердите пароль:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <input type="submit" name="register_submit" value="Зарегистрироваться">
    </form>

    <?php
    // Выводим ошибки регистрации
    if (isset($error_message)) {
        echo "<p class='error-message'>$error_message</p>";
    }
    ?>

    <div class="register-link">
        <h3>Уже зарегистрированы?<br>
        <a href="vhod.php">Войти в аккаунт</a></h3>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
