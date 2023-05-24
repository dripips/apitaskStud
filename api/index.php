<?php

require '../data/config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Проверка заголовка Content-Type на наличие JSON
    $contentType = isset($_SERVER['CONTENT_TYPE']) ? trim($_SERVER['CONTENT_TYPE']) : '';
    if ($contentType === 'application/json') {
        // Получение данных из тела запроса в виде массива
        $_POST = json_decode(file_get_contents('php://input'), true);
    } else {
        // Получение данных из стандартного механизма формы
        $_POST = $_POST ?? [];
    }

    // Ваш код обработки POST-запроса
    // ...
}
// Функция для проверки токена
function authenticateToken($token) {
    global $pdo;
    $token = trim(str_replace('Bearer', '', $token));
    $query = 'SELECT COUNT(*) FROM admins WHERE token = :token';

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':token', $token, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    } catch (PDOException $e) {
        echo 'Error checking token: ' . $e->getMessage();
        return false;
    }
}

// Эндпоинт для авторизации пользователя
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/api/auth/login') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Поиск пользователя по имени пользователя
    $query = 'SELECT * FROM admins WHERE username = :username';

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {
            // Генерация и сохранение нового токена для авторизации
            $token = bin2hex(random_bytes(32));
            $query = 'UPDATE admins SET token = :token WHERE id = :adminId';

            try {
                $stmt = $pdo->prepare($query);
                $stmt->bindValue(':token', $token, PDO::PARAM_STR);
                $stmt->bindValue(':adminId', $admin['id'], PDO::PARAM_INT);
                $stmt->execute();

                $response = [
                    'admin' => $admin,
                    'token' => $token
                ];
                echo json_encode($response);
            } catch (PDOException $e) {
                echo json_encode(['error' => 'Error updating token']);
            }
        } else {
            echo json_encode(['error' => 'Invalid username or password']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error logging in']);
    }
    exit;
}

// Эндпоинт для регистрации нового пользователя
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/api/auth/register') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // $data = json_decode(file_get_contents('php://input'), true);
    // var_dump($data);
    // Проверка, что пользователь с указанным именем не существует
    $query = 'SELECT COUNT(*) FROM admins WHERE username = :username';

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            echo json_encode(['error' => 'Username already exists']);
            exit;
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error registering user']);
        exit;
    }

    // Регистрация нового пользователя
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Хеширование пароля
    $token = bin2hex(random_bytes(32)); // Генерация токена

    $query = 'INSERT INTO admins (username, password, token) VALUES (:username, :password, :token)';

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindValue(':token', $token, PDO::PARAM_STR);
        $stmt->execute();

        $adminId = $pdo->lastInsertId();
        $response = [
            'id' => $adminId,
            'username' => $username,
            'token' => $token
        ];
        echo json_encode($response);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error registering user']);
    }
    exit;
}

// Эндпоинт для получения списка всех пользователей
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/api/users') {
    $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (!$token || !authenticateToken($token)) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid token']);
        exit;
    }

    $query = 'SELECT * FROM users';

    try {
        $stmt = $pdo->query($query);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($users);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error retrieving users']);
    }
    exit;
}

// Эндпоинт для получения информации о конкретном пользователе по его идентификатору
if ($_SERVER['REQUEST_METHOD'] === 'GET' && preg_match('/^\/api\/users\/(\d+)$/', $_SERVER['REQUEST_URI'], $matches)) {
    $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

    if (!$token || !authenticateToken($token)) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid token']);
        exit;
    }

    $userId = $matches[1];
    $query = 'SELECT * FROM users WHERE id = :userId';

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error retrieving user']);
    }
    exit;
}

// Эндпоинт для создания нового пользователя
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/api/users') {
    $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

    if (!$token || !authenticateToken($token)) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid token']);
        exit;
    }

    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';

    $query = 'INSERT INTO users (username, email) VALUES (:username, :email)';

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $userId = $pdo->lastInsertId();
        $response = [
            'id' => $userId,
            'username' => $username,
            'email' => $email
        ];
        echo json_encode($response);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error creating user']);
    }
    exit;
}

// Эндпоинт для обновления информации о пользователе по его идентификатору
if ($_SERVER['REQUEST_METHOD'] === 'PUT' && preg_match('/^\/api\/users\/(\d+)$/', $_SERVER['REQUEST_URI'], $matches)) {
    $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

    if (!$token || !authenticateToken($token)) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid token']);
        exit;
    }

    $userId = $matches[1];
    $fieldsToUpdate = [];

    // Проверка и обработка переданных полей
    if (isset($_POST['full_name'])) {
        $fieldsToUpdate[] = 'full_name = :full_name';
    }
    if (isset($_POST['email'])) {
        $fieldsToUpdate[] = 'email = :email';
    }
    if (isset($_POST['phone_number'])) {
        $fieldsToUpdate[] = 'phone_number = :phone_number';
    }
    if (isset($_POST['date_of_birth'])) {
        $fieldsToUpdate[] = 'date_of_birth = :date_of_birth';
    }
    if (isset($_POST['balance'])) {
        $fieldsToUpdate[] = 'balance = :balance';
    }

    if (empty($fieldsToUpdate)) {
        http_response_code(400);
        echo json_encode(['error' => 'No fields to update']);
        exit;
    }

    $updateFieldsString = implode(', ', $fieldsToUpdate);
    $query = "UPDATE users SET $updateFieldsString WHERE id = :userId";

    try {
        $stmt = $pdo->prepare($query);

        if (isset($_POST['full_name'])) {
            $stmt->bindValue(':full_name', $_POST['full_name'], PDO::PARAM_STR);
        }
        if (isset($_POST['email'])) {
            $stmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        }
        if (isset($_POST['phone_number'])) {
            $stmt->bindValue(':phone_number', $_POST['phone_number'], PDO::PARAM_STR);
        }
        if (isset($_POST['date_of_birth'])) {
            $stmt->bindValue(':date_of_birth', $_POST['date_of_birth'], PDO::PARAM_STR);
        }
        if (isset($_POST['balance'])) {
            $stmt->bindValue(':balance', $_POST['balance'], PDO::PARAM_INT);
        }

        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $response = ['id' => $userId];

        if (in_array('full_name = :full_name', $fieldsToUpdate)) {
            $response['full_name'] = $_POST['full_name'];
        }
        if (in_array('email = :email', $fieldsToUpdate)) {
            $response['email'] = $_POST['email'];
        }
        if (in_array('phone_number = :phone_number', $fieldsToUpdate)) {
            $response['phone_number'] = $_POST['phone_number'];
        }
        if (in_array('date_of_birth = :date_of_birth', $fieldsToUpdate)) {
            $response['date_of_birth'] = $_POST['date_of_birth'];
        }
        if (in_array('balance = :balance', $fieldsToUpdate)) {
            $response['balance'] = $_POST['balance'];
        }

        echo json_encode($response);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error updating user']);
    }
    exit;
}


// Эндпоинт для удаления пользователя по его идентификатору
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && preg_match('/^\/api\/users\/(\d+)$/', $_SERVER['REQUEST_URI'], $matches)) {
    $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

    if (!$token || !authenticateToken($token)) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid token']);
        exit;
    }

    $userId = $matches[1];
    $query = 'DELETE FROM users WHERE id = :userId';

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(['message' => 'User deleted']);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error deleting user']);
    }
    exit;
}

// Эндпоинт для получения списка всех транзакций
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/api/transactions') {
    $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

    if (!$token || !authenticateToken($token)) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid token']);
        exit;
    }

    $query = 'SELECT * FROM transactions';

    try {
        $stmt = $pdo->query($query);
        $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($transactions);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error retrieving transactions']);
    }
    exit;
}

// Эндпоинт для получения информации о конкретной транзакции по её идентификатору
if ($_SERVER['REQUEST_METHOD'] === 'GET' && preg_match('/^\/api\/transactions\/(\d+)$/', $_SERVER['REQUEST_URI'], $matches)) {
    $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

    if (!$token || !authenticateToken($token)) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid token']);
        exit;
    }

    $transactionId = $matches[1];
    $query = 'SELECT * FROM transactions WHERE id = :transactionId';

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':transactionId', $transactionId, PDO::PARAM_INT);
        $stmt->execute();
        $transaction = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($transaction !== false) {
            echo json_encode($transaction);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Transaction not found']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error retrieving transaction']);
    }
    exit;
}

// Эндпоинт для создания новой транзакции
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/api/transactions') {
    $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

    if (!$token || !authenticateToken($token)) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid token']);
        exit;
    }

    $userId = $_POST['user_id'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $description = $_POST['description'] ?? '';

    $query = 'INSERT INTO transactions (user_id, amount, description) VALUES (:userId, :amount, :description)';

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':amount', $amount, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->execute();

        $transactionId = $pdo->lastInsertId();
        $response = [
            'id' => $transactionId,
            'user_id' => $userId,
            'amount' => $amount,
            'description' => $description
        ];
        echo json_encode($response);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error creating transaction']);
    }
    exit;
}

// Эндпоинт для обновления информации о транзакции по её идентификатору
if ($_SERVER['REQUEST_METHOD'] === 'PUT' && preg_match('/^\/api\/transactions\/(\d+)$/', $_SERVER['REQUEST_URI'], $matches)) {
    $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

    if (!$token || !authenticateToken($token)) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid token']);
        exit;
    }

    $transactionId = $matches[1];
    $amount = $_POST['amount'] ?? '';
    $description = $_POST['description'] ?? '';

    $query = 'UPDATE transactions SET amount = :amount, description = :description WHERE id = :transactionId';

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':amount', $amount, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':transactionId', $transactionId, PDO::PARAM_INT);
        $stmt->execute();
        http_response_code(204);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error updating transaction']);
    }
    exit;
}

// Эндпоинт для удаления транзакции по её идентификатору
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && preg_match('/^\/api\/transactions\/(\d+)$/', $_SERVER['REQUEST_URI'], $matches)) {
    $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

    if (!$token || !authenticateToken($token)) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid token']);
        exit;
    }

    $transactionId = $matches[1];

    $query = 'DELETE FROM transactions WHERE id = :transactionId';

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':transactionId', $transactionId, PDO::PARAM_INT);
        $stmt->execute();
        http_response_code(204);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error deleting transaction']);
    }
    exit;
}

// Эндпоинт для получения списка всех категорий
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/api/categories') {
    $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

    if (!$token || !authenticateToken($token)) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid token']);
        exit;
    }

    $query = 'SELECT * FROM categories';

    try {
        $stmt = $pdo->query($query);
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($categories);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error retrieving categories']);
    }
    exit;
}

// Эндпоинт для получения информации о конкретной категории по её идентификатору
if ($_SERVER['REQUEST_METHOD'] === 'GET' && preg_match('/^\/api\/categories\/(\d+)$/', $_SERVER['REQUEST_URI'], $matches)) {
    $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

    if (!$token || !authenticateToken($token)) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid token']);
        exit;
    }

    $categoryId = $matches[1];
    $query = 'SELECT * FROM categories WHERE id = :categoryId';

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($category !== false) {
            echo json_encode($category);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Category not found']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error retrieving category']);
    }
    exit;
}

// Эндпоинт для создания новой категории
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/api/categories') {
    $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

    if (!$token || !authenticateToken($token)) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid token']);
        exit;
    }

    $name = $_POST['name'] ?? '';

    $query = 'INSERT INTO categories (name) VALUES (:name)';

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->execute();

        $categoryId = $pdo->lastInsertId();
        $response = [
            'id' => $categoryId,
            'name' => $name
        ];
        echo json_encode($response);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error creating category']);
    }
    exit;
}

// Эндпоинт для обновления информации о категории по её идентификатору
if ($_SERVER['REQUEST_METHOD'] === 'PUT' && preg_match('/^\/api\/categories\/(\d+)$/', $_SERVER['REQUEST_URI'], $matches)) {
    $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

    if (!$token || !authenticateToken($token)) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid token']);
        exit;
    }

    $categoryId = $matches[1];
    $name = $_POST['name'] ?? '';

    $query = 'UPDATE categories SET name = :name WHERE id = :categoryId';

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        http_response_code(204);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error updating category']);
    }
    exit;
}

// Эндпоинт для удаления категории по её идентификатору
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && preg_match('/^\/api\/categories\/(\d+)$/', $_SERVER['REQUEST_URI'], $matches)) {
    $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

    if (!$token || !authenticateToken($token)) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid token']);
        exit;
    }

    $categoryId = $matches[1];

    $query = 'DELETE FROM categories WHERE id = :categoryId';

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
        http_response_code(204);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error deleting category']);
    }
    exit;
}


?>
