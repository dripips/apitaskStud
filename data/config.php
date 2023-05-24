<?php
// Параметры подключения к базе данных
$host = 'localhost'; // Имя хоста
$dbName = 'apimang'; // Имя базы данных
$user = 'apimang'; // Имя пользователя базы данных
$password = 'gA5rG7gJ3j'; // Пароль для доступа к базе данных

// Подключение к базе данных
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo 'Successfully connected to the database.';
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    die();
}
