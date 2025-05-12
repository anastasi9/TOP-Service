<?php
require_once __DIR__ . '/../../includes/check_role.php';
require_once __DIR__ . '/../../includes/db_connect.php';

// Проверка прав администратора
checkRole('admin');

// Получаем информацию о текущем пользователе
$stmt = $pdo->prepare("SELECT id, username, email, role, is_banned FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$current_user = $stmt->fetch(PDO::FETCH_ASSOC);

// Если пользователь забанен (хотя это уже проверено в check_role)
if ($current_user['is_banned'] == 1) {
    session_destroy();
    /* header('Location: /login.php?banned=1'); */
    exit;
}

// Настройки сайта
$settings = $pdo->query("SELECT setting_key, setting_value FROM settings")->fetchAll(PDO::FETCH_KEY_PAIR);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель | <?= htmlspecialchars($settings['site_name'] ?? 'ТОП Сервис') ?></title>
    <link rel="stylesheet" href="/css/admin.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="admin-container">
        <?php include __DIR__ . '/admin_navbar.php'; ?>
        <div class="admin-content">