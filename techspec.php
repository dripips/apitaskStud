<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Техническое задание</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
        }

        h2 {
            margin-bottom: 10px;
        }

        p {
            margin-bottom: 10px;
        }

        .section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .step {
            margin-bottom: 20px;
        }

        .step-number {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 5px;
        }

        .step-description {
            margin-left: 20px;
        }

        .button-container {
            text-align: center;
            margin-top: 30px;
        }

        .home-button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Техническое задание</h1>

    <div class="section">
        <h2 class="section-title">Пользователи</h2>
        <div class="step">
            <p class="step-number">Шаг 1:</p>
            <p class="step-description">Реализовать функционал регистрации нового пользователя с использованием API-эндпоинта "auth/register".</p>
        </div>
        <div class="step">
            <p class="step-number">Шаг 2:</p>
            <p class="step-description">Реализовать функционал авторизации пользователя с использованием API-эндпоинта "auth/login".</p>
        </div>
        <div class="step">
            <p class="step-number">Шаг 3:</p>
            <p class="step-description">Реализовать функционал получения информации о текущем пользователе с использованием API-эндпоинта "users/me".</p>
        </div>

    </div>

    <div class="section">
        <h2 class="section-title">Товары</h2>
        <div class="step">
            <p class="step-number">Шаг 1:</p>
            <p class="step-description">Реализовать функционал получения списка всех товаров с использованием API-эндпоинта "products".</p>
        </div>
        <div class="step">
            <p class="step-number">Шаг 2:</p>
            <p class="step-description">Реализовать функционал получения информации о конкретном товаре по его идентификатору с использованием API-эндпоинта "products/{id}".</p>
        </div>
        <div class="step">
            <p class="step-number">Шаг 3:</p>
            <p class="step-description">Реализовать функционал создания нового товара с использованием API-эндпоинта "products".</p>
        </div>

    </div>

    <div class="section">
        <h2 class="section-title">Категории</h2>
        <div class="step">
            <p class="step-number">Шаг 1:</p>
            <p class="step-description">Реализовать функционал получения списка всех категорий с использованием API-эндпоинта "categories".</p>
        </div>
        <div class="step">
            <p class="step-number">Шаг 2:</p>
            <p class="step-description">Реализовать функционал получения информации о конкретной категории по её идентификатору с использованием API-эндпоинта "categories/{id}".</p>
        </div>
        <div class="step">
            <p class="step-number">Шаг 3:</p>
            <p class="step-description">Реализовать функционал создания новой категории с использованием API-эндпоинта "categories".</p>
        </div>

    </div>
    <div class="section">
        <h2 class="section-title">А так же реализовать работу с токенами, транзакциями и так далее.</h2>


    </div>
    <div class="button-container">
        <a class="home-button" href="/">На главную</a>
    </div>
</body>
</html>
