<?php
    include "header.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            header("location: ../index.php");
        } else {
            echo 'save me';
            var_dump($user);
        }
    }
?>
<!DOCTYPE html>
<html lang="ru">
<body>
    <div class="background">
        <div class="login_container">
            <h1 class="auth_header">Войти в учетную запись</h1>
            <p class="auth_desc">◉ Введите имя и пароль <br> учетной записи чтобы войти</p>
            <form action="login.php" method="POST" class="auth_form">
                <h2 class="auth_text">Имя пользователя</h2>
                <input class="auth_input" placeholder="Имя пользователя" type="username" name="username" required='true'>
                <h2 class="auth_text">Пароль</h2>
                <input class="auth_input" placeholder="Пароль" type="password" name="password" required='true'>
                <button class="login_button" type="submit">Войти</button>
                <a href="register.php"><p class="auth_redirect">Впервые здесь?</p></a>
            </form>
        </div>
    </div>

    <?php include "footer.php";?>
</body>
</html>