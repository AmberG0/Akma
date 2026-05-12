<?php

include("../logiс/bd.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $login = $_POST['Login'];
    $password = $_POST['Password'];
    $name = $_POST['Name'];
    $mail = $_POST['Mail'];
    $telephone = $_POST['Telephone'];

    $stmt = $pdo->prepare("SELECT * FROM Users WHERE Login = ?");
    $stmt->execute([$login]);
    $user = $stmt->fetch();
    if (!isset($user["Login"])){
        $stmt = $pdo->prepare("INSERT INTO Users (Login, Password, Name, Mail, Telephone) VALUES (?,?,?,?,?)");
        $stmt->execute([$login, $password, $name, $mail, $telephone]);
        $user = $stmt->fetch();
        
    }
    else{
        echo("<script>alert('такой пользователь уже есть')</script>");
    };

    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\CSS\style.css">
    <title>Document</title>
</head>
<body id="registr_body">

    <form method="POST" action="registr.php" class="registr_wind">
        <p>Регистрация </p>
        <input name="Login" type="text" placeholder="   Логин" pattern="\w{0,12}">
        <input name="Password" type="text" placeholder="   Пароль">
        <input name="Name" type="text" placeholder="   ФИО">
        <input name="Mail" type="email" placeholder="   Почта">
        <input name="Telephone" type="tel" pattern="[0-9]\w{0,11}" placeholder="   Телефон">
        <button type="submit">Зарегистрироваться</button>
        <a href="login.php">Авторизация</a>
</form>

</body>
</html>