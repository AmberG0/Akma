<?php 
require_once '../inc/functions.php';
require_admin(); // защита админки

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) die("Заказ не найден");

// Заказ + клиент
$stmt = $pdo->prepare("
    SELECT o.*, u.fio, u.email, u.phone 
    FROM orders o 
    LEFT JOIN users u ON o.user_id = u.id 
    WHERE o.id = ?
");
$stmt->execute([$id]);
$order = $stmt->fetch();

if (!$order) die("Заказ не найден");

// Товары в заказе
$items = $pdo->prepare("
    SELECT oi.*, p.name, p.image 
    FROM order_items oi 
    JOIN products p ON oi.product_id = p.id 
    WHERE oi.order_id = ?
");
$items->execute([$id]);
$items = $items->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Заказ #<?= $order['id'] ?></title>
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <div id="admin_container">
        <!-- Боковое меню  -->
        <aside class="admin_sidebar">
            <div class="admin_logo">
                <img src="../image/logo.png" alt="Logo">
                <h2>Админ-панель</h2>
            </div>
            <nav class="admin_menu">
                <a href="admin_accounts.php" class="menu_item">Аккаунты</a>
                <a href="admin_products.php" class="menu_item">Товары</a>
                <a href="admin_orders.php" class="menu_item active">Заказы</a>
            </nav>
            <div class="admin_logout">
                <a href="../logout.php" class="btn_logout_big">Выйти</a>
            </div>
        </aside>

        <main class="admin_main">
            <header class="admin_header">
                <h1>Заказ #<?= $order['id'] ?></h1>
                <a href="admin_orders.php" class="btn_add_product">← Назад к заказам</a>
            </header>

            <div class="admin_table_wrapper">
                <div style="background:white;padding:30px;border-radius:20px;box-shadow:0 4px 20px rgba(0,0,0,0.1);">
                    <p><strong>Дата:</strong> <?= date('d.m.Y H:i', strtotime($order['created_at'])) ?></p>
                    <p><strong>Клиент:</strong> <?= escape($order['fio'] ?? 'Гость') ?></p>
                    <p><strong>Email:</strong> <?= escape($order['email'] ?? '—') ?></p>
                    <p><strong>Телефон:</strong> <?= escape($order['phone'] ?? '—') ?></p>
                    <p><strong>Адрес доставки:</strong> <?= escape($order['delivery_address'] ?? 'Самовывоз') ?></p>
                    <p><strong>Статус:</strong> 
                        <span class="status <?= $order['status'] ?>">
                            <?= [
                                'new' => 'Новый',
                                'processing' => 'В обработке',
                                'shipped' => 'Отправлен',
                                'delivered' => 'Доставлен',
                                'cancelled' => 'Отменён'
                            ][$order['status']] ?? 'Неизвестно' ?>
                        </span>
                    </p>
                </div>

                <h2 style="margin:40px 0 20px;">Товары в заказе</h2>
                <table class="admin_table">
                    <thead>
                        <tr><th>Фото</th><th>Товар</th><th>Кол-во</th><th>Цена</th><th>Сумма</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $i): ?>
                            <tr>
                                <td>
                                    <?php if ($i['image']): ?>
                                        <img src="../uploads/<?= $i['image'] ?>" style="width:60px;height:60px;object-fit:cover;border-radius:8px;">
                                    <?php endif; ?>
                                </td>
                                <td><?= escape($i['name']) ?></td>
                                <td><?= $i['quantity'] ?></td>
                                <td><?= number_format($i['price'], 0, '', ' ') ?> ₽</td>
                                <td><?= number_format($i['price'] * $i['quantity'], 0, '', ' ') ?> ₽</td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="4" style="text-align:right;font-weight:bold;">Итого:</td>
                            <td style="font-weight:bold;color:var(--color-price);">
                                <?= number_format($order['total'], 0, '', ' ') ?> ₽
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>