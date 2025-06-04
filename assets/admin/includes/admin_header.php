<?php
session_start();

require_once __DIR__ . '/../../../includes/functions.php';

// Проверка авторизации
if (!is_logged_in()) {
    redirect_with_message('/login.php', 'Требуется авторизация', 'error');
}

// Проверка прав администратора
if (!has_role('admin')) {
    redirect_with_message('/', 'Доступ запрещен', 'error');
}

// Получаем информацию о текущем пользователе
$pdo = get_db_connection();
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$current_user = $stmt->fetch();

// Проверка бана пользователя
if ($current_user['is_banned']) {
    session_destroy();
    redirect_with_message('/login.php', 'Ваш аккаунт заблокирован', 'error');
}

// Получаем настройки сайта
$settings = $pdo->query("SELECT setting_key, setting_value FROM settings")->fetchAll(PDO::FETCH_KEY_PAIR);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель | <?= e($settings['site_name'] ?? 'ТОП Сервис') ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <?php include __DIR__ . '/admin_navbar.php'; ?>
        <div class="admin-content">