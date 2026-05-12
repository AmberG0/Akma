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
</head>
<body>
    <?php include("../blocks/modal.php"); ?>

    <div id="main_container">
        <!-- Шапка -->
        <?php include("../blocks/header.php"); ?>

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
                // echo '<script>
                //     alert("Товар добавлен в корзину!");
                // </script>';
            }
        }
        ?>

        <!-- Подвал -->
        <?php include("../blocks/footer.php"); ?>
    </div>

    <script src="../js/modal.js"></script>
</body>
</html>