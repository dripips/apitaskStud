<!DOCTYPE html>
<html>
<head>
    <title>Платформам для решение задачи с api</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .title {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 20px;
        }

        .button {
            margin: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Добро пожаловать на задание по API!</h1>
        <div class="buttons">
            <a href="documentation.php" class="btn btn-primary button">Документация</a>
            <a href="techspec.php" class="btn btn-primary button">Техническое задание</a>
            <a href="admin/login.php" class="btn btn-primary button">Авторизация</a>
            <a href="admin/reg.php" class="btn btn-primary button">Регистрация</a>
        </div>
    </div>
    <footer style="background-color: #f8f8f8; padding: 20px; text-align: center;">
           <p style="margin: 0;">&copy;2023 DRIP</p>
       </footer>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
