<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
        }

        .slider-container {
            width: 100%;
            overflow: hidden;
            position: relative;
            margin: 0 auto;
        }

        .slider {
            display: flex;
            transition: transform 0.5s ease;
        }

        .slide {
            min-width: 100%;
            box-sizing: border-box;
        }

        .slide img {
            width: 100%;
            height: auto;
            display: block;
        }

        .slider-buttons {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
        }

        .slider-button {
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            font-size: 18px;
        }

        .slider-button:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }

        .container {
            width: 80%;
            margin: 30px auto;
        }

        .ab_1 {
            margin: 20px 0; /* Уменьшен отступ сверху и снизу */
            text-align: center;
        }

        .menu_2 {
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            margin: 20px 0; /* Уменьшен отступ между элементами */
        }

        .menu_ph {
            width: 120px;
        }

        .menu_21 {
            display: flex;
            flex-direction: column;
            text-align: center;
            align-items: center;
        }

        .but_menu {
            border: 1px solid #acdea6;
            font-size: 12px;
            border-radius: 30px;
            background-color: #acdea6;
            color: black;
            width: 160px;
        }

        .but_menu:hover {
            background-color: #b3e4a0;
        }

        @media (max-width: 768px) {
            .menu_2 {
                flex-direction: column;
                align-items: center;
                gap: 20px; /* Уменьшен разрыв между элементами */
            }
        }

        @media (max-width: 320px) {
            .menu_ph {
                width: 30%;
            }
        }
          @media (max-width: 320px) {
          	.menu_21{
          		display: flex;
          		align-items: center;

          	}
    </style>
</head>
<body>
    <?php include 'header.php'; ?>


    <!-- Контент -->
    <div class="container">

    <!-- Слайдер -->
    <div class="slider-container">
        <div class="slider">
            <div class="slide">
                <img src="img/puma_rekl.jpg" alt="Puma Advertisement">
            </div>
            <div class="slide">
                <img src="img/nike_rekl.jpg" alt="Nike Advertisement">
            </div>
            <div class="slide">
                <img src="img/adidas_rekl.jpg" alt="Adidas Advertisement">
            </div>
        </div>
        <div class="slider-buttons">
            <button class="slider-button" id="prev">←</button>
            <button class="slider-button" id="next">→</button>
        </div>
    </div>
    </div>

        <div class="ab_1">
            <h1><b>каталог</b></h1>
        </div>

        <div class="menu_2">
            <div class="menu_21">
                <img class="menu_ph" src="img/puma.jpg" alt="Puma">
                <h2><b>puma</b></h2>
                <a href="puma.php">
                    <button class="but_menu">перейти</button>
                </a>
            </div>

            <div class="menu_21">
                <img class="menu_ph" src="img/adidas.png" alt="Adidas">
                <h2><b>adidas</b></h2>
                <a href="adidas.php">
                    <button class="but_menu">перейти</button>
                </a>
            </div>

            <div class="menu_21">
                <img class="menu_ph" src="img/nike.jpg" alt="Nike">
                <h2><b>nike</b></h2>
                <a href="nike.php">
                    <button class="but_menu">перейти</button>
                </a>
            </div>
        </div>




    <?php include 'footer.php'; ?>

    <script>
        const slider = document.querySelector('.slider');
        const slides = document.querySelectorAll('.slide');
        const prev = document.getElementById('prev');
        const next = document.getElementById('next');
        let index = 0;

        function showSlide(idx) {
            slider.style.transform = `translateX(-${idx * 100}%)`;
        }

        prev.addEventListener('click', () => {
            index = (index - 1 + slides.length) % slides.length;
            showSlide(index);
        });

        next.addEventListener('click', () => {
            index = (index + 1) % slides.length;
            showSlide(index);
        });
    </script>
</body>
</html>
