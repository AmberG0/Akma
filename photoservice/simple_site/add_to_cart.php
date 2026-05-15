<?php
session_start();

// Добавляем услугу в корзину
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_id = $_POST['service_id'] ?? 0;
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? 0;
    $unit = $_POST['unit'] ?? 'шт';
    $quantity = $_POST['quantity'] ?? 1;
    
    if ($service_id && $name) {
        // Инициализируем корзину если нет
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        // Проверяем есть ли уже такая услуга
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['service_id'] == $service_id) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }
        
        // Если не нашли, добавляем новую
        if (!$found) {
            $_SESSION['cart'][] = [
                'service_id' => $service_id,
                'name' => $name,
                'price' => $price,
                'unit' => $unit,
                'quantity' => $quantity
            ];
        }
    }
}

// Возвращаемся на каталог
header('Location: catalog.php');
exit;
?>
