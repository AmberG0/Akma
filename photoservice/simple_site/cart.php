<?php
session_start();

// Получаем корзину
$cart = $_SESSION['cart'] ?? [];
$total = 0;

// Считаем общую сумму
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина - СтройСервис</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="logo">Строй<span>Сервис</span></div>
            <nav class="nav">
                <a href="index.php">Главная</a>
                <a href="catalog.php">Каталог</a>
                <a href="cart.php">Корзина</a>
                <a href="admin/login.php">Админка</a>
            </nav>
        </div>
    </header>

    <main class="main">
        <div class="container">
            <h1>Корзина</h1>
            
            <?php if (empty($cart)): ?>
                <p>Корзина пуста. <a href="catalog.php">Перейти в каталог</a></p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Услуга</th>
                            <th>Цена</th>
                            <th>Количество</th>
                            <th>Сумма</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['name']) ?></td>
                                <td><?= number_format($item['price'], 2) ?> ₽</td>
                                <td><?= $item['quantity'] ?> <?= htmlspecialchars($item['unit']) ?></td>
                                <td><?= number_format($item['price'] * $item['quantity'], 2) ?> ₽</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"><strong>Итого:</strong></td>
                            <td><strong><?= number_format($total, 2) ?> ₽</strong></td>
                        </tr>
                    </tfoot>
                </table>
                
                <form method="POST" action="checkout.php" style="margin-top: 30px;">
                    <h2>Оформление заказа</h2>
                    
                    <label>Ваше имя *</label>
                    <input type="text" name="client_name" required>
                    
                    <label>Телефон *</label>
                    <input type="tel" name="client_phone" required>
                    
                    <label>Email *</label>
                    <input type="email" name="client_email" required>
                    
                    <label>Адрес</label>
                    <input type="text" name="client_address" placeholder="г. Энгельс, ул...">
                    
                    <label>Дата начала работ</label>
                    <input type="date" name="desired_date">
                    
                    <label>Способ оплаты</label>
                    <select name="payment_type">
                        <option value="cash">Наличные</option>
                        <option value="bank">Безнал</option>
                    </select>
                    
                    <label>Комментарий</label>
                    <textarea name="comments" rows="4"></textarea>
                    
                    <button type="submit" style="margin-top: 20px;">Оформить заказ</button>
                </form>
            <?php endif; ?>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 СтройСервис. Все права защищены.</p>
        </div>
    </footer>
</body>
</html>
