<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? SITE_NAME ?></title>
    <link rel="stylesheet" href="i/Styles/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="container header-container">
            <div class="logo">
                <span class="logo-text"><?= SITE_NAME ?></span>
            </div>
            <nav class="nav">
                <a href="#hero" class="nav-link">Главная</a>
                <a href="#stats" class="nav-link">Статистика</a>
                <a href="#features" class="nav-link">Преимущества</a>
                <a href="#demo" class="nav-link">Демо</a>
                <a href="#subscribe" class="nav-link">Контакты</a>
            </nav>
            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>
