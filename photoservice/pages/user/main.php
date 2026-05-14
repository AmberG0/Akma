<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>СтройУслуги - ИП Барабарян Карен Аветики</title>
    <link rel="stylesheet" href="../../i/Styles/main.css">
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="top-links">
                <a href="#">О нас</a>
                <a href="#">Наша политика</a>
                <a href="#">Информация для заказчиков</a>
                <a href="#" id="theme-toggle">Темная тема</a>
            </div>
            <span class="city-selector" id="city-selector">г.Энгельс</span>
        </div>
    </div>
    
    <!-- Header -->
    <header>
        <div class="container">
            <div class="header-content">
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <a href="../admin/dashboard.php" class="admin-link">Админ панель</a>
                <?php endif; ?>
                <a href="#" class="logo">Строй<span>Услуги</span></a>
                <nav>
                    <ul>
                        <li><a href="#">Каталог услуг</a></li>
                        <li><a href="#">Наши проекты</a></li>
                        <li><a href="#">Отзывы</a></li>
                    </ul>
                </nav>
                <button class="cta-button" onclick="openOrderForm()">Оставить заявку</button>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-slider" id="hero-slider">
                    <div class="slider-image active"></div>
                    <div class="slider-indicators" id="slider-indicators"></div>
                </div>
                <div class="hero-description">
                    <h2 id="hero-desc-text">Профессиональные строительные услуги</h2>
                    <p>ИП Барабарян Карен Аветики предлагает полный спектр строительных работ: от ремонта квартир до возведения зданий под ключ.</p>
                    <button class="cta-button" onclick="openOrderForm()">Рассчитать стоимость</button>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about">
        <div class="container">
            <h2>О компании</h2>
            <div class="about-content">
                <p>ИП Барабарян Карен Аветики — надежный партнер в сфере строительства в городе Энгельс. Мы работаем на рынке строительных услуг более 10 лет, выполняя проекты любой сложности: от косметического ремонта до промышленного строительства. Наша команда состоит из квалифицированных специалистов, использующих современные технологии и материалы.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <div class="footer-logo">Строй<span>Услуги</span></div>
                    <p style="margin-top: 10px; font-size: 14px;">ИП Барабарян Карен Аветики</p>
                </div>
                <div class="footer-column">
                    <h4>Доп ссылки</h4>
                    <ul class="footer-links">
                        <li><a href="#">О компании</a></li>
                        <li><a href="#">Услуги</a></li>
                        <li><a href="#">Портфолио</a></li>
                        <li><a href="#">Контакты</a></li>
                        <li><a href="#">Политика конфиденциальности</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Наш точный адрес</h4>
                    <p class="address">г.Энгельс, Саратовская область<br>ул. Строителей, д. 25</p>
                </div>
                <div class="footer-column">
                    <h4>Часы работы</h4>
                    <p class="hours">Пн-Пт: 8:00 - 20:00<br>Сб: 9:00 - 17:00<br>Вс: выходной</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="../../i/Scripts/main.js"></script>
</body>
</html>
