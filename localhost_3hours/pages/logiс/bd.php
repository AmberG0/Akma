<?php

session_start();

$servername = "localhost";
$dbname = "3hours";
$username = "root";
$password = "";

$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);