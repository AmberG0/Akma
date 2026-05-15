<?php
// Отправка отзыва
session_start();

$host = 'localhost';
$dbname = 'construction_site';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_name = $_POST['client_name'] ?? '';
    $rating = $_POST['rating'] ?? 5;
    $review_text = $_POST['review_text'] ?? '';
    
    if (!empty($client_name) && !empty($review_text)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO Reviews (Client_name, Review_text, Rating, Is_published) VALUES (?, ?, ?, 'Нет')");
            $stmt->execute([$client_name, $review_text, $rating]);
            header('Location: works.php?success=1');
            exit;
        } catch (PDOException $e) {
            header('Location: works.php?error=1');
            exit;
        }
    }
}

header('Location: works.php');
