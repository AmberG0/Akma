<?php
// Конфигурация проекта
define('SITE_NAME', 'NeonTech');
define('SITE_URL', 'http://localhost/test_project/');
define('THEME_COLOR', '#13eed4');

// Настройки базы данных (если понадобится)
$db_config = [
    'host' => 'localhost',
    'dbname' => 'neontech',
    'username' => 'root',
    'password' => ''
];

// Функция для подключения к БД
function getDbConnection() {
    global $db_config;
    try {
        $pdo = new PDO(
            "mysql:host={$db_config['host']};dbname={$db_config['dbname']};charset=utf8",
            $db_config['username'],
            $db_config['password'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        return $pdo;
    } catch (PDOException $e) {
        return null;
    }
}
?>
