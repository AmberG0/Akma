<?php
session_start();

$host = 'localhost';
$db   = 'construction_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Для демо-режима создаём mock-объект
    $pdo = new class extends PDO {
        public function __construct() {}
        public function query($sql) { return []; }
        public function prepare($sql) { 
            return new class {
                public function execute($params = []) { return true; }
                public function fetch() { return null; }
                public function fetchAll() { return []; }
            };
        }
    };
}
?>
