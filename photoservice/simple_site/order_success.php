<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказ оформлен - СтройСервис</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="logo">Строй<span>Сервис</span></div>
            <nav class="nav">
                <a href="index.php">Главная</a>
                <a href="catalog.php">Каталог</a>
                <a href="cart.php">Корзина</a>
                <a href="admin/login.php">Админка</a>
            </nav>
        </div>
    </header>

    <main class="main">
        <div class="container">
            <div class="alert alert-success">
                <h1>✓ Заказ успешно оформлен!</h1>
                <p>Спасибо за ваш заказ. Наш менеджер свяжется с вами в ближайшее время.</p>
                <a href="catalog.php" class="btn">Вернуться в каталог</a>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 СтройСервис. Все права защищены.</p>
        </div>
    </footer>
</body>
</html>
