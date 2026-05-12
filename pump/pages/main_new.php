<?php 
require_once '../inc/functions.php'; 
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/style.css">
    <title>ТД Синергия — Главная</title>
    <style>
        /* Стили для новой главной страницы */
        
        /* Hero секция со слайдером */
        .hero-section {
            max-width: var(--max-width);
            margin: 40px auto;
            padding: 0 20px;
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }
        
        .slider-container {
            flex: 2;
            min-width: 300px;
            height: 400px;
            background: white;
            border-radius: var(--radius-big);
            overflow: hidden;
            position: relative;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        .slider-wrapper {
            display: flex;
            transition: transform 0.5s ease;
            height: 100%;
        }
        
        .slide {
            min-width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #007BFF 0%, #0056b3 100%);
            color: white;
            font-size: 48px;
            font-weight: bold;
        }
        
        .slider-controls {
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
            transition: background 0.3s;
        }
        
        .slider-dot.active {
            background: white;
        }
        
        .slider-description {
            flex: 1;
            min-width: 300px;
            height: 400px;
            background: white;
            border-radius: var(--radius-big);
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        .slider-description h2 {
            font-size: 32px;
            margin-bottom: 20px;
            color: #333;
        }
        
        .slider-description p {
            font-size: 18px;
            line-height: 1.6;
            color: #666;
            margin-bottom: 30px;
        }
        
        .slider-btn {
            padding: 16px 40px;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            width: fit-content;
            transition: background 0.3s;
        }
        
        .slider-btn:hover {
            background: #0056b3;
        }
        
        /* Центральный блок "О компании" */
        .about-section {
            max-width: var(--max-width);
            margin: 60px auto;
            padding: 0 20px;
        }
        
        .about-block {
            background: white;
            border-radius: var(--radius-big);
            padding: 60px 40px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        .about-block h2 {
            font-size: 36px;
            margin-bottom: 30px;
            color: #333;
        }
        
        .about-block p {
            font-size: 18px;
            line-height: 1.8;
            color: #666;
            max-width: 800px;
            margin: 0 auto;
        }
        
        /* Футер с календарём */
        #container_footer {
            flex-wrap: wrap;
            height: auto;
            padding: 40px 60px;
            gap: 40px;
        }
        
        .footer-columns {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            flex: 1;
        }
        
        .footer-column {
            flex: 1;
            min-width: 200px;
        }
        
        .footer-column h4 {
            font-size: 18px;
            margin-bottom: 20px;
            color: #333;
        }
        
        .footer-column a {
            display: block;
            margin-bottom: 12px;
            color: #666;
            text-decoration: none;
            font-size: 16px;
        }
        
        .footer-column a:hover {
            color: #007BFF;
        }
        
        .calendar-widget {
            background: #f8f9fa;
            border-radius: 16px;
            padding: 20px;
            margin-top: 20px;
        }
        
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .calendar-nav {
            display: flex;
            gap: 10px;
        }
        
        .calendar-nav button {
            width: 32px;
            height: 32px;
            border: none;
            background: #007BFF;
            color: white;
            border-radius: 50%;
            cursor: pointer;
            font-size: 16px;
        }
        
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            text-align: center;
        }
        
        .calendar-grid .day-name {
            font-size: 12px;
            color: #999;
            padding: 5px;
        }
        
        .calendar-grid .day {
            padding: 8px;
            font-size: 14px;
            border-radius: 8px;
        }
        
        .calendar-grid .day.today {
            background: #007BFF;
            color: white;
            font-weight: bold;
        }
        
        .calendar-grid .day.other-month {
            color: #ccc;
        }
        
        .current-date-display {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            font-size: 16px;
            color: #333;
        }
        
        .edit-icon {
            cursor: pointer;
            opacity: 0.6;
            transition: opacity 0.3s;
        }
        
        .edit-icon:hover {
            opacity: 1;
        }
        
        /* Адаптив */
        @media (max-width: 768px) {
            .hero-section {
                flex-direction: column;
            }
            
            .slider-container,
            .slider-description {
                height: 300px;
            }
            
            #container_footer {
                flex-direction: column;
                padding: 30px 20px;
            }
            
            .footer-columns {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <?php include("../blocks/modal.php"); ?>

    <div id="main_container">
        <!-- Шапка -->
        <?php include("../blocks/header.php"); ?>

        <!-- Hero секция со слайдером -->
        <section class="hero-section">
            <div class="slider-container">
                <div class="slider-wrapper" id="sliderWrapper">
                    <div class="slide">1</div>
                    <div class="slide">2</div>
                    <div class="slide">3</div>
                </div>
                <div class="slider-controls">
                    <span class="slider-dot active" data-slide="0"></span>
                    <span class="slider-dot" data-slide="1"></span>
                    <span class="slider-dot" data-slide="2"></span>
                </div>
            </div>
            
            <div class="slider-description" id="sliderDescription">
                <h2>Фланцы стальные</h2>
                <p>Высококачественные фланцы от производителя. Соответствуют ГОСТ. Доставка по всей России.</p>
                <button class="slider-btn">В каталог</button>
            </div>
        </section>

        <!-- Преимущества -->
        <div id="main_content">
            <div class="pluses">
                <img src="../image/truck.png" alt="Доставка">
                <h1>Доставка по России</h1>
                <p>ТК, курьером в любой уголок страны</p>
            </div>
            <div class="pluses">
                <img src="../image/shield.png" alt="Гарантия">
                <h1>Гарантия качества</h1>
                <p>Сертификаты на весь ассортимент</p>
            </div>
            <div class="pluses">
                <img src="../image/tags.png" alt="Цены">
                <h1>Хорошие цены</h1>
                <p>Скидки постоянным клиентам</p>
            </div>
        </div>

        <!-- Центральный блок "О компании" -->
        <section class="about-section">
            <div class="about-block">
                <h2>О компании ТД Синергия</h2>
                <p>Мы работаем на рынке металлопроката более 10 лет. Наша миссия — обеспечивать клиентов качественной продукцией по доступным ценам. Собственный склад, оперативная доставка и профессиональная консультация — наши главные преимущества.</p>
            </div>
        </section>

        <!-- Категории -->
        <div id="main_categories">
            <h1>Каталог</h1>
            <div id="set_categories">
                <a href="catalog.php?cat=flanec" class="card_categories">
                    <img src="../image/flange.png" alt="Фланцы">
                    <h1>ФЛАНЦЫ</h1>
                    <p>300 товаров</p>
                </a>
                <a href="catalog.php?cat=truby" class="card_categories">
                    <img src="../uploads/pipe.png" alt="Трубы">
                    <h1>ТРУБЫ</h1>
                    <p>150 товаров</p>
                </a>
                <a href="catalog.php?cat=otvody" class="card_categories">
                    <img src="../image/flange.png" alt="Отводы">
                    <h1>ОТВОДЫ</h1>
                    <p>80 товаров</p>
                </a>
            </div>
        </div>

        <!-- Популярные товары -->
        <div id="main_product">
        <?php
        $stmt = $pdo->query("SELECT id, name, price, image FROM products ORDER BY id DESC LIMIT 6");
        while ($p = $stmt->fetch()): ?>
            
                <form method="POST" class="card_product">
                    
                        <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                        <div class="product_first">
                            <a href="product.php?id=<?= $p['id']?>">
                            <img src="../uploads/<?= $p['image'] ?: 'no-photo.jpg' ?>" alt="<?= escape($p['name']) ?>">
                            </a> 
                        </div>
                        <div class="product_second">
                            <p><?= escape($p['name']) ?></p>
                        </div>
                        <div class="product_last">
                            <div class="rating">
                                <img src="../image/star.svg" alt="">
                                <h1>4.7</h1>
                            </div>
                            <h1><?= number_format($p['price'], 0, '', ' ') ?> ₽</h1>
                        </div>
                        <button type="submit" name="add_to_cart" class="add_to_cart_btn">
                            В корзину
                        </button>
                    
                </form> 
       
        <?php endwhile; ?>
    </div>

        <!-- Добавление в корзину -->
        <?php
        if (isset($_POST['add_to_cart'])) {
            $id = (int)($_POST['product_id'] ?? 0);
            if ($id > 0) {
                add_to_cart($id);
            }
        }
        ?>

        <!-- Подвал с календарём -->
        <footer id="container_footer">
            <img src="../image/logo.png" alt="Logo">
            
            <div class="footer-columns">
                <div class="footer-column">
                    <h4>Навигация</h4>
                    <a href="catalog.php">Каталог</a>
                    <a href="about.php">О компании</a>
                    <a href="contacts.php">Контакты</a>
                </div>
                
                <div class="footer-column">
                    <h4>Информация</h4>
                    <a href="terms_of_service.php">Условия сервиса</a>
                    <a href="maps.php">Пункты выдачи</a>
                    <a href="faq.php">FAQ</a>
                </div>
                
                <div class="footer-column">
                    <h4>Наш адрес</h4>
                    <p style="color: #666; font-size: 16px;">г. Москва, ул. Примерная, д. 10</p>
                </div>
                
                <div class="footer-column">
                    <h4>Часы работы</h4>
                    <p style="color: #666; font-size: 16px;">Пн-Пт: 9:00 - 18:00</p>
                    <p style="color: #666; font-size: 16px;">Сб-Вс: Выходной</p>
                    
                    <div class="calendar-widget">
                        <div class="current-date-display">
                            <span id="currentDateText">Mon, Aug 17</span>
                            <span class="edit-icon">✏️</span>
                        </div>
                        <div class="calendar-header">
                            <div class="calendar-nav">
                                <button id="prevMonth">&lt;</button>
                                <button id="nextMonth">&gt;</button>
                            </div>
                            <span id="monthYear">August 2025</span>
                        </div>
                        <div class="calendar-grid">
                            <div class="day-name">S</div>
                            <div class="day-name">M</div>
                            <div class="day-name">T</div>
                            <div class="day-name">W</div>
                            <div class="day-name">T</div>
                            <div class="day-name">F</div>
                            <div class="day-name">S</div>
                            <!-- Дни будут заполнены JS -->
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="../js/modal.js"></script>
    <script>
        // Слайдер
        const sliderWrapper = document.getElementById('sliderWrapper');
        const dots = document.querySelectorAll('.slider-dot');
        const descriptions = [
            { title: 'Фланцы стальные', text: 'Высококачественные фланцы от производителя. Соответствуют ГОСТ. Доставка по всей России.' },
            { title: 'Трубы бесшовные', text: 'Широкий ассортимент труб для различных задач. Опт и розница.' },
            { title: 'Отводы и фитинги', text: 'Все виды отводов по низким ценам. Быстрая отгрузка.' }
        ];
        let currentSlide = 0;
        
        function updateSlider(index) {
            sliderWrapper.style.transform = `translateX(-${index * 100}%)`;
            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });
            
            const desc = document.getElementById('sliderDescription');
            desc.querySelector('h2').textContent = descriptions[index].title;
            desc.querySelector('p').textContent = descriptions[index].text;
        }
        
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentSlide = index;
                updateSlider(currentSlide);
            });
        });
        
        // Автопереключение
        setInterval(() => {
            currentSlide = (currentSlide + 1) % 3;
            updateSlider(currentSlide);
        }, 5000);
        
        // Календарь
        const monthYear = document.getElementById('monthYear');
        const currentDateText = document.getElementById('currentDateText');
        const calendarGrid = document.querySelector('.calendar-grid');
        let currentDate = new Date(2025, 7, 17); // Aug 17, 2025
        
        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 
                           'July', 'August', 'September', 'October', 'November', 'December'];
        
        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            
            monthYear.textContent = `${monthNames[month]} ${year}`;
            currentDateText.textContent = currentDate.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric' });
            
            // Очистка старых дней
            document.querySelectorAll('.calendar-grid .day').forEach(el => el.remove());
            
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const today = new Date();
            
            // Предыдущий месяц
            for (let i = 0; i < firstDay; i++) {
                const dayEl = document.createElement('div');
                dayEl.className = 'day other-month';
                dayEl.textContent = '-';
                calendarGrid.appendChild(dayEl);
            }
            
            // Текущий месяц
            for (let day = 1; day <= daysInMonth; day++) {
                const dayEl = document.createElement('div');
                dayEl.className = 'day';
                dayEl.textContent = day;
                
                if (year === today.getFullYear() && month === today.getMonth() && day === today.getDate()) {
                    dayEl.classList.add('today');
                }
                
                calendarGrid.appendChild(dayEl);
            }
        }
        
        document.getElementById('prevMonth').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });
        
        document.getElementById('nextMonth').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });
        
        document.querySelector('.edit-icon').addEventListener('click', () => {
            alert('Функция редактирования даты будет доступна в следующей версии');
        });
        
        renderCalendar();
    </script>
</body>
</html>
