<?php
require 'data/config.php';

// Функция для проверки токена
function authenticateToken($token) {
    global $pdo;

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

// Функция для авторизации пользователя
function loginUser($username, $password) {
    global $pdo;

    $query = 'SELECT * FROM admins WHERE username = :username';

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {
            // Генерация и сохранение нового токена для авторизации
            $token = generateToken();
            saveToken($admin['id'], $token);

            // Возвращение информации об администраторе и токена
            $response = [
                'admin' => $admin,
                'token' => $token
            ];
            return $response;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        echo 'Error logging in: ' . $e->getMessage();
        return false;
    }
}

// Функция для регистрации нового пользователя
function registerUser($username, $password) {
    global $pdo;

    $token = generateToken(); // Генерация токена
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Шифрование пароля

    $query = 'INSERT INTO admins (username, password, token) VALUES (:username, :password, :token)'; // Добавление поля token

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR); // Используем шифрованный пароль
        $stmt->bindValue(':token', $token, PDO::PARAM_STR); // Привязка значения токена
        $stmt->execute();

        // Возвращение информации о новом администраторе и токене
        $adminId = $pdo->lastInsertId();
        $response = [
            'id' => $adminId,
            'username' => $username,
            'token' => $token
        ];
        return $response;
    } catch (PDOException $e) {
        echo 'Error registering user: ' . $e->getMessage();
        return false;
    }
}

// Функция для генерации токена
function generateToken() {
    return bin2hex(random_bytes(32));
}

// Функция для сохранения токена в базе данных
function saveToken($adminId, $token) {
    global $pdo;

    $query = 'UPDATE admins SET token = :token WHERE id = :adminId';

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':token', $token, PDO::PARAM_STR);
        $stmt->bindValue(':adminId', $adminId, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo 'Error saving token: ' . $e->getMessage();
    }
}

// Функция для получения списка всех токенов
function getAllTokens() {
    global $pdo;

    $query = 'SELECT * FROM tokens';

    try {
        $stmt = $pdo->query($query);
        $tokens = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $tokens;
    } catch (PDOException $e) {
        echo 'Error retrieving tokens: ' . $e->getMessage();
        return [];
    }
}

// Функция для получения информации о конкретном токене по его идентификатору
function getTokenById($tokenId) {
    global $pdo;

    $query = 'SELECT * FROM tokens WHERE id = :tokenId';

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':tokenId', $tokenId, PDO::PARAM_INT);
        $stmt->execute();
        $token = $stmt->fetch(PDO::FETCH_ASSOC);
        return $token;
    } catch (PDOException $e) {
        echo 'Error retrieving token: ' . $e->getMessage();
        return null;
    }
}

// Функция для создания нового токена
function createToken() {
    global $pdo;

    $token = generateToken();

    $query = 'INSERT INTO tokens (token) VALUES (:token)';

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':token', $token, PDO::PARAM_STR);
        $stmt->execute();

        $tokenId = $pdo->lastInsertId();
        $response = [
            'id' => $tokenId,
            'token' => $token
        ];
        return $response;
    } catch (PDOException $e) {
        echo 'Error creating token: ' . $e->getMessage();
        return false;
    }
}

// Функция для обновления информации о токене по его идентификатору
function updateToken($tokenId, $newToken) {
    global $pdo;

    $query = 'UPDATE tokens SET token = :newToken WHERE id = :tokenId';

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':newToken', $newToken, PDO::PARAM_STR);
        $stmt->bindValue(':tokenId', $tokenId, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        echo 'Error updating token: ' . $e->getMessage();
        return false;
    }
}

// Функция для удаления токена по его идентификатору
function deleteToken($tokenId) {
    global $pdo;

    $query = 'DELETE FROM tokens WHERE id = :tokenId';

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':tokenId', $tokenId, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        echo 'Error deleting token: ' . $e->getMessage();
        return false;
    }
}

// Функция для получения данных пользователей
function getUsersFromDatabase($filters = []) {
    global $pdo;

    // Проверка наличия и правильности токена
    $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (!$token || !authenticateToken($token)) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid token']);
        exit;
    }

    $query = 'SELECT * FROM users';
    $params = [];

    // Проверяем наличие фильтров и создаем условия для запроса
    if (!empty($filters)) {
        $conditions = [];

        // Фильтр по ФИО
        if (isset($filters['name'])) {
            $conditions[] = 'name LIKE :name';
            $params['name'] = '%' . $filters['name'] . '%';
        }

        // Фильтр по дате рождения
        if (isset($filters['birthday'])) {
            $conditions[] = 'birthday = :birthday';
            $params['birthday'] = $filters['birthday'];
        }

        // Фильтр по номеру телефона
        if (isset($filters['phone'])) {
            $conditions[] = 'phone LIKE :phone';
            $params['phone'] = '%' . $filters['phone'] . '%';
        }

        // Фильтр по балансу
        if (isset($filters['balance'])) {
            $conditions[] = 'balance >= :balance';
            $params['balance'] = $filters['balance'];
        }

        // Формируем полный запрос с условиями
        if (!empty($conditions)) {
            $query .= ' WHERE ' . implode(' AND ', $conditions);
        }
    }

    // Выполняем запрос с параметрами
    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    } catch (PDOException $e) {
        echo 'Error retrieving users: ' . $e->getMessage();
        return [];
    }
}

// Функция для получения данных транзакций
function getTransactionsFromDatabase() {
    global $pdo;

    // Проверка наличия и правильности токена
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
        return $transactions;
    } catch (PDOException $e) {
        echo 'Error retrieving transactions: ' . $e->getMessage();
        return [];
    }
}

// Функция для получения данных сотрудников
function getEmployeesFromDatabase() {
    global $pdo;

    // Проверка наличия и правильности токена
    $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (!$token || !authenticateToken($token)) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid token']);
        exit;
    }

    $query = 'SELECT * FROM employees';

    try {
        $stmt = $pdo->query($query);
        $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $employees;
    } catch (PDOException $e) {
        echo 'Error retrieving employees: ' . $e->getMessage();
        return [];
    }
}

// Функция для получения данных категорий
function getCategoriesFromDatabase() {
    global $pdo;

    // Проверка наличия и правильности токена
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
        return $categories;
    } catch (PDOException $e) {
        echo 'Error retrieving categories: ' . $e->getMessage();
        return [];
    }
}

// Функция для получения данных продуктов
function getProductsFromDatabase() {
    global $pdo;

    // Проверка наличия и правильности токена
    $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (!$token || !authenticateToken($token)) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid token']);
        exit;
    }

    $query = 'SELECT * FROM products';

    try {
        $stmt = $pdo->query($query);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    } catch (PDOException $e) {
        echo 'Error retrieving products: ' . $e->getMessage();
        return [];
    }
}

// Функция для получения данных заказов
function getOrdersFromDatabase() {
    global $pdo;

    // Проверка наличия и правильности токена
    $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (!$token || !authenticateToken($token)) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid token']);
        exit;
    }

    $query = 'SELECT * FROM orders';

    try {
        $stmt = $pdo->query($query);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $orders;
    } catch (PDOException $e) {
        echo 'Error retrieving orders: ' . $e->getMessage();
        return [];
    }
}

// Функция для получения данных элементов заказа
function getOrderItemsFromDatabase($orderId) {
    global $pdo;

    // Проверка наличия и правильности токена
    $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (!$token || !authenticateToken($token)) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid token']);
        exit;
    }

    $query = 'SELECT oi.*, p.name AS product_name FROM order_items AS oi
              INNER JOIN products AS p ON oi.product_id = p.id
              WHERE oi.order_id = :order_id';

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        $orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $orderItems;
    } catch (PDOException $e) {
        echo 'Error retrieving order items: ' . $e->getMessage();
        return [];
    }
}

// Определение типа запроса по параметру "action"
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        case 'users':
            $filters = $_GET['filters'] ?? [];
            $users = getUsersFromDatabase($filters);
            echo json_encode($users);
            break;
        case 'transactions':
            $transactions = getTransactionsFromDatabase();
            echo json_encode($transactions);
            break;
        case 'employees':
            $employees = getEmployeesFromDatabase();
            echo json_encode($employees);
            break;
        case 'categories':
            $categories = getCategoriesFromDatabase();
            echo json_encode($categories);
            break;
        case 'products':
            $products = getProductsFromDatabase();
            echo json_encode($products);
            break;
        case 'orders':
            $orders = getOrdersFromDatabase();
            echo json_encode($orders);
            break;
        case 'order-items':
            if (isset($_GET['order_id'])) {
                $orderId = $_GET['order_id'];
                $orderItems = getOrderItemsFromDatabase($orderId);
                echo json_encode($orderItems);
            } else {
                echo json_encode(['error' => 'Order ID is missing']);
            }
            break;
        case 'auth/login':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['username']) && isset($_POST['password'])) {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $response = loginUser($username, $password);
                    if ($response) {
                        echo json_encode($response);
                    } else {
                        echo json_encode(['error' => 'Invalid credentials']);
                    }
                } else {
                    echo json_encode(['error' => 'Missing username or password']);
                }
            } else {
                echo json_encode(['error' => 'Invalid request method']);
            }
            break;
        case 'auth/register':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['username']) && isset($_POST['password'])) {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $response = registerUser($username, $password);
                    if ($response) {
                        echo json_encode($response);
                    } else {
                        echo json_encode(['error' => 'Error registering user']);
                    }
                } else {
                    echo json_encode(['error' => 'Missing username or password']);
                }
            } else {
                echo json_encode(['error' => 'Invalid request method']);
            }
            break;
        case 'tokens':
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                // Получение списка всех токенов
                $tokens = getAllTokens();
                echo json_encode($tokens);
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Создание нового токена
                $response = createToken();
                if ($response) {
                    echo json_encode($response);
                } else {
                    echo json_encode(['error' => 'Error creating token']);
                }
            } else {
                echo json_encode(['error' => 'Invalid request method']);
            }
            break;
        case 'tokens/{id}':
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                // Получение информации о конкретном токене
                $tokenId = $_GET['id'];
                $token = getTokenById($tokenId);
                if ($token) {
                    echo json_encode($token);
                } else {
                    echo json_encode(['error' => 'Token not found']);
                }
            } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
                // Обновление информации о токене
                $tokenId = $_GET['id'];
                $newToken = generateToken();
                $success = updateToken($tokenId, $newToken);
                if ($success) {
                    echo json_encode(['message' => 'Token updated successfully']);
                } else {
                    echo json_encode(['error' => 'Error updating token']);
                }
            } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                // Удаление токена
                $tokenId = $_GET['id'];
                $success = deleteToken($tokenId);
                if ($success) {
                    echo json_encode(['message' => 'Token deleted successfully']);
                } else {
                    echo json_encode(['error' => 'Error deleting token']);
                }
            } else {
                echo json_encode(['error' => 'Invalid request method']);
            }
            break;
        default:
            echo json_encode(['error' => 'Invalid action']);
            break;
    }
} else {
    echo json_encode(['error' => 'Action parameter is missing']);
}
