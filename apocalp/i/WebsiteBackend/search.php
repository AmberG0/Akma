<?php
require("database.php");

$input = $_POST['search_input'] ?? '';

function search(string $search_input, PDO $pdo) {
    if ($search_input === '') {
        // Если пустой ввод — возвращаем все записи
        $stmt = $pdo->prepare('SELECT * FROM content');
        $stmt->execute();
    } else {
        // Иначе ищем по заголовку
        $stmt = $pdo->prepare('SELECT * FROM content WHERE title LIKE ?');
        $stmt->execute([$search_input]);
    }
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results; 
}

header('Content-Type: application/json');

$response = [
    'data' => search('%' . $input . '%', $pdo)
];

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>