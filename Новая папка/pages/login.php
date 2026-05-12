<?php 
require_once '../inc/functions.php'; 

if (is_logged_in()) {
    redirect('main.php');
}

$error = '';
if ($_POST) {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['fio'];
            $_SESSION['user_role'] = $user['role'];
            redirect('main.php');
        } else {
            $error = "Неверный email или пароль";
        }
    } else {
        $error = "Заполните все поля";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход — ТД Синергия</title>
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <div class="login_modal_overlay">
        <div class="login_modal">
            <a href="../pages/main.php" class="login_close">×</a>
            
            <h2>Войти</h2>

            <?php if ($error): ?>
                <p class="login_error"><?= escape($error) ?></p>
            <?php endif; ?>

            <form method="POST">
                <input type="email" name="email" placeholder="Имя пользователя" required>
                <input type="password" name="password" placeholder="Введите пароль" required>
                
                <a href="recover.php" class="login_forgot">Восстановление пароля</a>
                
                <button type="submit" class="login_submit">Войти</button>
            </form>

            <div class="login_footer">
                <a href="register.php">Регистрация</a>
            </div>
        </div>
    </div>
</body>
</html>