<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'СтройУслуги - Главная') ?></title>
    <link rel="stylesheet" href="/photoservice/i/Styles/main.css">
</head>
<body>
    <!-- Верхняя панель -->
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-left">
                <a href="#" class="top-link">О нас</a>
                <span class="top-separator">|</span>
                <a href="#" class="top-link">Наша политика</a>
                <span class="top-separator">|</span>
                <a href="#" class="top-link">Информация для заказчиков</a>
                <span class="top-separator">|</span>
                <button id="theme-toggle" class="top-link theme-btn">Темная тема</button>
            </div>
            <div class="top-bar-right">
                <button id="city-selector" class="city-btn">г. Энгельс</button>
            </div>
        </div>
    </div>

    <!-- Шапка -->
    <header class="main-header">
        <div class="container">
            <div class="header-content">
                <div class="header-left">
                    <a href="/admin/" class="admin-btn" title="Только для сотрудников">Админ панель</a>
                </div>
                <a href="/" class="logo">Строй<span>Услуги</span></a>
                <nav class="main-nav">
                    <ul>
                        <li><a href="/pages/user/services.php">Каталог</a></li>
                        <li><a href="/pages/user/cart.php" class="cart-btn">Подбор услуг</a></li>
                        <li><a href="#about">О компании</a></li>
                    </ul>
                </nav>
                <button class="cta-button" onclick="location.href='/pages/user/request.php'">Оставить заявку</button>
            </div>
        </div>
    </header>

    <main>
