<?php
// Оформление заказа
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $client = $_POST['client'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    
    if (!empty($_SESSION['cart']) && !empty($client)) {
        // Создаем заявку (упрощенно)
        try {
            $stmt = $pdo->prepare("INSERT INTO Orders (Client, Num_phone, Mail, Time_the_bell, Status) VALUES (?, ?, ?, NOW(), 'новая')");
            $stmt->execute([$client, $phone, $email]);
            
            // Очищаем корзину
            $_SESSION['cart'] = [];
            
            header('Location: success.php');
            exit;
        } catch (PDOException $e) {
            $error = "Ошибка при создании заказа: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оформление заказа - Строй Сервис</title>
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
            </nav>
        </div>
    </header>

    <section class="section">
        <div class="container">
            <h2 class="section-title">Оформление заказа</h2>
            
            <?php if (isset($error)): ?>
                <p style="color: red;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            
            <form method="POST" style="max-width: 500px;">
                <div class="form-group">
                    <label>Ваше имя *</label>
                    <input type="text" name="client" required>
                </div>
                <div class="form-group">
                    <label>Телефон</label>
                    <input type="tel" name="phone">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email">
                </div>
                <button type="submit" class="btn">Заказать</button>
            </form>
            
            <br>
            <a href="cart.php" class="btn">← Назад в корзину</a>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>© 2024 Строй Сервис. Все права защищены.</p>
        </div>
    </footer>
</body>
</html>
