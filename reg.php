<?php
header('Content-Type: application/json; charset=utf-8');

// Настройки БД
$servername = "127.0.0.1";
$dbUsername = "your_user_name";
$dbPassword = "password";
$dbName     = "first";

// Подключаемся
$link = mysqli_connect($servername, $dbUsername, $dbPassword, $dbName);
if (!$link) {
    echo json_encode(['success' => false, 'error' => mysqli_connect_error()]);
    exit;
}

// Проверим и создадим таблицу users, если нет
$tableSql = "
CREATE TABLE IF NOT EXISTS users (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
";
if (!mysqli_query($link, $tableSql)) {
    echo json_encode(['success' => false, 'error' => mysqli_error($link)]);
    exit;
}

// Получаем данные из POST
$username = trim($_POST['username'] ?? '');
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Базовая валидация
if (mb_strlen($username) < 3 || !filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($password) < 6) {
    echo json_encode(['success' => false, 'error' => 'Неверные данные.']);
    exit;
}

// Хэшируем пароль
$hash = password_hash($password, PASSWORD_DEFAULT);

// Подготовленный запрос
$stmt = mysqli_prepare($link, "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hash);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['success' => true]);
} else {
    // Ошибка вставки (в т.ч. дубли уникального поля)
    $err = mysqli_error($link);
    echo json_encode(['success' => false, 'error' => $err]);
}

mysqli_stmt_close($stmt);
mysqli_close($link);

