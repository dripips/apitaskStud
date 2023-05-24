<?php
session_start();

// Проверка наличия сессии и авторизации пользователя
if (!isset($_SESSION['username']) || !isset($_SESSION['token'])) {
    echo 'error';
    exit();
}

// Генерация нового токена
$newToken = bin2hex(random_bytes(32));

// Обновление токена в базе данных
require '../data/config.php';

try {
    $stmt = $pdo->prepare('UPDATE admins SET token = :token WHERE username = :username');
    $stmt->bindParam(':token', $newToken);
    $stmt->bindParam(':username', $_SESSION['username']);
    $stmt->execute();
    echo $newToken;
} catch (PDOException $e) {
    echo 'error';
}
?>
