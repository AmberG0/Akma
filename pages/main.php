<? require_once '../inc/functions.php'; 

if (isset($_POST['add_to_cart'])) {
    $id = (int)($_POST['product_id'] ?? 0);
    if ($id > 0) {
        add_to_cart($id);
    }
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/style.css">
    <title>Главная страница</title>
    <style>
        .hero-section {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
        }
        .hero-slider {
            flex: 2;
            background: #FFD700;
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
            background: #1A1A1A;
        }
        .hero-description {
            flex: 1;
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
            color: #FFD700;
        }
        .hero-description p {
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .central-block {
            background: #f5f5f5;
            padding: 60px 40px;
            border-radius: var(--radius-big);
            text-align: center;
            margin-bottom: 40px;
        }
        .central-block h2 {
            font-size: 32px;
            color: #1A1A1A;
            margin-bottom: 20px;
        }
        .central-block p {
            font-size: 18px;
            color: #666;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.8;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
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
            color: #FFD700;
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
            color: #FFD700;
        }
        .footer-grid p {
            margin-bottom: 10px;
            line-height: 1.6;
        }
        .calendar-widget {
            background: white;
            color: #1A1A1A;
            padding: 20px;
            border-radius: var(--radius-small);
            margin-top: 20px;
        }
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .calendar-header h4 {
            margin: 0;
            font-size: 16px;
        }
        .calendar-nav {
            display: flex;
            gap: 10px;
        }
        .calendar-nav button {
            background: #FFD700;
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .calendar-current-date {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .calendar-current-date img {
            width: 16px;
            height: 16px;
            cursor: pointer;
        }
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            text-align: center;
        }
        .calendar-weekday {
            font-size: 12px;
            color: #999;
            padding: 5px;
        }
        .calendar-day {
            padding: 8px;
            font-size: 14px;
            border-radius: 5px;
        }
        .calendar-day.today {
            background: #FFD700;
            color: #1A1A1A;
            font-weight: bold;
        }
        .calendar-day.other-month {
            color: #ccc;
        }
        @media (max-width: 768px) {
            .hero-section {
                flex-direction: column;
            }
            .footer-grid {
                grid-template-columns: 1fr;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <? include("../blocks/modal.php"); ?>
    
    <div id="main_container">
        <? include("../blocks/header.php"); ?>
        
        <div class="hero-section">
            <div class="hero-slider">
                <img src="../uploads/hero1.jpg" alt="" class="hero-slide active">
                <img src="../uploads/hero2.jpg" alt="" class="hero-slide">
                <img src="../uploads/hero3.jpg" alt="" class="hero-slide">
                <div class="slider-nav">
                    <span class="slider-dot active" data-slide="0"></span>
                    <span class="slider-dot" data-slide="1"></span>
                    <span class="slider-dot" data-slide="2"></span>
                </div>
            </div>
            <div class="hero-description">
                <h2 id="slide-title">Строительные материалы</h2>
                <p id="slide-text">Широкий ассортимент стройматериалов для профессионалов и частных клиентов. Доставка по всей России.</p>
            </div>
        </div>
        
        <div class="central-block">
            <h2>О компании</h2>
            <p>Мы работаем на рынке строительных материалов более 10 лет. Наша миссия — предоставлять качественные материалы по доступным ценам с отличным сервисом.</p>
        </div>
        
        <div id="main_categories">
            <h1>Каталог</h1>
            <div id="set_categories">
                <a href="catalog.php?cat=flanec" class="card_categories">
                    <img src="../image/flange.png" alt="">
                    <h1>ФЛАНЦЫ</h1>
                    <p>300 товаров</p>
                </a>
                <a href="catalog.php?cat=truby" class="card_categories">
                    <img src="../uploads/pipe.png" alt="">
                    <h1>ТРУБЫ</h1>
                    <p>150 товаров</p>
                </a>
                <a href="catalog.php?cat=otvody" class="card_categories">
                    <img src="../image/flange.png" alt="">
                    <h1>ОТВОДЫ</h1>
                    <p>80 товаров</p>
                </a>
            </div>
        </div>
        
        <div id="main_product">
            <? $stmt = $pdo->query("SELECT id, name, price, image FROM products ORDER BY id DESC LIMIT 6");
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
            <? endwhile; ?>
        </div>
        
        <footer class="footer-grid">
            <div>
                <img src="../image/logo.png" alt="">
                <p>СтройМастер — ваш надежный партнер в строительстве.</p>
            </div>
            <div>
                <h3>Доп ссылки</h3>
                <a href="terms_of_service.php">Условия сервиса</a>
                <a href="maps.php">Пункты выдачи</a>
                <a href="faq.php">FAQ</a>
                <a href="about.php">О компании</a>
            </div>
            <div>
                <h3>Наш точный адрес</h3>
                <p>г. Москва, ул. Строителей, д. 15</p>
                <p>ИНН 1234567890</p>
            </div>
            <div>
                <h3>Часы работы</h3>
                <p>Пн-Пт: 9:00 - 18:00</p>
                <p>Сб: 10:00 - 16:00</p>
                <p>Вс: выходной</p>
                
                <div class="calendar-widget">
                    <div class="calendar-header">
                        <h4 id="calendar-month-year">August 2025</h4>
                        <div class="calendar-nav">
                            <button id="prev-month">&lt;</button>
                            <button id="next-month">&gt;</button>
                        </div>
                    </div>
                    <div class="calendar-current-date">
                        <span id="current-date-display">Mon, Aug 17</span>
                        <img src="../image/edit.png" alt="">
                    </div>
                    <div class="calendar-grid">
                        <div class="calendar-weekday">S</div>
                        <div class="calendar-weekday">M</div>
                        <div class="calendar-weekday">T</div>
                        <div class="calendar-weekday">W</div>
                        <div class="calendar-weekday">T</div>
                        <div class="calendar-weekday">F</div>
                        <div class="calendar-weekday">S</div>
                    </div>
                    <div class="calendar-grid" id="calendar-days"></div>
                </div>
            </div>
        </footer>
    </div>
    
    <script src="../js/modal.js"></script>
    <script>
        const slides = document.querySelectorAll('.hero-slide');
        const dots = document.querySelectorAll('.slider-dot');
        const slideTitle = document.getElementById('slide-title');
        const slideText = document.getElementById('slide-text');
        
        const slideData = [
            { title: 'Строительные материалы', text: 'Широкий ассортимент стройматериалов для профессионалов и частных клиентов. Доставка по всей России.' },
            { title: 'Профессиональные инструменты', text: 'Инструменты от ведущих производителей для любых задач.' },
            { title: 'Оборудование для строительства', text: 'Современное оборудование по доступным ценам.' }
        ];
        
        let currentSlide = 0;
        
        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
            });
            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });
            slideTitle.textContent = slideData[index].title;
            slideText.textContent = slideData[index].text;
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
        
        const calendarDays = document.getElementById('calendar-days');
        const calendarMonthYear = document.getElementById('calendar-month-year');
        const currentDateDisplay = document.getElementById('current-date-display');
        const prevMonthBtn = document.getElementById('prev-month');
        const nextMonthBtn = document.getElementById('next-month');
        
        let currentMonth = 7;
        let currentYear = 2025;
        
        function renderCalendar(month, year) {
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 
                               'July', 'August', 'September', 'October', 'November', 'December'];
            
            calendarMonthYear.textContent = `${monthNames[month]} ${year}`;
            
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const daysInPrevMonth = new Date(year, month, 0).getDate();
            
            let html = '';
            
            for (let i = firstDay - 1; i >= 0; i--) {
                html += `<div class="calendar-day other-month">${daysInPrevMonth - i}</div>`;
            }
            
            const today = new Date();
            for (let day = 1; day <= daysInMonth; day++) {
                const isToday = day === today.getDate() && month === today.getMonth() && year === today.getFullYear();
                html += `<div class="calendar-day${isToday ? ' today' : ''}">${day}</div>`;
            }
            
            const remainingCells = 42 - (firstDay + daysInMonth);
            for (let day = 1; day <= remainingCells; day++) {
                html += `<div class="calendar-day other-month">${day}</div>`;
            }
            
            calendarDays.innerHTML = html;
        }
        
        const now = new Date();
        const dateOptions = { weekday: 'short', month: 'short', day: 'numeric' };
        currentDateDisplay.textContent = now.toLocaleDateString('en-US', dateOptions);
        
        renderCalendar(currentMonth, currentYear);
        
        prevMonthBtn.addEventListener('click', () => {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar(currentMonth, currentYear);
        });
        
        nextMonthBtn.addEventListener('click', () => {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar(currentMonth, currentYear);
        });
    </script>
</body>
</html>