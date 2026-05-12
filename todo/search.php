<?php
ini_set('display_errors', 0);
error_reporting(0);

header('Content-Type: application/json; charset=utf-8');

require "database.php";


$input = $_POST['search_input'] ?? '';

function search(string $search_input, PDO $pdo) {

    $stmt = $pdo->prepare('SELECT * FROM content');
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $results; 
}

header('Content-Type: application/json');

$response = [
    'data' => search('%' . $input . '%', $pdo)
];

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>