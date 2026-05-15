<?php
session_start();
require_once '../../i/WebsiteBackend/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_name = trim($_POST['client_name'] ?? '');
    $review_text = trim($_POST['review_text'] ?? '');
    $rating = (int)($_POST['rating'] ?? 5);
    
    // Валидация
    if (empty($client_name) || empty($review_text)) {
        header('Location: works.php?error=1');
        exit;
    }
    
    // Проверка рейтинга
    if ($rating < 1 || $rating > 5) {
        $rating = 5;
    }
    
    try {
        // Сохранение отзыва (по умолчанию не опубликован)
        $stmt = $pdo->prepare("INSERT INTO Reviews (Client_name, Review_text, Rating, Is_published) VALUES (?, ?, ?, 'Нет')");
        $stmt->execute([$client_name, $review_text, $rating]);
        
        // Перенаправление на страницу с успехом
        header('Location: works.php?success=1');
        exit;
    } catch (PDOException $e) {
        error_log('Ошибка при сохранении отзыва: ' . $e->getMessage());
        header('Location: works.php?error=1');
        exit;
    }
} else {
    // Если не POST запрос
    header('Location: works.php');
    exit;
}
?>
