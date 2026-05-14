<?php 
session_start();
require_once 'config/db.php'; 
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная — Строй сервис</title>
    <style>
        :root {
            --color-accent: #FFD700;
            --color-text: #000000;
            --color-bg: #FFFFFF;
            --color-red: #ff0000;
            --radius-big: 30px;
            --radius-small: 20px;
        }
        
        *, *::before, *::after {
            box-sizing: border-box;
        }
        
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            min-width: 320px;
        }
        
        #main_container {
            width: 100%;
            max-width: 1480px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Шапка */
        #container_header {
            width: 100%;
            max-width: 1480px;
            margin: 0 auto 30px;
            padding: 20px;
            background: white;
            box-shadow: 0 14px 22px rgba(34,60,80,0.2);
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            box-sizing: border-box;
            position: relative;
        }
        
        #container_header > a img {
            height: 70px;
            flex-shrink: 0;
        }
        
        #container_header h1 {
            margin: 0;
            font-size: clamp(20px, 4vw, 28px);
            white-space: nowrap;
            flex: 1 1 200px;
            text-align: center;
        }
        
        #container_header h1 span {
            color: var(--color-accent);
        }
        
        .menu_h {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-shrink: 0;
        }
        
        .catalog_btn {
            padding: 12px 32px;
            background: var(--color-accent);
            color: var(--color-text);
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            white-space: nowrap;
        }
        
        /* Герой-секция */
        .hero-section {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }
        
        .hero-slider {
            flex: 2;
            min-width: 300px;
            background: var(--color-accent);
            border-radius: var(--radius-small);
            overflow: hidden;
            position: relative;
            min-height: 400px;
        }
        
        .hero-slide {
            display: none;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .hero-slide.active {
            display: block;
        }
        
        .slider-nav {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
        }
        
        .slider-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255,255,255,0.5);
            cursor: pointer;
        }
        
        .slider-dot.active {
            background: var(--color-text);
        }
        
        .hero-description {
            flex: 1;
            min-width: 280px;
            background: #1A1A1A;
            color: white;
            padding: 30px;
            border-radius: var(--radius-small);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .hero-description h2 {
            font-size: 28px;
            margin-bottom: 15px;
            color: var(--color-accent);
        }
        
        .hero-description p {
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        /* Центральный блок */
        .central-block {
            background: white;
            padding: 60px 40px;
            border-radius: var(--radius-big);
            text-align: center;
            margin-bottom: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        .central-block h2 {
            font-size: 32px;
            color: var(--color-text);
            margin-bottom: 20px;
        }
        
        .central-block p {
            font-size: 18px;
            color: #666;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.8;
        }
        
        /* Категории */
        #main_categories {
            max-width: var(--max-width, 1480px);
            margin: 60px auto;
        }
        
        #main_categories h1 {
            text-align: center;
            margin-bottom: 40px;
            font-size: 32px;
        }
        
        #set_categories {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
            padding: 0 20px;
        }
        
        .card_categories {
            width: 100%;
            max-width: 400px;
            height: 364px;
            background: white;
            border-radius: 38px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 20px;
            text-decoration: none;
            color: var(--color-text);
            transition: transform 0.2s;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        .card_categories:hover {
            transform: translateY(-10px);
        }
        
        .card_categories img {
            width: 150px;
            height: 150px;
            object-fit: contain;
        }
        
        .card_categories h1 {
            font-size: 24px;
            margin: 0;
        }
        
        .card_categories p {
            color: #666;
            margin: 0;
        }
        
        /* Преимущества */
        .advantages-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin: 60px 0;
        }
        
        .advantage-card {
            background: white;
            padding: 30px;
            border-radius: var(--radius-small);
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            border-top: 4px solid var(--color-accent);
        }
        
        .advantage-card img {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
        }
        
        .advantage-card h3 {
            color: var(--color-text);
            margin-bottom: 10px;
            font-size: 20px;
        }
        
        .advantage-card p {
            color: #666;
            line-height: 1.6;
        }
        
        /* Футер */
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            padding: 40px 20px;
            background: #1A1A1A;
            color: white;
            margin-top: 60px;
            border-radius: var(--radius-big) var(--radius-big) 0 0;
        }
        
        .footer-grid img {
            height: 60px;
            margin-bottom: 20px;
        }
        
        .footer-grid h3 {
            color: var(--color-accent);
            margin-bottom: 15px;
            font-size: 18px;
        }
        
        .footer-grid a {
            color: white;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            transition: color 0.3s;
        }
        
        .footer-grid a:hover {
            color: var(--color-accent);
        }
        
        .footer-grid p {
            margin-bottom: 10px;
            line-height: 1.6;
        }
        
        @media (max-width: 768px) {
            .hero-section {
                flex-direction: column;
            }
            
            .footer-grid {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <?php include("blocks/modal.php"); ?>
    
    <div id="main_container">
        <div id="container_header">
            <a href="index.php"><img src="image/logo.png" alt="Logo"></a>
            
            <h1>«Строй<span style="color: #FFD700">сервис</span>»</h1>
            
            <div class="menu_h">
                <a href="pages/catalog.php" class="catalog_btn">Каталог услуг</a>
                <a href="pages/about.php" class="catalog_btn">О компании</a>
                <a href="pages/contacts.php" class="catalog_btn">Контакты</a>
            </div>
        </div>
        
        <div class="hero-section">
            <div class="hero-slider">
                <img src="image/hero1.jpg" onerror="this.style.display='none'; this.parentElement.style.background='#FFD700'" alt="" class="hero-slide active">
                <img src="image/hero2.jpg" onerror="this.style.display='none'" alt="" class="hero-slide">
                <img src="image/hero3.jpg" onerror="this.style.display='none'" alt="" class="hero-slide">
                <div class="slider-nav">
                    <span class="slider-dot active" data-slide="0"></span>
                    <span class="slider-dot" data-slide="1"></span>
                    <span class="slider-dot" data-slide="2"></span>
                </div>
            </div>
            <div class="hero-description">
                <h2>Профессиональные строительные услуги</h2>
                <p>ИП Барбарян Карен Аветикович — ваш надежный партнер в строительстве. Специализированные строительные услуги для физических лиц с 2007 года.</p>
            </div>
        </div>
        
        <div class="central-block">
            <h2>О компании</h2>
            <p>Мы работаем на рынке строительных услуг с 2007 года. Наша миссия — предоставлять качественные специализированные строительные услуги для физических лиц по доступным ценам с отличным сервисом.</p>
        </div>
        
        <div class="advantages-section">
            <div class="advantage-card">
                <img src="image/shield.png" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjRkZENzAwIiBzdHJva2Utd2lkdGg9IjIiPjxwYXRoIGQ9Ik0xMiAyMnM4LTQgOC0xMFY1bC04LTNsLTggM3Y3YzAgNiA4IDEwIDggMTB6Ii8+PC9zdmc+';" alt="Гарантия">
                <h3>Гарантия качества</h3>
                <p>Все работы выполняются с соблюдением технологий и норм</p>
            </div>
            <div class="advantage-card">
                <img src="image/truck.png" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjRkZENzAwIiBzdHJva2Utd2lkdGg9IjIiPjxyZWN0IHg9IjEiIHk9IjMiIHdpZHRoPSIxNSIgaGVpZ2h0PSIxMyIvPjxwb2x5Z29uIHBvaW50cz0iMTYgOCAyMCA4IDIzIDExIDIzIDEzIDE2IDEzIDE2IDgiLz48Y2lyY2xlIGN4PSI1LjUiIGN5PSIxOC41IiByPSIyLjUiLz48Y2lyY2xlIGN4PSIxOC41IiBjeT0iMTguNSIgcj0iMi41Ii8+PC9zdmc+';" alt="Сроки">
                <h3>Соблюдение сроков</h3>
                <p>Выполняем работы точно в оговоренное время</p>
            </div>
            <div class="advantage-card">
                <img src="image/person.png" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjRkZENzAwIiBzdHJva2Utd2lkdGg9IjIiPjxjaXJjbGUgY3g9IjEyIiBjeT0iOCIgcj0iNCIvPjxwYXRoIGQ9Ik0yMCAyMWgtOGMtMS42NTcgMC0zLTEuMzQzLTMtM3YtMWMwLTEuNjU3IDEuMzQzLTMgMy0zaDhjMS42NTcgMCAzIDEuMzQzIDMgM3YxYzAgMS42NTctMS4zNDMgMy0zIDN6Ii8+PC9zdmc+';" alt="Поддержка">
                <h3>Индивидуальный подход</h3>
                <p>Персональный менеджер для каждого клиента</p>
            </div>
            <div class="advantage-card">
                <img src="image/tags.png" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjRkZENzAwIiBzdHJva2Utd2lkdGg9IjIiPjxwYXRoIGQ9Ik0yMC41OSAyMi41OWwxMi0xMi0xMi0xMi0xMiAxMiAxMiAxMnoiLz48Y2lyY2xlIGN4PSIxMi41IiBjeT0iNy41IiByPSIyLjUiLz48L3N2Zz4=';" alt="Цены">
                <h3>Доступные цены</h3>
                <p>Честные цены без скрытых платежей</p>
            </div>
        </div>
        
        <div id="main_categories">
            <h1>Наши услуги</h1>
            <div id="set_categories">
                <a href="pages/catalog.php?cat=earthworks" class="card_categories">
                    <img src="image/flange.png" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjRkZENzAwIiBzdHJva2Utd2lkdGg9IjIiPjxjaXJjbGUgY3g9IjEyIiBjeT0iMTIiIHI9IjMiLz48cGF0aCBkPSJNMiAxMmgyME0xMiAydjIwIi8+PC9zdmc+';" alt="Земляные работы">
                    <h1>ЗЕМЛЯНЫЕ РАБОТЫ</h1>
                    <p>Копка траншей, планировка участка</p>
                </a>
                <a href="pages/catalog.php?cat=special" class="card_categories">
                    <img src="image/basket.png" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjRkZENzAwIiBzdHJva2Utd2lkdGg9IjIiPjxjaXJjbGUgY3g9IjkiIGN5PSIyMSIgcj0iMSIvPjxjaXJjbGUgY3g9IjIwIiBjeT0iMjEiIHI9IjEiLz48cGF0aCBkPSJNMSAxaDE4bC0yLjY4IDEzLjNhMyAzIDAgMCAxLTIuOTQgMi40Mkg2LjMzYTMgMyAwIDAgMS0yLjk0LTIuNDJMMXoiLz48L3N2Zz4=';" alt="Спецтехника">
                    <h1>СПЕЦТЕХНИКА</h1>
                    <p>Аренда трактора и другой техники</p>
                </a>
                <a href="pages/catalog.php?cat=construction" class="card_categories">
                    <img src="image/heart.png" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjRkZENzAwIiBzdHJva2Utd2lkdGg9IjIiPjxwYXRoIGQ9Ik0yMC44NCAzYTIuNSAyLjUgMCAwIDAgMy41NCAzLjU0bC0xLjM5IDEuMzlMNCAyMGwtMi0yIDE4Ljg0LTE4Ljg0eiIvPjwvc3ZnPg==';" alt="Строительство">
                    <h1>СТРОИТЕЛЬСТВО</h1>
                    <p>Возведение зданий и сооружений</p>
                </a>
            </div>
        </div>
        
        <footer class="footer-grid">
            <div>
                <img src="image/logo.png" onerror="this.style.display='none'" alt="Логотип">
                <p><strong>ИП Барбарян Карен Аветикович</strong></p>
                <p>Ваш надежный партнер в строительстве</p>
            </div>
            <div>
                <h3>Информация</h3>
                <a href="pages/about.php">О компании</a>
                <a href="pages/catalog.php">Услуги</a>
                <a href="pages/contacts.php">Контакты</a>
            </div>
            <div>
                <h3>Контакты</h3>
                <p>г. Энгельс, пр-д 1-й Студенческий, д. 2а</p>
                <p>+7 845 352-82-92</p>
                <p>Пн–Пт, 8:30–17:00</p>
            </div>
            <div>
                <h3>Реквизиты</h3>
                <p>ИНН: 644900269571</p>
                <p>ОГРНИП: 307644907400013</p>
                <p>Дата регистрации: 05.03.2007</p>
            </div>
        </footer>
    </div>
    
    <script>
        const slides = document.querySelectorAll('.hero-slide');
        const dots = document.querySelectorAll('.slider-dot');
        
        let currentSlide = 0;
        
        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
            });
            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });
        }
        
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentSlide = index;
                showSlide(currentSlide);
            });
        });
        
        setInterval(() => {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }, 5000);
    </script>
</body>
</html>
