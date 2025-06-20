<?php
$servername = '95.165.74.49';
$username = 'Anastasia';
$password = "hwos80(Z/Mfkk[xC";
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
