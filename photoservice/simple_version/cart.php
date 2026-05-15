<?php
// Простая корзина
session_start();

$host = 'localhost';
$dbname = 'construction_site';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}

$cart_items = [];
$total = 0;

if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_keys($_SESSION['cart']));
    try {
        $stmt = $pdo->query("SELECT * FROM Services WHERE ID_services IN ($ids)");
        $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($services as $service) {
            $qty = $_SESSION['cart'][$service['ID_services']];
            $service['quantity'] = $qty;
            $service['total'] = $service['Price'] * $qty;
            $cart_items[] = $service;
            $total += $service['total'];
        }
    } catch (PDOException $e) {}
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина - Строй Сервис</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <a href="index.php" class="logo">Строй<span>Сервис</span></a>
            <nav>
                <a href="index.php">Главная</a>
                <a href="catalog.php">Услуги</a>
                <a href="works.php">Наши работы</a>
                <a href="cart.php">Корзина</a>
                <a href="admin/login.php">Админка</a>
            </nav>
        </div>
    </header>

    <section class="section">
        <div class="container">
            <h2 class="section-title">Ваша подборка услуг</h2>
            
            <?php if (empty($cart_items)): ?>
                <p>Корзина пуста.</p>
            <?php else: ?>
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Услуга</th>
                            <th>Цена</th>
                            <th>Кол-во</th>
                            <th>Сумма</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['Name']) ?></td>
                                <td><?= number_format($item['Price'], 0) ?> ₽</td>
                                <td><?= $item['quantity'] ?></td>
                                <td><?= number_format($item['total'], 0) ?> ₽</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <h3>Итого: <?= number_format($total, 0) ?> ₽</h3>
                
                <form method="POST" action="checkout.php" style="margin-top: 20px;">
                    <button type="submit" class="btn">Оформить заказ</button>
                </form>
                
                <form method="POST" action="clear_cart.php" style="margin-top: 10px;">
                    <button type="submit" class="btn" style="background-color: #dc3545;">Очистить корзину</button>
                </form>
            <?php endif; ?>
            
            <br>
            <a href="catalog.php" class="btn">← Продолжить выбор</a>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>© 2024 Строй Сервис. Все права защищены.</p>
        </div>
    </footer>
</body>
</html>
