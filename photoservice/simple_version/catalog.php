<?php
// Простой каталог услуг
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

// Получение всех услуг
$services = [];
try {
    $stmt = $pdo->query("SELECT * FROM Services WHERE Relevance = 'да' ORDER BY Name");
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог услуг - Строй Сервис</title>
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
            <h2 class="section-title">Каталог услуг</h2>
            
            <?php if (empty($services)): ?>
                <p>Услуги пока не добавлены.</p>
            <?php else: ?>
                <div class="services-grid">
                    <?php foreach ($services as $service): ?>
                        <div class="service-card">
                            <h3><?= htmlspecialchars($service['Name']) ?></h3>
                            <p><?= htmlspecialchars($service['Description']) ?></p>
                            <div class="price"><?= number_format($service['Price'], 0) ?> ₽ / <?= htmlspecialchars($service['Unit']) ?></div>
                            <form method="POST" action="add_to_cart.php">
                                <input type="hidden" name="service_id" value="<?= $service['ID_services'] ?>">
                                <button type="submit" class="btn">В корзину</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <br>
            <a href="index.php" class="btn">← На главную</a>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>© 2024 Строй Сервис. Все права защищены.</p>
        </div>
    </footer>
</body>
</html>
