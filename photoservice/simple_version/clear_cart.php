<?php
// Очистка корзины
session_start();
$_SESSION['cart'] = [];
header('Location: cart.php');
exit;
