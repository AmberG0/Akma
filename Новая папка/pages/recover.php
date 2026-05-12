<?php 
require_once '../inc/functions.php';

if (is_logged_in()) {
    redirect('main.php');
}

$error = $success = '';

if ($_POST) {
    $email = trim($_POST['email']);
    $new_pass = trim($_POST['password']);

    if (empty($email)) {
        $error = "Введите email";
    } else {
        $stmt = $pdo->prepare("SELECT id, fio FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            $hash = password_hash($new_pass, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->execute([$hash, $user['id']]);

            $success = "Пароль изменен!";
            header('Location: login.php');
        } else {
            $error = "Пароль не изменен!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Восстановление пароля — ТД Синергия</title>
    <link rel="stylesheet" href="../style/normalize.css">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <div class="login_modal_overlay">
        <div class="login_modal">
            <a href="../pages/main.php" class="login_close">×</a>
            
            <h2>Восстановление пароля</h2>

            <?php if ($error): ?>
                <p class="login_error"><?= escape($error) ?></p>
            <?php endif; ?>

            <?php if ($success): ?>
                <p style="color:green; text-align:center; margin:20px 0; font-weight:bold;">
                    <?= $success ?>
                </p>
            <?php else: ?>
                <form method="POST">
                    <input type="email" name="email" placeholder="Введите ваш email" required>
                    <input type="password" name="password" placeholder="Введите новый пароль" required>
                    <button type="submit" class="login_submit">Отправить</button>
                </form>
            <?php endif; ?>

            <div class="login_footer">
                <a href="login.php">Вернуться ко входу</a>
            </div>
        </div>
    </div>
</body>
</html>