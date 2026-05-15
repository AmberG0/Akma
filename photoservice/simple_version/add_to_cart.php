<?php
// Простое добавление в корзину
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['service_id'])) {
    $id = $_POST['service_id'];
    
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]++;
    } else {
        $_SESSION['cart'][$id] = 1;
    }
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
