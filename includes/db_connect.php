<?php
// Правильные параметры для AMPPS
$host = 'localhost';
$dbname = 'topservice_db'; // имя вашей БД
$username = 'root';       // стандартный пользователь AMPPS
$password = 'mysql';      // стандартный пароль AMPPS

try {
    $db = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}
