<!DOCTYPE html>
<html>
<head>
    <title>Документация</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.27.0/themes/prism.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.27.0/plugins/line-numbers/prism-line-numbers.min.css">
    <style>
        /* Оформление блоков кода */
        pre {
            background-color: #f8f8f8;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            overflow-x: auto;
        }

        pre code {
            font-size: 14px;
            line-height: 1.5;
            font-family: 'Courier New', Courier, monospace;
        }

        .language-java {
            color: #007acc;
        }

        .language-php {
            color: #6e5494;
        }
    </style>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1, h2, h3, h4, h5, h6 {
            color: #333;
        }

        pre {
            background-color: #f8f8f8;
            padding: 10px;
            border: 1px solid #ddd;
        }

        code {
            font-family: Consolas, monospace;
            font-size: 14px;
            background-color: #f8f8f8;
            padding: 2px 5px;
        }

        p {
            line-height: 1.5;
        }

        ul {
            padding-left: 20px;
        }

        .container {
            max-width: 900px;
        }

        .section-title {
            margin-top: 30px;
            margin-bottom: 20px;
        }

        .endpoint {
            margin-bottom: 20px;
        }

        .endpoint-method {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .endpoint-description {
            margin-bottom: 10px;
        }

        .response-example {
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .response-example pre {
            margin: 0;
        }

        .btn {
            margin-right: 10px;
        }

        .btn-home {
            margin-bottom: 20px;
        }
        .error-table {
           margin-top: 20px;
           margin-bottom: 20px;
       }

       .error-table th,
       .error-table td {
           padding: 10px;
           border: 1px solid #ddd;
       }
    </style>
    <h2>Java</h2>
<pre><code class="language-java">
  import java.io.BufferedReader;
  import java.io.InputStreamReader;
  import java.net.HttpURLConnection;
  import java.net.URL;

  public class APIClient {
      public static void main(String[] args) {
          try {
              // Установка URL-адреса API
              URL url = new URL("https://api.dripweb.ru/api/users");

              // Создание объекта HttpURLConnection
              HttpURLConnection conn = (HttpURLConnection) url.openConnection();

              // Установка метода запроса
              conn.setRequestMethod("GET");

              // Установка заголовка Authorization с токеном
              String token = "TOKEN";
              conn.setRequestProperty("Authorization", "Bearer " + token);

              // Получение ответа от сервера
              BufferedReader reader = new BufferedReader(new InputStreamReader(conn.getInputStream()));
              String line;
              StringBuilder response = new StringBuilder();
              while ((line = reader.readLine()) != null) {
                  response.append(line);
              }
              reader.close();

              // Вывод полученного ответа
              System.out.println(response.toString());
          } catch (Exception e) {
              e.printStackTrace();
          }
      }
  }

</code></pre>

<h2>PHP</h2>
<pre><code class="language-php">
&lt;?php
$url = 'https://api.dripweb.ru/api/users';

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Authorization: Bearer YOUR_TOKEN_HERE'
));

$response = curl_exec($ch);
curl_close($ch);

echo $response;
?&gt;
</code></pre>

<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.27.0/prism.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.27.0/plugins/autoloader/prism-autoloader.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.27.0/plugins/line-numbers/prism-line-numbers.min.js"></script>
</head>
<body>
   <div class="container">
       <div class="section">
           <h2 class="section-title">О проекте</h2>
           <p>Наш проект представляет собой API для управления пользователями, транзакциями и категориями.</p>
       </div>

       <div class="section">
           <h2 class="section-title">Авторизация и регистрация</h2>
           <p>Для авторизации и регистрации в системе используйте следующие эндпоинты:</p>
           <div class="endpoint">
               <div class="endpoint-method">POST /api/auth/login</div>
               <div class="endpoint-description">Авторизация пользователя.</div>
               <div class="endpoint-authorization">Не требуется авторизация по токену</div>
           </div>
           <div class="endpoint">
               <div class="endpoint-method">POST /api/auth/register</div>
               <div class="endpoint-description">Регистрация нового пользователя.</div>
               <div class="endpoint-authorization">Не требуется авторизация по токену</div>
           </div>
       </div>

       <div class="section">
           <h2 class="section-title">Пользователи</h2>
           <p>Эндпоинты для управления пользователями:</p>
           <div class="endpoint">
               <div class="endpoint-method">GET /api/users</div>
               <div class="endpoint-description">Получение списка всех пользователей.</div>
               <div class="endpoint-authorization">Требуется авторизация по токену</div>
           </div>
           <div class="endpoint">
               <div class="endpoint-method">GET /api/users/{id}</div>
               <div class="endpoint-description">Получение информации о конкретном пользователе по его идентификатору.</div>
               <div class="endpoint-authorization">Требуется авторизация по токену</div>
           </div>
           <div class="endpoint">
               <div class="endpoint-method">POST /api/users</div>
               <div class="endpoint-description">Создание нового пользователя.</div>
               <div class="endpoint-authorization">Требуется авторизация по токену</div>
           </div>
           <div class="endpoint">
               <div class="endpoint-method">PUT /api/users/{id}</div>
               <div class="endpoint-description">Обновление информации о пользователе по его идентификатору.</div>
               <div class="endpoint-authorization">Требуется авторизация по токену</div>
           </div>
           <div class="endpoint">
               <div class="endpoint-method">DELETE /api/users/{id}</div>
               <div class="endpoint-description">Удаление пользователя по его идентификатору.</div>
               <div class="endpoint-authorization">Требуется авторизация по токену</div>
           </div>
       </div>

       <div class="section">
           <h2 class="section-title">Транзакции</h2>
           <p>Эндпоинты для управления транзакциями:</p>
           <div class="endpoint">
               <div class="endpoint-method">GET /api/transactions</div>
               <div class="endpoint-description">Получение списка всех транзакций.</div>
               <div class="endpoint-authorization">Требуется авторизация по токену</div>
           </div>
           <div class="endpoint">
               <div class="endpoint-method">GET /api/transactions/{id}</div>
               <div class="endpoint-description">Получение информации о конкретной транзакции по её идентификатору.</div>
               <div class="endpoint-authorization">Требуется авторизация по токену</div>
           </div>
           <div class="endpoint">
               <div class="endpoint-method">POST /api/transactions</div>
               <div class="endpoint-description">Создание новой транзакции.</div>
               <div class="endpoint-authorization">Требуется авторизация по токену</div>
           </div>
           <div class="endpoint">
               <div class="endpoint-method">PUT /api/transactions/{id}</div>
               <div class="endpoint-description">Обновление информации о транзакции по её идентификатору.</div>
               <div class="endpoint-authorization">Требуется авторизация по токену</div>
           </div>
           <div class="endpoint">
               <div class="endpoint-method">DELETE /api/transactions/{id}</div>
               <div class="endpoint-description">Удаление транзакции по её идентификатору.</div>
               <div class="endpoint-authorization">Требуется авторизация по токену</div>
           </div>
       </div>

       <div class="section">
           <h2 class="section-title">Категории</h2>
           <p>Эндпоинты для управления категориями:</p>
           <div class="endpoint">
               <div class="endpoint-method">GET /api/categories</div>
               <div class="endpoint-description">Получение списка всех категорий.</div>
               <div class="endpoint-authorization">Требуется авторизация по токену</div>
           </div>
           <div class="endpoint">
               <div class="endpoint-method">GET /api/categories/{id}</div>
               <div class="endpoint-description">Получение информации о конкретной категории по её идентификатору.</div>
               <div class="endpoint-authorization">Требуется авторизация по токену</div>
           </div>
           <div class="endpoint">
               <div class="endpoint-method">POST /api/categories</div>
               <div class="endpoint-description">Создание новой категории.</div>
               <div class="endpoint-authorization">Требуется авторизация по токену</div>
           </div>
           <div class="endpoint">
               <div class="endpoint-method">PUT /api/categories/{id}</div>
               <div class="endpoint-description">Обновление информации о категории по её идентификатору.</div>
               <div class="endpoint-authorization">Требуется авторизация по токену</div>
           </div>
           <div class="endpoint">
               <div class="endpoint-method">DELETE /api/categories/{id}</div>
               <div class="endpoint-description">Удаление категории по её идентификатору.</div>
               <div class="endpoint-authorization">Требуется авторизация по токену</div>
           </div>
       </div>

       <div class="section">
           <h2 class="section-title">Токены</h2>
           <p>Эндпоинты для управления токенами:</p>
           <div class="endpoint">
               <div class="endpoint-method">GET /api/tokens</div>
               <div class="endpoint-description">Получение списка всех токенов.</div>
               <div class="endpoint-authorization">Требуется авторизация по токену</div>
           </div>
           <div class="endpoint">
               <div class="endpoint-method">GET /api/tokens/{id}</div>
               <div class="endpoint-description">Получение информации о конкретном токене по его идентификатору.</div>
               <div class="endpoint-authorization">Требуется авторизация по токену</div>
           </div>
           <div class="endpoint">
               <div class="endpoint-method">POST /api/tokens</div>
               <div class="endpoint-description">Создание нового токена.</div>
               <div class="endpoint-authorization">Требуется авторизация по токену</div>
           </div>
           <div class="endpoint">
               <div class="endpoint-method">PUT /api/tokens/{id}</div>
               <div class="endpoint-description">Обновление информации о токене по его идентификатору.</div>
               <div class="endpoint-authorization">Требуется авторизация по токену</div>
           </div>
           <div class="endpoint">
               <div class="endpoint-method">DELETE /api/tokens/{id}</div>
               <div class="endpoint-description">Удаление токена по его идентификатору.</div>
               <div class="endpoint-authorization">Требуется авторизация по токену</div>
           </div>
           <table class="error-table">
               <thead>
                   <tr>
                       <th>Код ошибки</th>
                       <th>Описание</th>
                   </tr>
               </thead>
               <tbody>
                   <tr>
                       <td>400</td>
                       <td>Неверный запрос. Проверьте правильность отправленных данных.</td>
                   </tr>
                   <tr>
                       <td>401</td>
                       <td>Ошибка авторизации. Требуется авторизация пользователя.</td>
                   </tr>
                   <tr>
                       <td>403</td>
                       <td>Доступ запрещен. У вас нет прав для выполнения данного действия.</td>
                   </tr>
                   <tr>
                       <td>404</td>
                       <td>Ресурс не найден. Проверьте правильность указанного пути.</td>
                   </tr>
                   <tr>
                       <td>500</td>
                       <td>Внутренняя ошибка сервера. Попробуйте выполнить запрос позже.</td>
                   </tr>
               </tbody>
           </table>
       </div>
       <a href="index.php" class="btn btn-primary btn-home">На главную</a>
   </div>
</body>
</html>
