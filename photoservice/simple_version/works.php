<?php
// Простая страница отзывов
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

// Получение отзывов
$reviews = [];
try {
    $stmt = $pdo->query("SELECT * FROM Reviews WHERE Is_published = 'да' ORDER BY Date_created DESC");
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Наши работы - Строй Сервис</title>
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
            <h2 class="section-title">Отзывы клиентов</h2>
            
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
                            <small><?= date('d.m.Y', strtotime($review['Date_created'])) ?></small>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <br>
            <h3>Оставить отзыв</h3>
            <form method="POST" action="submit_review.php" style="margin-top: 20px;">
                <div class="form-group">
                    <label>Ваше имя</label>
                    <input type="text" name="client_name" required>
                </div>
                <div class="form-group">
                    <label>Оценка (1-5)</label>
                    <select name="rating">
                        <option value="5">5 - Отлично</option>
                        <option value="4">4 - Хорошо</option>
                        <option value="3">3 - Нормально</option>
                        <option value="2">2 - Плохо</option>
                        <option value="1">1 - Очень плохо</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Текст отзыва</label>
                    <textarea name="review_text" required></textarea>
                </div>
                <button type="submit" class="btn">Отправить</button>
            </form>
            
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
