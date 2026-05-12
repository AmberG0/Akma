<?php 
require_once '../inc/functions.php'; 

if (!is_logged_in()) {
    redirect('login.php');
}

$cart_items = get_cart_items($pdo);
$total = get_cart_total($pdo);

// Обработка действий
if ($_POST['action'] ?? '' === 'update') {
    $id = (int)($_POST['product_id'] ?? 0);
    $qty = (int)($_POST['quantity'] ?? 1);
    update_cart_item($id, $qty);
    redirect('basket.php');
}

if ($_POST['action'] ?? '' === 'remove') {
    $id = (int)($_POST['product_id'] ?? 0);
    remove_from_cart($id);
    redirect('basket.php');
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина — ТД Синергия</title>
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <?php include("../blocks/modal.php"); ?>
    <div id="main_container">
        <?php include("../blocks/header.php"); ?>

        <div class="page_title">Корзина</div>

        <?php if (empty($cart_items)): ?>
            <div class="empty_basket">
                <img src="../image/basket_big.svg" alt="Пустая корзина">
                <h2>Корзина пуста</h2>
                <p>Добавьте товары из <a href="main.php">каталога</a></p>
            </div>
        <?php else: ?>
            <div class="basket_wrapper">
                <div class="basket_items">
                    <?php foreach ($cart_items as $item): ?>
                        <div class="basket_item">
                            <img src="../uploads/<?= $item['image'] ?? 'flange.png' ?>" alt="<?= escape($item['name']) ?>">
                            
                            <div class="item_info">
                                <h3><?= escape($item['name']) ?></h3>
                            </div>

                            <div class="item_quantity">
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                    <input type="hidden" name="action" value="update">
                                    <button type="submit" name="quantity" value="<?= $item['quantity'] - 1 ?>">-</button>
                                </form>
                                <span><?= $item['quantity'] ?></span>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                    <input type="hidden" name="action" value="update">
                                    <button type="submit" name="quantity" value="<?= $item['quantity'] + 1 ?>">+</button>
                                </form>
                            </div>

                            <div class="item_price"><?= number_format($item['subtotal'], 0, '', ' ') ?> ₽</div>

                            <form method="POST">
                                <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                <input type="hidden" name="action" value="remove">
                                <button type="submit" class="item_remove">×</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="basket_summary">
                    <div class="summary_total">
                        <span>Итого:</span>
                        <strong><?= number_format($total, 0, '', ' ') ?> ₽</strong>
                    </div>
                    <a href="checkout.php" class="btn_checkout">
                        Оформить заказ
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <?php include("../blocks/footer.php"); ?>
    </div>
</body>
</html>