<?php 
require_once '../inc/functions.php';

// Получаем ID товара
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: catalog.php");
    exit;
}

// Товар
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    die("Товар не найден");
}

// Похожие товары 
$stmt = $pdo->query("SELECT id, name, price, image FROM products WHERE id != $id ORDER BY RAND() LIMIT 3");
$similar = $stmt->fetchAll();

// Добавление в корзину
if (isset($_POST['add_to_cart'])) {
    if (is_logged_in()){
        add_to_cart($product['id']);
        echo '<script>alert("Товар добавлен в корзину!");</script>';
    }
    else{
        echo '<script>alert("Сперва авторизуйтесь!");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= escape($product['name']) ?> — ТД Синергия</title>
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <?php include("../blocks/modal.php"); ?>
    <div id="main_container">
        <?php include("../blocks/header.php"); ?>

        <section id="product_page">
            <div class="product_wrapper">
                <!--  фото и цена -->
                <div class="product_gallery">
                    <img src="../uploads/<?= $product['image'] ?: 'no-photo.jpg' ?>" alt="<?= escape($product['name']) ?>">
                    <div class="product_price"><?= number_format($product['price'], 0, '', ' ') ?> ₽</div>
                </div>

                <!--описание и покупка -->
                <div class="product_info">
                    <h1><?= escape($product['name']) ?></h1>
                    
                    <div class="product_description">
                        <h2>Описание и характеристики</h2>
                        <p><?= nl2br(escape($product['description'] ?? 'Описание отсутствует')) ?></p>
                        
                        <ul class="product_specs">
                            <?php if ($product['material']): ?>
                                <li>Материал: <?= escape($product['material']) ?></li>
                            <?php endif; ?>
                            <?php if ($product['du']): ?>
                                <li>Ду: <?= escape($product['du']) ?></li>
                            <?php endif; ?>
                            <?php if ($product['quantity'] > 0): ?>
                                <li>В наличии: <?= $product['quantity'] ?> шт.</li>
                            <?php else: ?>
                                <li style="color:red;">Нет в наличии</li>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <div class="product_buy">
                        <select class="size_select">
                            <option>Выберите вариант</option>
                            <option>Размер 1</option>
                            <option>Размер 2</option>
                        </select>
                        
                        <form method="POST">
                            <button type="submit" name="add_to_cart" class="btn_add_to_cart">
                                Добавить в корзину
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Похожие товары -->
            <?php if (!empty($similar)): ?>
                <div id="main_product">
                    <h2 style="width:100%;text-align:center;margin:60px 0 40px;font-size:32px;">Похожие товары</h2>
                    <?php foreach ($similar as $p): ?>
                        <a href="product.php?id=<?= $p['id'] ?>" class="card_product">
                            <div class="product_first">
                                <img src="../uploads/<?= $p['image'] ?: 'no-photo.jpg' ?>" alt="<?= escape($p['name']) ?>">
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
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <?php include("../blocks/footer.php"); ?>
    </div>

    <script src="../js/modal.js"></script>
</body>
</html>