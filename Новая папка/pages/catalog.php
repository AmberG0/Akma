<?php require_once '../inc/functions.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог — ТД Синергия</title>
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <?php include("../blocks/modal.php"); ?>
    <div id="main_container">
        <?php include("../blocks/header.php"); ?>

        <section id="catalog_page">
            <h1 class="catalog_title">Фланцы 230 позиций</h1>

            <div class="catalog_wrapper">
                <!-- Левая панель фильтров -->
                <div class="filters_sidebar">
                    <h3>Фильтры</h3>
                    <div class="filter_group">
                        <h4>Рейтинг</h4>
                        <label><input type="checkbox"> От 4.5 и выше</label>
                        <label><input type="checkbox"> От 4 и выше</label>
                    </div>
                    <div class="filter_group">
                        <h4>Производитель</h4>
                        <label><input type="checkbox"> Синергия</label>
                        <label><input type="checkbox"> Завод №1</label>
                    </div>
                    <div class="filter_group">
                        <h4>Материал</h4>
                        <label><input type="checkbox"> Сталь 20</label>
                        <label><input type="checkbox"> Сталь 09Г2С</label>
                    </div>
                    <div class="filter_group">
                        <h4>Цена</h4>
                        <input type="range" min="0" max="100000" value="50000">
                        <p>от 0 ₽ до 100 000 ₽</p>
                    </div>
                    <div class="filter_group">
                        <h4>Диаметр и общий</h4>
                        <label><input type="checkbox"> Ду50</label>
                        <label><input type="checkbox"> Ду100</label>
                    </div>
                    <button class="btn_apply_filters">Применить</button>
                </div>

                <!-- Основная сетка товаров -->
                <div class="catalog_products">
                    <a href="product.php?id=1" class="card_product">
                        <div class="product_first"><img src="../image/flange.png" alt=""></div>
                        <div class="product_second">
                            <p>Фланец стальной плоский ГОСТ 33259-2015</p>
                        </div>
                        <div class="product_last">
                            <div class="rating">
                                <img src="../image/star.svg" alt="">
                                <h1>4.7</h1>
                            </div>
                            <h1>36378₽</h1>
                        </div>
                    </a>
                    <?php for($i = 0; $i < 11; $i++): ?>
                    <a href="#" class="card_product">
                        <div class="product_first"><img src="../image/flange.png" alt=""></div>
                        <div class="product_second"><p>Фланец стальной плоский ГОСТ 33259-2015</p></div>
                        <div class="product_last">
                            <div class="rating"><img src="../image/star.svg" alt=""><h1>4.7</h1></div>
                            <h1>36378₽</h1>
                        </div>
                    </a>
                    <?php endfor; ?>

                    <!-- Пагинация -->
                    <div class="pagination">
                        <button>«</button>
                        <button class="active">1</button>
                        <button>2</button>
                        <button>3</button>
                        <button>...</button>
                        <button>10</button>
                        <button>»</button>
                    </div>
                </div>
            </div>
        </section>

        <?php include("../blocks/footer.php"); ?>
    </div>
</body>
</html>