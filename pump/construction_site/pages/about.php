<?php 
session_start();
require_once '../config/db.php'; 
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>О компании — Строй сервис</title>
    <style>
        :root {
            --color-accent: #FFD700;
            --color-text: #000000;
            --color-bg: #FFFFFF;
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
        
        /* Страница "О компании" */
        #info_page {
            margin: 40px auto;
            max-width: 1200px;
        }
        
        .info_title {
            font-size: 42px;
            text-align: center;
            margin-bottom: 50px;
            color: var(--color-text);
        }
        
        .info_content {
            display: flex;
            flex-direction: column;
            gap: 40px;
        }
        
        .info_block {
            background: white;
            padding: 40px;
            border-radius: var(--radius-big);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        .info_block img {
            width: 120px;
            height: 120px;
            margin-bottom: 20px;
            object-fit: contain;
        }
        
        .info_block h2 {
            font-size: 28px;
            color: var(--color-text);
            margin-bottom: 20px;
        }
        
        .info_block p {
            font-size: 18px;
            color: #666;
            line-height: 1.8;
        }
        
        .info_stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            margin: 20px 0;
        }
        
        .stat_item {
            background: white;
            padding: 30px;
            border-radius: var(--radius-small);
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            border-top: 4px solid var(--color-accent);
        }
        
        .stat-item h3 {
            font-size: 42px;
            color: var(--color-accent);
            margin: 0;
        }
        
        .stat_item h3 {
            font-size: 42px;
            color: var(--color-accent);
            margin: 0 0 10px 0;
        }
        
        .stat_item p {
            margin: 0;
            color: #666;
            font-size: 16px;
        }
        
        .info_advantages {
            margin: 40px 0;
        }
        
        .info_advantages h2 {
            font-size: 32px;
            text-align: center;
            margin-bottom: 40px;
        }
        
        .advantages_grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }
        
        .advantage_card {
            background: white;
            padding: 30px;
            border-radius: var(--radius-small);
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            border-top: 4px solid var(--color-accent);
        }
        
        .advantage_card img {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
        }
        
        .advantage_card h3 {
            color: var(--color-text);
            margin-bottom: 10px;
            font-size: 20px;
        }
        
        .advantage_card p {
            color: #666;
            line-height: 1.6;
        }
        
        .certificates_grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .certificate_item {
            background: #f9f9f9;
            padding: 30px;
            border-radius: var(--radius-small);
            text-align: center;
            border: 2px dashed var(--color-accent);
        }
        
        .cert_placeholder {
            color: #999;
            font-size: 16px;
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
            .footer-grid {
                text-align: center;
            }
            
            .info_title {
                font-size: 32px;
            }
        }
    </style>
</head>
<body>
    <?php include("../blocks/modal.php"); ?>
    
    <div id="main_container">
        <div id="container_header">
            <a href="../index.php"><img src="../image/logo.png" alt="Logo"></a>
            
            <h1>«Строй<span style="color: #FFD700">сервис</span>»</h1>
            
            <div class="menu_h">
                <a href="catalog.php" class="catalog_btn">Каталог услуг</a>
                <a href="about.php" class="catalog_btn">О компании</a>
                <a href="contacts.php" class="catalog_btn">Контакты</a>
            </div>
        </div>
        
        <section id="info_page">
            <h1 class="info_title">О компании</h1>
            
            <div class="info_content">
                <div class="info_block">
                    <img src="../image/logo.png" onerror="this.style.display='none'" alt="Логотип Строй сервис">
                    <h2>ИП Барбарян Карен Аветикович — ваш надёжный партнёр</h2>
                    <p>Компания «Строй сервис» работает на рынке строительных услуг с 2007 года. За это время мы зарекомендовали себя как надёжный исполнитель специализированных строительных работ для физических лиц по всей Саратовской области.</p>
                    <p>Наш адрес: 413124, Саратовская обл., г. Энгельс, пр-д 1-й Студенческий, д. 2а</p>
                </div>

                <div class="info_stats">
                    <div class="stat_item">
                        <h3>17+</h3>
                        <p>лет на рынке</p>
                    </div>
                    <div class="stat_item">
                        <h3>500+</h3>
                        <p>выполненных объектов</p>
                    </div>
                    <div class="stat_item">
                        <h3>100%</h3>
                        <p>соблюдение сроков</p>
                    </div>
                    <div class="stat_item">
                        <h3>4</h3>
                        <p>квалифицированных специалиста</p>
                    </div>
                </div>

                <div class="info_block">
                    <h2>Наша миссия</h2>
                    <p>Мы стремимся обеспечить физических лиц качественными строительными услугами по доступным ценам. Наша цель — стать лидером рынка в регионе благодаря высокому уровню сервиса и индивидуальному подходу к каждому клиенту.</p>
                </div>

                <div class="info_advantages">
                    <h2>Почему выбирают нас</h2>
                    <div class="advantages_grid">
                        <div class="advantage_card">
                            <img src="../image/shield.png" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjRkZENzAwIiBzdHJva2Utd2lkdGg9IjIiPjxwYXRoIGQ9Ik0xMiAyMnM4LTQgOC0xMFY1bC04LTNsLTggM3Y3YzAgNiA4IDEwIDggMTB6Ii8+PC9zdmc+';" alt="Гарантия">
                            <h3>Гарантия качества</h3>
                            <p>Все работы выполняются с соблюдением технологий и норм СНиП</p>
                        </div>
                        <div class="advantage_card">
                            <img src="../image/truck.png" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjRkZENzAwIiBzdHJva2Utd2lkdGg9IjIiPjxyZWN0IHg9IjEiIHk9IjMiIHdpZHRoPSIxNSIgaGVpZ2h0PSIxMyIvPjxwb2x5Z29uIHBvaW50cz0iMTYgOCAyMCA4IDIzIDExIDIzIDEzIDE2IDEzIDE2IDgiLz48Y2lyY2xlIGN4PSI1LjUiIGN5PSIxOC41IiByPSIyLjUiLz48Y2lyY2xlIGN4PSIxOC41IiBjeT0iMTguNSIgcj0iMi41Ii8+PC9zdmc+';" alt="Сроки">
                            <h3>Соблюдение сроков</h3>
                            <p>Выполняем работы точно в оговоренное время без задержек</p>
                        </div>
                        <div class="advantage_card">
                            <img src="../image/person.png" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjRkZENzAwIiBzdHJva2Utd2lkdGg9IjIiPjxjaXJjbGUgY3g9IjEyIiBjeT0iOCIgcj0iNCIvPjxwYXRoIGQ9Ik0yMCAyMWgtOGMtMS42NTcgMC0zLTEuMzQzLTMtM3YtMWMwLTEuNjU3IDEuMzQzLTMgMy0zaDhjMS42NTcgMCAzIDEuMzQzIDMgM3YxYzAgMS42NTctMS4zNDMgMy0zIDN6Ii8+PC9zdmc+';" alt="Поддержка">
                            <h3>Персональный подход</h3>
                            <p>Индивидуальный расчёт стоимости и персональный менеджер</p>
                        </div>
                        <div class="advantage_card">
                            <img src="../image/tags.png" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjRkZENzAwIiBzdHJva2Utd2lkdGg9IjIiPjxwYXRoIGQ9Ik0yMC41OSAyMi41OWwxMi0xMi0xMi0xMi0xMiAxMiAxMiAxMnoiLz48Y2lyY2xlIGN4PSIxMi41IiBjeT0iNy41IiByPSIyLjUiLz48L3N2Zz4=';" alt="Цены">
                            <h3>Честные цены</h3>
                            <p>Прозрачное ценообразование без скрытых платежей</p>
                        </div>
                    </div>
                </div>

                <div class="info_block">
                    <h2>Организационная структура</h2>
                    <p>В нашей команде работают квалифицированные специалисты:</p>
                    <ul style="font-size: 18px; color: #666; line-height: 2; margin-top: 20px;">
                        <li><strong>Директор</strong> — общее руководство, договоры, контроль финансов и качества</li>
                        <li><strong>Бухгалтер</strong> — учёт, документы, зарплата, отчётность</li>
                        <li><strong>Прораб</strong> — организация работ на объектах, контроль технологии и сроков</li>
                        <li><strong>Тракторист</strong> — управление спецтехникой, земляные работы</li>
                    </ul>
                </div>

                <div class="info_block">
                    <h2>Реквизиты</h2>
                    <div style="font-size: 18px; color: #666; line-height: 2;">
                        <p><strong>Организация:</strong> ИП Барбарян Карен Аветикович</p>
                        <p><strong>Дата регистрации:</strong> 05.03.2007</p>
                        <p><strong>ИНН:</strong> 644900269571</p>
                        <p><strong>ОГРНИП:</strong> 307644907400013</p>
                        <p><strong>Вид деятельности:</strong> специализированные строительные услуги</p>
                        <p><strong>Адрес:</strong> 413124, Саратовская обл., г. Энгельс, пр-д 1-й Студенческий, д. 2а</p>
                        <p><strong>Телефон:</strong> +7 845 352-82-92</p>
                        <p><strong>Режим работы:</strong> Пн–Пт, 8:30–17:00</p>
                    </div>
                </div>
            </div>
        </section>

        <footer class="footer-grid">
            <div>
                <img src="../image/logo.png" onerror="this.style.display='none'" alt="Логотип">
                <p><strong>ИП Барбарян Карен Аветикович</strong></p>
                <p>Ваш надежный партнер в строительстве</p>
            </div>
            <div>
                <h3>Информация</h3>
                <a href="about.php">О компании</a>
                <a href="catalog.php">Услуги</a>
                <a href="contacts.php">Контакты</a>
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
</body>
</html>
