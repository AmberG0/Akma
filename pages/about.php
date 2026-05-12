<?php 
require_once '../inc/functions.php'; 
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>О компании — ТД Синергия</title>
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <?php include("../blocks/modal.php"); ?>
    <div id="main_container">
        <?php include("../blocks/header.php"); ?>

        <section id="info_page">
            <h1 class="info_title">О компании</h1>
            
            <div class="info_content">
                <div class="info_block">
                    <img src="../image/logo.png" alt="Логотип ТД Синергия">
                    <h2>ТД «Синергия» — ваш надёжный партнёр</h2>
                    <p>Компания «ТД Синергия» работает на рынке металлопроката и трубопроводной арматуры с 2010 года. За это время мы зарекомендовали себя как надёжный поставщик качественной продукции для промышленных предприятий по всей России.</p>
                </div>

                <div class="info_stats">
                    <div class="stat_item">
                        <h3>14+</h3>
                        <p>лет на рынке</p>
                    </div>
                    <div class="stat_item">
                        <h3>5000+</h3>
                        <p>довольных клиентов</p>
                    </div>
                    <div class="stat_item">
                        <h3>10000+</h3>
                        <p>товаров в каталоге</p>
                    </div>
                    <div class="stat_item">
                        <h3>85</h3>
                        <p>регионов доставки</p>
                    </div>
                </div>

                <div class="info_block">
                    <h2>Наша миссия</h2>
                    <p>Мы стремимся обеспечить российские предприятия качественными материалами для строительства и промышленности по доступным ценам. Наша цель — стать лидером рынка благодаря высокому уровню сервиса и индивидуальному подходу к каждому клиенту.</p>
                </div>

                <div class="info_advantages">
                    <h2>Почему выбирают нас</h2>
                    <div class="advantages_grid">
                        <div class="advantage_card">
                            <img src="../image/shield.png" alt="Гарантия">
                            <h3>Гарантия качества</h3>
                            <p>Вся продукция сертифицирована и соответствует ГОСТ</p>
                        </div>
                        <div class="advantage_card">
                            <img src="../image/truck.png" alt="Доставка">
                            <h3>Быстрая доставка</h3>
                            <p>Отгружаем товар в день оплаты или на следующий день</p>
                        </div>
                        <div class="advantage_card">
                            <img src="../image/tags.png" alt="Цены">
                            <h3>Выгодные цены</h3>
                            <p>Прямые поставки от производителей без посредников</p>
                        </div>
                        <div class="advantage_card">
                            <img src="../image/person.png" alt="Поддержка">
                            <h3>Поддержка 24/7</h3>
                            <p>Персональный менеджер для каждого клиента</p>
                        </div>
                    </div>
                </div>

                <div class="info_block">
                    <h2>Наши сертификаты</h2>
                    <div class="certificates_grid">
                        <div class="certificate_item">
                            <div class="cert_placeholder">Сертификат ISO 9001</div>
                        </div>
                        <div class="certificate_item">
                            <div class="cert_placeholder">Сертификат соответствия ГОСТ</div>
                        </div>
                        <div class="certificate_item">
                            <div class="cert_placeholder">Декларация качества</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php include("../blocks/footer.php"); ?>
    </div>
</body>
</html>
