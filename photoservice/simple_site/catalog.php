<?php
session_start();
require_once 'includes/db.php';

// Получаем услуги из БД
$stmt = $pdo->query("SELECT * FROM Services WHERE Relevance = 'да'");
$services = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог - СтройСервис</title>
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
            <h1>Каталог услуг</h1>
            
            <?php if (empty($services)): ?>
                <p>Услуг пока нет.</p>
            <?php else: ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                    <?php foreach ($services as $service): ?>
                        <div style="border: 1px solid #ddd; padding: 15px; border-radius: 5px;">
                            <h3><?= htmlspecialchars($service['Name']) ?></h3>
                            <p><?= htmlspecialchars($service['Description']) ?></p>
                            <p><strong>Цена:</strong> <?= number_format($service['Price'], 2) ?> ₽ / <?= htmlspecialchars($service['Unit']) ?></p>
                            
                            <form method="POST" action="add_to_cart.php" style="margin-top: 15px;">
                                <input type="hidden" name="service_id" value="<?= $service['ID_services'] ?>">
                                <input type="hidden" name="name" value="<?= htmlspecialchars($service['Name']) ?>">
                                <input type="hidden" name="price" value="<?= $service['Price'] ?>">
                                <input type="hidden" name="unit" value="<?= htmlspecialchars($service['Unit']) ?>">
                                
                                <label>Количество:</label>
                                <input type="number" name="quantity" value="1" min="1" style="width: 100px;">
                                
                                <button type="submit" style="margin-top: 10px;">В корзину</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
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
