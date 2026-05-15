<?php
session_start();
require_once 'includes/db.php';

// Проверяем метод запроса
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: cart.php');
    exit;
}

// Проверяем наличие корзины
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $_SESSION['error'] = 'Корзина пуста';
    header('Location: cart.php');
    exit;
}

// Получаем данные из формы
$client_name = trim($_POST['client_name'] ?? '');
$client_phone = trim($_POST['client_phone'] ?? '');
$client_email = trim($_POST['client_email'] ?? '');
$client_address = trim($_POST['client_address'] ?? '');
$desired_date = $_POST['desired_date'] ?? null;
$payment_type = $_POST['payment_type'] ?? 'cash';
$comments = trim($_POST['comments'] ?? '');

// Валидация
$errors = [];
if (empty($client_name)) $errors[] = 'Необходимо указать имя';
if (empty($client_phone)) $errors[] = 'Необходимо указать телефон';
if (empty($client_email)) $errors[] = 'Необходимо указать email';

if (!empty($errors)) {
    $_SESSION['error'] = implode(', ', $errors);
    header('Location: cart.php');
    exit;
}

try {
    // Начинаем транзакцию
    $pdo->beginTransaction();
    
    // Сохраняем контакты в сессию
    $_SESSION['client'] = [
        'name' => $client_name,
        'phone' => $client_phone,
        'email' => $client_email,
        'address' => $client_address
    ];
    
    // Создаем записи в Services_tab для каждой услуги
    foreach ($_SESSION['cart'] as $item) {
        $item_total = $item['price'] * $item['quantity'];
        
        $stmt = $pdo->prepare("
            INSERT INTO Services_tab 
            (Description, Data_create, Data_start, Service_list_ID, Service_list_count, Count_pay) 
            VALUES 
            (:description, NOW(), :data_start, :service_id, :count, :pay)
        ");
        
        $stmt->execute([
            ':description' => $item['name'],
            ':data_start' => $desired_date ?: null,
            ':service_id' => $item['service_id'],
            ':count' => $item['quantity'],
            ':pay' => $item_total
        ]);
        
        $service_tab_id = $pdo->lastInsertId();
        
        // Создаем заявку
        $stmt = $pdo->prepare("
            INSERT INTO Orders 
            (Client, Num_phone, Mail, Service_tab_ID, Time_the_bell, Type_pay, Face_client, Other_inform, Status) 
            VALUES 
            (:client, :phone, :email, :service_tab_id, :time_bell, :type_pay, 'physical', :other_inform, 'новая')
        ");
        
        $stmt->execute([
            ':client' => $client_name,
            ':phone' => $client_phone,
            ':email' => $client_email,
            ':service_tab_id' => $service_tab_id,
            ':time_bell' => $desired_date ? $desired_date . ' 09:00:00' : null,
            ':type_pay' => $payment_type,
            ':other_inform' => !empty($client_address) ? 'Адрес: ' . $client_address . '. Комментарий: ' . $comments : $comments
        ]);
    }
    
    // Фиксируем транзакцию
    $pdo->commit();
    
    // Очищаем корзину
    unset($_SESSION['cart']);
    
    // Перенаправляем на страницу успеха
    header('Location: order_success.php');
    exit;
    
} catch (PDOException $e) {
    // Откат транзакции
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    error_log('Ошибка при оформлении заказа: ' . $e->getMessage());
    $_SESSION['error'] = 'Произошла ошибка при оформлении заказа.';
    header('Location: cart.php');
    exit;
}
?>
