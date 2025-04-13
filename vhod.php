<?php
session_start();

$link = mysqli_connect('localhost', 'root', '', 'shoes');
if (!$link) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_submit'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $message = "Пожалуйста, заполните все поля.";
    } else {

        $query = "SELECT * FROM users WHERE email = ? AND password = ?";
        $stmt = mysqli_prepare($link, $query);
        mysqli_stmt_bind_param($stmt, "ss", $email, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['is_admin'] = $row['is_admin'];

            if ($row['is_admin'] == 1) {
                header("Location: adminka_1.php");
            } else {
                header("Location: kabinet.php");
            }
            exit();
        } else {
            $message = "Неверный email или пароль.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
	<title>Вход</title>
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
                input[type="email"],
        input[type="password"],
        input[type="submit"] {
            width: 95%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #acdea6;
            outline: none;
        }

        input[type="submit"] {
            background-color: #acdea6;
            color: black;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
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
        <?php include 'header.php'; ?><br><br>
<div class="container">


        <h2>Вход в аккаунт</h2>

        <form method="POST" action="">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" name="login_submit" value="Войти">
        </form>

        <?php if (!empty($message)) { ?>
            <p class="error-message"><?php echo htmlspecialchars($message); ?></p>
        <?php } ?>

        <div class="register-link">
            <h3>Не зарегистрированы?<br>
            <a href="registr.php">Зарегистрироваться</a></h3>
        </div>

</div><br><br><br><br><br><br><br><br><br><br><br><br>
    <?php include 'footer.php'; ?>
</body>
</html>