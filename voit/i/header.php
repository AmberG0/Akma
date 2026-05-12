<?php
require("WebsiteBackend/database.php");
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>VoteUP</title>
        <link rel="icon" type="image/png" href="Images/logo_square.png"/>
        <link rel="stylesheet" href="Styles/reset.css">
        <link rel="stylesheet" href="Styles/light_mode.css">
    </head>
    <header class="navigation">
        <div class="logo_container">
            <a href="index.php"><img class="logo" src="Images/logo_variant.png" alt="Site Logo"></a>
        </div>

        <div class="search_container">
            <form id="search_form" method="POST"> <!-- Добавлен id и метод -->
                <input class="search_input" id="search_input" type='search' placeholder="Поиск по сайту" name='search_input'>
                <button class="search_button" id="search_btn" type="button">🔎</button> <!-- type="button" чтобы форма не отправлялась -->
            </form>
            <?php
                if ($_SESSION) {
                    ?><button class="post_button" onclick="location.href='post.php'">Создать опрос</button><?php
                }
            ?>
        </div>
        
        <div class="auth_container">
            <?php
                if ($_SESSION) {
                    ?><button class="auth_button" id="register" onclick="location.href='account.php'"><?php print($_SESSION['username'])?></button>
                    <button class="auth_button" id="login" onclick="location.href='WebsiteBackend/terminate.php'">Выйти</button><?php
                } else {
                    ?><button class="auth_button" id="register" onclick="location.href='register.php'">Регистрация</button>
                    <button class="auth_button" id="login" onclick="location.href='login.php'">Войти</button><?php
                }
            ?>
        </div>
    </header>
</html>