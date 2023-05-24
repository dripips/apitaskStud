<?php
session_start();

// Проверка наличия сессии и авторизации пользователя
if (!isset($_SESSION['username']) || !isset($_SESSION['token'])) {
    echo 'error';
    exit();
}

// Получение имени пользователя и нового пароля из запроса
$username = $_SESSION['username'];
$newPassword = $_POST['password'];

// Хеширование нового пароля
$newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

// Обновление пароля в базе данных
require '../data/config.php';

try {
    $stmt = $pdo->prepare('UPDATE admins SET password = :password WHERE username = :username');
    $stmt->bindParam(':password', $newHashedPassword);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    echo 'success';
} catch (PDOException $e) {
    echo 'error';
}
?>
