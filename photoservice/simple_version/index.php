<?php
// Простая главная страница сайта "Строй сервис"
// Учебная версия для демонстрации функционала

session_start();

// Подключение к базе данных
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

// Получение услуг из базы
$services = [];
try {
    $stmt = $pdo->query("SELECT * FROM Services WHERE Relevance = 'да' LIMIT 6");
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Если таблица пуста или не существует
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Строй Сервис - Главная</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Шапка -->
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

    <!-- Hero секция -->
    <section class="hero">
        <div class="container">
            <h1>Строительные услуги в Энгельсе</h1>
            <p>Профессионально и в срок выполним любые строительные работы</p>
            <br>
            <a href="catalog.php" class="btn">Смотреть услуги</a>
        </div>
    </section>

    <!-- Услуги -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Наши услуги</h2>
            
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
        </div>
    </section>

    <!-- О компании -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">О компании</h2>
            <p>ИП Барбарян Карен Аветикович работает на строительном рынке с 2007 года.</p>
            <br>
            <p><strong>Адрес:</strong> 413124, Саратовская обл., г. Энгельс, пр-д 1-й Студенческий, д. 2а</p>
            <p><strong>Телефон:</strong> +7 845 352-82-92</p>
            <p><strong>Режим работы:</strong> Пн–Пт, 8:30–17:00</p>
        </div>
    </section>

    <!-- Отзывы -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Отзывы клиентов</h2>
            
            <?php
            $reviews = [];
            try {
                $stmt = $pdo->query("SELECT * FROM Reviews WHERE Is_published = 'да' ORDER BY Date_created DESC LIMIT 3");
                $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {}
            ?>
            
            <?php if (empty($reviews)): ?>
                <p>Отзывов пока нет.</p>
            <?php else: ?>
                <div class="reviews-grid">
                    <?php foreach ($reviews as $review): ?>
                        <div class="review-card">
                            <div class="review-author"><?= htmlspecialchars($review['Client_name']) ?></div>
                            <div class="review-rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <?= $i <= $review['Rating'] ? '★' : '☆' ?>
                                <?php endfor; ?>
                            </div>
                            <p><?= nl2br(htmlspecialchars($review['Review_text'])) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <br>
            <a href="works.php" class="btn">Все отзывы</a>
        </div>
    </section>

    <!-- Подвал -->
    <footer>
        <div class="container">
            <p>© 2024 Строй Сервис. Все права защищены.</p>
        </div>
    </footer>
</body>
</html>
