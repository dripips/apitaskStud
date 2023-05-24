<?php
session_start();

// Проверка наличия сессии и авторизации пользователя
if (!isset($_SESSION['username']) || !isset($_SESSION['token'])) {
    header('Location: login.php');
    exit();
}

// Получение имени пользователя и токена из сессии
$username = $_SESSION['username'];
$token = $_SESSION['token'];

// Получение токена из базы данных
require '../data/config.php';

try {
    $stmt = $pdo->prepare('SELECT token FROM admins WHERE username = :username');
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Проверка наличия записи в базе данных
    if ($row) {
        $token = $row['token'];
    }
} catch (PDOException $e) {
    echo 'Error fetching token: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Административная панель</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            width: 800px;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            text-align: center;
            border-bottom: none;
            font-size: 24px;
        }

        .card-body {
            padding: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .btn {
            margin-top: 10px;
        }

        .btn-generate {
            background-color: #28a745;
            color: #fff;
            font-weight: bold;
            width: 100%;
            transition: background-color 0.3s;
        }

        .btn-generate:hover {
            background-color: #218838;
        }

        .btn-generate i {
            margin-right: 5px;
        }

        .btn-change-password {
            background-color: #ffc107;
            color: #000;
            font-weight: bold;
            width: 100%;
            transition: background-color 0.3s;
        }

        .btn-change-password:hover {
            background-color: #e0a800;
        }

        .btn-change-password i {
            margin-right: 5px;
        }

        .btn-logout {
            background-color: #dc3545;
            color: #fff;
            font-weight: bold;
            width: 100%;
            transition: background-color 0.3s;
        }

        .btn-logout:hover {
            background-color: #c82333;
        }

        .btn-logout i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-user-cog"></i> Административная панель
            </div>
            <div class="card-body">
                <h4>Добро пожаловать, <span id="username"><?php echo $username; ?></span>!</h4>
                <p>Ваш токен: <span id="token"><?php echo $token; ?></span></p>

                <button id="generate-token" class="btn btn-generate"><i class="fas fa-sync-alt"></i> Сгенерировать новый токен</button>
                <button id="change-password" class="btn btn-change-password"><i class="fas fa-key"></i> Изменить пароль</button>
                <button id="logout" class="btn btn-logout"><i class="fas fa-sign-out-alt"></i> Выйти</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        $(document).ready(function() {
            // Получение имени пользователя и токена из сессии
            var username = "<?php echo $username; ?>";
            var token = "<?php echo $token; ?>";

            // Отображение имени пользователя и токена
            $('#username').text(username);
            $('#token').text(token);

            // Генерация нового токена
       $('#generate-token').click(function() {
         $.ajax({
           type: 'POST',
           url: '../ajax/generate-token.php',
           success: function(response) {
             $('#token').text(response);
             Toastify({
               text: 'Новый токен сгенерирован',
               duration: 3000,
               gravity: 'top',
               position: 'right',
               backgroundColor: '#28a745',
               close: true
             }).showToast();
           },
           error: function() {
             Toastify({
               text: 'Произошла ошибка',
               duration: 3000,
               gravity: 'top',
               position: 'right',
               backgroundColor: '#dc3545',
               close: true
             }).showToast();
           }
         });
       });

            // Изменение пароля
            $('#change-password').click(function() {
                var newPassword = prompt('Введите новый пароль');
                if (newPassword) {
                    $.ajax({
                        type: 'POST',
                        url: '../ajax/change-password.php',
                        data: { password: newPassword },
                        success: function(response) {
                            Toastify({
                                text: 'Пароль успешно изменен',
                                duration: 3000,
                                gravity: 'top',
                                position: 'right',
                                backgroundColor: '#28a745',
                                close: true
                            }).showToast();
                        },
                        error: function() {
                            Toastify({
                                text: 'Произошла ошибка',
                                duration: 3000,
                                gravity: 'top',
                                position: 'right',
                                backgroundColor: '#dc3545',
                                close: true
                            }).showToast();
                        }
                    });
                }
            });

            // Выход из системы
            $('#logout').click(function() {
    $.ajax({
        type: 'POST',
        url: '../ajax/logout.php',
        success: function(response) {
            if (response === 'success') {
                // Сессия успешно сброшена, перенаправление на страницу авторизации
                window.location.href = 'login.php';
            }
        },
        error: function() {
            Toastify({
                text: 'Произошла ошибка',
                duration: 3000,
                gravity: 'top',
                position: 'right',
                backgroundColor: '#dc3545',
                close: true
            }).showToast();
        }
    });
});

        });
    </script>
</body>
</html>
