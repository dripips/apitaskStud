<?php
require '../data/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Проверка, что пользователь с таким именем уже существует
    $stmt = $pdo->prepare('SELECT * FROM admins WHERE username = ?');
    $stmt->execute([$username]);

    if ($stmt->rowCount() > 0) {
        echo 'error';
    } else {
        // Кеширование пароля с помощью Bcrypt
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Генерация случайного токена
        $token = bin2hex(random_bytes(32));

        // Вставка нового пользователя в базу данных
        $stmt = $pdo->prepare('INSERT INTO admins (username, password, token) VALUES (?, ?, ?)');
        $stmt->execute([$username, $hashedPassword, $token]);

        if ($stmt->rowCount() > 0) {
            echo 'success';
        } else {
            echo 'error';
        }
    }
} else {
    echo 'Method Not Allowed';
}
?>
