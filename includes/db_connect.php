<?php
$servername = 'localhost';
$username = 'root';
$password = "mysql";
$dbname = 'topservice_db';

// Создаем соединение MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем соединение
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Устанавливаем кодировку
$conn->set_charset("utf8");
?>