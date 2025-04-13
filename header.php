<header>
    <style>
        /* Общие стили */
        html, body {
            margin: 0 auto;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: 'Montserrat', sans-serif;
        }

        header {
            background-color: white;
            height: 70px;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 10;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .head_1 {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 0 20px;
        }

        .h_1 {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .h_1 .logo {
            height: 50px;
        }

        .h_2 {
            display: flex;
            gap: 20px;
        }

        .h_2 a {
            text-decoration: none;
            color: black;
            font-weight: bold;
        }

        .h_2 a:hover {
            color: #5D3919;
        }

        .h_3 {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .h_3 img {
            height: 40px;
        }

        .menu-toggle {
            display: none;
            cursor: pointer;
            font-size: 24px;
            background: none;
            border: none;
            color: black;
        }

        .mobile-menu {
            display: none;
            flex-direction: column;
            background-color: white;
            position: absolute;
            top: 70px;
            left: 0;
            width: 100%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
        }

        .mobile-menu a {
            padding: 10px 20px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        .mobile-menu img {
            height: 25px;
        }

        /* Адаптация для мобильных устройств */
        @media screen and (max-width: 768px) {
            .h_2 {
                display: none;
            }

            .menu-toggle {
                display: block;
            }

            .mobile-menu.open {
                display: flex;
            }

            .head_1 {
                justify-content: space-between;
                padding: 0 20px;
            }

            .h_1 p {
                display: none;
            }
        }
    </style>

    <nav class="head_1">
        <!-- Логотип -->
        <div class="h_1">
            <a href="index.php">
                <img class="logo" src="img/logo.PNG" alt="Логотип">
            </a>
        </div>

        <div class="h_2">
            <a href="category.php">Каталог</a>
            <a href="contact.php">Контакты</a>
        </div>

        <div class="h_3">
            <a href="kabinet.php">
                <img src="img/kabinett.png" alt="Личный кабинет">
            </a>

            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="cart.php">
                    <img class="kabinet" src="img/korz.png">
                </a>
            <?php endif; ?>
        </div>

        <button class="menu-toggle" onclick="toggleMenu()">☰</button>
    </nav>

    <div class="mobile-menu">
            <a href="category.php">Каталог</a>
            <a href="contact.php">Контакты</a>
    </div>

    <script>
        function toggleMenu() {
            const menu = document.querySelector('.mobile-menu');
            menu.classList.toggle('open');
        }
    </script>
</header>
