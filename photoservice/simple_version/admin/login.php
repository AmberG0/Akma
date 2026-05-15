<?php
// Простой вход в админку
session_start();

$host = 'localhost';
$dbname = 'construction_site';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $pass = $_POST['password'] ?? '';
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM Personnel WHERE Login = ? AND Password = ?");
        $stmt->execute([$login, $pass]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            $_SESSION['user_id'] = $user['ID_personal'];
            $_SESSION['role'] = $user['Role'];
            $_SESSION['fio'] = $user['Fio'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = "Неверный логин или пароль";
        }
    } catch (PDOException $e) {
        $error = "Ошибка: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход в админку - Строй Сервис</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body { background: #F5F5F5; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .login-form { background: white; padding: 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .login-form h2 { margin-bottom: 20px; color: #1A1A1A; }
    </style>
</head>
<body>
    <div class="login-form">
        <h2>Вход для персонала</h2>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Логин</label>
                <input type="text" name="login" required>
            </div>
            <div class="form-group">
                <label>Пароль</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn" style="width: 100%;">Войти</button>
        </form>
        <br>
        <a href="../index.php">← На сайт</a>
    </div>
</body>
</html>
