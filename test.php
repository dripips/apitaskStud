<?php
$userId = 2; // Идентификатор пользователя, которого нужно обновить

// Данные, которые нужно обновить
$data = [
    'full_name' => 'drips',
    // Другие поля для обновления
];

// Преобразуем данные в формат JSON
$jsonData = json_encode($data);

// Установка URL-адреса API
$url = "https://api.dripweb.ru/api/users/$userId";

// Создание cURL-соединения
$ch = curl_init($url);

// Установка параметров запроса
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer 89e36e468f37d7ed254a83d00227f0ac2c970dce24a59b26efe497ea98b6aa4b' // Замените {your_token_here} на ваш реальный токен авторизации
]);

// Выполнение запроса
$response = curl_exec($ch);
var_dump($response);
// Проверка на ошибки выполнения запроса
if (curl_errno($ch)) {
    echo 'Ошибка CURL: ' . curl_error($ch);
} else {
    // Обработка ответа
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($httpCode === 200) {
        echo 'Информация о пользователе успешно обновлена.';
    } else {
        echo 'Ошибка при обновлении информации о пользователе. Код ответа: ' . $httpCode;
    }
}

// Закрытие соединения
curl_close($ch);
?>
