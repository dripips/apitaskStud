<?php
session_start();
require '../data/config.php';

// Получение данных из POST-запроса
$username = $_POST['username'];
$password = $_POST['password'];

try {
    // Поиск пользователя в базе данных по имени пользователя
    $stmt = $pdo->prepare('SELECT * FROM admins WHERE username = :username');
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($password, $row['password'])) {
        // Успешная авторизация
        $_SESSION['username'] = $username;
        $_SESSION['token'] = $row['token'];
        echo 'success';
    } else {
        // Неверные учетные данные
        echo 'error';
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
