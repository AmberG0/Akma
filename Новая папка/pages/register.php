<?php 
require_once '../inc/functions.php';

if (is_logged_in()) {
    redirect('main.php');
}

$error = $success = '';

if ($_POST) {
    $fio = trim($_POST['fio'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    if (empty($fio) || empty($email) || empty($password)) {
        $error = "Заполните все поля";
    } elseif ($password !== $password2) {
        $error = "Пароли не совпадают";
    } elseif (strlen($password) < 6) {
        $error = "Пароль должен быть не менее 6 символов";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Пользователь с таким email уже существует";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (fio, email, password, role) VALUES (?, ?, ?, 'client')");
            $stmt->execute([$fio, $email, $hash]);
            $success = "Регистрация успешна! Теперь можете войти.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация — ТД Синергия</title>
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <div class="login_modal_overlay">
        <div class="login_modal">
            <a href="../pages/main.php" class="login_close">×</a>
            
            <h2>Регистрация</h2>

            <?php if ($error): ?>
                <p class="login_error"><?= escape($error) ?></p>
            <?php endif; ?>

            <?php if ($success): ?>
                <p style="color:green; text-align:center; margin:20px 0; font-weight:bold;">
                    <?= $success ?><br>
                    <a href="login.php">Перейти ко входу</a>
                </p>
            <?php else: ?>
                <form method="POST">
                    <input type="text" name="fio" placeholder="ФИО" value="<?= escape($_POST['fio'] ?? '') ?>" required>
                    <input type="email" name="email" placeholder="Email" value="<?= escape($_POST['email'] ?? '') ?>" required>
                    <input type="password" name="password" placeholder="Пароль" required minlength="6">
                    <input type="password" name="password2" placeholder="Повторите пароль" required>
                    
                    <button type="submit" class="login_submit">Зарегистрироваться</button>
                </form>
            <?php endif; ?>

            <div class="login_footer">
                <a href="login.php">Уже есть аккаунт? Войти</a>
            </div>
        </div>
    </div>
</body>
</html>