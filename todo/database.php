<?php

session_start();

$servername = "localhost";
$dbname = "todo";
$username = "root";
$password = "";

$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);