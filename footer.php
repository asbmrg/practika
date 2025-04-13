<footer>
    <style>
        /* Сброс базовых стилей */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        html, body {
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            padding-top: 70px;
        }

        footer {
            background-color: white;
            height: 150px;
            width: 100%;
            margin-top: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1); /* Тень сверху */
        }

        .footer_1 {
            display: flex; /* Выравнивание содержимого */
            justify-content: space-around; /* Равномерное распределение элементов */
            align-items: center; /* Центрирование по вертикали */
            width: 100%; /* Полная ширина для внутренних элементов */
            max-width: 1200px; /* Ограничение ширины контента для читабельности */
        }

        .h_1 {
            display: flex;
            align-items: center;
        }

        .h_1 .logo {
            height: 50px; /* Размер логотипа */
            margin-right: 10px;
        }

        .h_1 p {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin: 0;
        }

        .h_2 a {
            text-decoration: none;
            color: black;
            font-size: 16px;
            margin: 0 10px;
        }

        .h_2 a:hover {
            color: #5D3919;
        }

        .h_3 a img.kabinet {
            height: 30px;
            margin: 0 5px;
            cursor: pointer;
        }

        @media screen and (max-width: 768px) {
            footer {
                height: auto;
                padding: 10px 20px;
                width: 100%;
            }

            .footer_1 {
                flex-direction: column;
                align-items: center;
            }

            .h_2 {
                margin: 10px 0;
            }
        }
    </style>

    <nav class="footer_1">
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
            <a href="https://vk.com/feed">
                <img class="kabinet" src="img/vk.png">
            </a>
            <a href="https://www.whatsapp.com/">
                <img class="kabinet" src="img/whatsapp.png">
            </a>
        </div>
    </nav>
</footer>
