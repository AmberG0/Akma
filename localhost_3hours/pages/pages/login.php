<?php

include("../logiс/bd.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM Users WHERE Login = ?");
        $stmt->execute([$login]);
        $user = $stmt->fetch();

        if ($user && $password) {
            session_start();
            $_SESSION['user_id'] = $user['ID'];
            $_SESSION['username'] = $user['Login'];
            $_SESSION['role'] = $user['admin'];
            header("location: main.php");
        } else {
          
            var_dump($user);
            header("location: main.php");
        }
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\CSS\style.css">
    <title>Авторизация</title>
</head>
<body id="login_body">
    <form method="POST" action="login.php" class="login_wind">
        <p>Авторизация</p>
        <input type="text" placeholder="   Логин" name="login">
        <input type="text" placeholder="   Пароль" name="password">
        <button type="submit">Войти</button>
        <a href="registr.php">Регистрация</a>
    </form>
</body>
</html>