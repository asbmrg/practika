<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Главная страница</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
	<style>
    .container {
        width: 80%;
        margin: 0 auto;
            margin-top: 30px;
            margin-bottom: 30px;
    }
           .h1_main {
            font-size: 75px;
        }
        .but_1 {
            border: 1px solid #acdea6;
            font-size: 36px;
            background-color: #acdea6;
            border-radius: 15px;
            width: 60%;
            height: 70px;
                    margin: 0 0 30px 0;
        }
        .but_1:hover {
            background-color: #b3e4a0;
            border: 1px solid #b3e4a0;
        }
        .first_part {
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            text-align: left;
        }
        .f_1{
        	width: 90%;
        	border-radius: 15px;
        	align-items: center;
        }
        .txt_11{
        	font-size: 20px;
        }
                .menu_21 {
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }

        .menu_2 {
            display: flex;
            flex-direction: row;
            justify-content: space-around;
        }

        .but_menu {
            border: 1px solid #acdea6 ;
            font-size: 12px;
            border-radius: 30px;
            background-color: #acdea6;
            color: black;
            width: 160px;
        }

        .but_menu:hover {
            background-color: #b3e4a0;
        }
      .menu_ph{
      	width: 120px;
      }

      .menu_21{
      	display: flex;
      	flex-direction: column;
      	display: block;
      }
              .reg {
            display: flex;
            flex-direction: column;
        }

        .reg_but {
            display: flex;
            flex-direction: row;
            justify-content: space-around;
        }

        .reg_reg {
            border: 1px solid #acdea6  ;
            font-size: 20px;
            border-radius: 30px;
            background-color: #acdea6 ;
            color: black;
            width: 380px;
            height: 86px;
        }

        .reg_reg:hover {
            background-color: #b3e4a0;
        }

        .reg_word {
            display: flex;
            justify-content: center;
            text-align: center;
        }




        @media (max-width: 768px) {
            .h1_main {
                font-size: 48px;
            }
            .but_1 {
                font-size: 24px;
                        margin: 0 0 30px 0;
            }
            .menu_2 {
                flex-direction: column;
                align-items: center;
                gap: 30px;
            }
            .menu_21 {
                width: 90%;
                display: contents;
            }
            .reg_reg {
                width: 100%;
            }
            .first_part{
                display: flex;
                flex-direction: column;
                text-align: center;
            }
            .about_us {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                padding: 20px;
            }

            .about_us_inner {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 30px;
                max-width: 1200px;
                width: 100%;
            }

            .ab_1 {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .ab_2 {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .ab_23 {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .menu_ph{
                width: 50%;
                display: flex;
                justify-content: center;
            }

            .ab_25{
                width: auto;
                max-width: 100%;
                justify-content: center;
            }
            .reg_but {
                display: flex;
                flex-direction: column;
                text-align: center;
                align-items: center;
                justify-content: center;
                width: 100%;
                gap: 30px;
            }
                  .menu_ph{
      	width: 30%;
      }
        }




        @media (max-width: 320px) {
            .f_1{
                width: 100%;
            }
            .but_1{
                width: 90%;
            }
            .ab_24{
                width: 90%;
            }
                  .menu_ph{
      	width: 30%;
      }
  }
	</style>
</head>
<body>
	<?php include 'header.php'; ?>
<div class="container">
        <div class="first_part">
            <div class="second_part">
                <h1 class="h1_main">CROSOV<br>OK</h1>
                <br><br>
                <div class='txt_11'>
                	<p class="txt_1">
                		в нашем ассортименте продукция из различных стран. мы знаем потребности рынка и какие материалы актуальны.
                	</p>
                </div>
                <br><br>
                <a href="category.php">
                    <button class="but_1">каталог</button>
                </a>
            </div>
                <div class="capY">
                <img class="f_1" src="img/magazin.png">
            </div>
        </div>

        <div class="menu">
            <div class="ab_1">
                <h1><b>каталог</b></h1>
            </div>

            <br><br><br>

            <div class="menu_2">
                <div class="menu_21">
                    <img class="menu_ph" src="img/puma.jpg">
                    <h2><b>puma</b></h2>
                    <a href="puma.php">
                        <button class="but_menu">перейти</button>
                    </a>
                </div>

                <div class="menu_21">
                    <img class="menu_ph" src="img/adidas.png">
                    <h2><b>adidas</b></h2>
                    <a href="adidas.php">
                        <button class="but_menu">перейти</button>
                    </a>
                </div>

                <div class="menu_21">
                    <img class="menu_ph" src="img/nike.jpg">
                    <h2><b>nike</b></h2>
                    <a href="nike.php">
                        <button class="but_menu">перейти</button>
                    </a>
                </div>
            </div>
        </div>
        <br><br><br>
<div class="reg">
            <h2 class="reg_word">для оформления заказа необходимо авторизироваться</h2>
            <br><br>
            <div class="reg_but">
                <a href="vhod.php"><button class="reg_reg">войти</button></a>
                <a href="registr.php"><button class="reg_reg">зарегистрироваться</button></a>
            </div>
        </div>

        <br><br><br><br>

        <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A237298aa80774d4b029e164a6a316b0680f6fbf37d5e1c1c0a833af7725f25d5&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>
    </div>

</div>
    <?php include 'footer.php'; ?>
</body>
</html>