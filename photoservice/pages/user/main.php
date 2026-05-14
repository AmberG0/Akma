<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhotoService - Главная</title>
    <link rel="stylesheet" href="../../i/Styles/main.css">
    <link rel="stylesheet" href="../../i/Styles/header.css">
    <link rel="stylesheet" href="../../i/Styles/hero.css">
    <link rel="stylesheet" href="../../i/Styles/about.css">
    <link rel="stylesheet" href="../../i/Styles/footer.css">
</head>
<body>
    <?php include 'modules/header.php'; ?>
    
    <main>
        <?php include 'modules/hero.php'; ?>
        <?php include 'modules/about.php'; ?>
    </main>
    
    <?php include 'modules/footer.php'; ?>
    
    <script src="../../i/Scripts/main.js"></script>
    <script src="../../i/Scripts/hero-slider.js"></script>
    <script src="../../i/Scripts/theme-toggle.js"></script>
</body>
</html>
