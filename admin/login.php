<?php
session_start();

if (isset($_SESSION['username']) && isset($_SESSION['token'])) {
    header('Location: admin-panel.php'); // Перенаправление на административную панель
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Администраторская панель</title>
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
            width: 400px;
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

        .btn-login {
            background-color: #28a745;
            color: #fff;
            font-weight: bold;
            width: 100%;
            transition: background-color 0.3s;
        }

        .btn-login:hover {
            background-color: #218838;
        }

        .btn-login i {
            margin-right: 5px;
        }

        .btn-register {
            background-color: #6c757d;
            color: #fff;
            font-weight: bold;
            width: 100%;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        .btn-register:hover {
            background-color: #5a6268;
        }

        .btn-register i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-lock"></i> Авторизация
            </div>
            <div class="card-body">
                <form id="login-form" method="POST" action="../ajax/login.php">
                    <div class="form-group">
                        <label for="username">Имя пользователя:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Пароль:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-login"><i class="fas fa-sign-in-alt"></i> Войти</button>
                    <a href="reg.php" class="btn btn-register"><i class="fas fa-user-plus"></i> Регистрация</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        $(document).ready(function() {
            $('#login-form').submit(function(e) {
                e.preventDefault(); // Отменяем отправку формы по умолчанию

                var username = $('#username').val();
                var password = $('#password').val();

                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: {
                        username: username,
                        password: password
                    },
                    success: function(response) {
                        if (response === 'success') {
                            // Авторизация успешна, перенаправление на страницу администраторской панели
                            window.location.href = 'admin-panel.php';
                        } else {
                            // Отображение уведомления об ошибке
                            Toastify({
                                text: 'Неверные учетные данные',
                                duration: 3000,
                                gravity: 'top',
                                position: 'right',
                                backgroundColor: '#dc3545',
                                close: true
                            }).showToast();
                        }
                    },
                    error: function() {
                        // Отображение уведомления об ошибке
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
