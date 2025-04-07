<?php
// C:\Program Files\Ampps\www\admin\system_settings.php

require_once '../includes/db_connect.php';
require_once '../includes/auth.php';
require_once '../includes/check_role.php';

// Только для админов
if ($_SESSION['user']['role'] !== 'admin') {
    header("HTTP/1.0 403 Forbidden");
    exit("Доступ запрещен");
}

// Обработка сохранения настроек
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $site_title = htmlspecialchars($_POST['site_title']);
    $admin_email = filter_var($_POST['admin_email'], FILTER_VALIDATE_EMAIL);
    $items_per_page = (int)$_POST['items_per_page'];

    try {
        // Обновляем настройки в базе (пример для таблицы settings)
        $stmt = $db->prepare("REPLACE INTO settings (setting_key, setting_value) VALUES 
                            ('site_title', ?),
                            ('admin_email', ?),
                            ('items_per_page', ?)");
        $stmt->execute([$site_title, $admin_email, $items_per_page]);
        
        $_SESSION['success'] = "Настройки успешно сохранены";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Ошибка сохранения: " . $e->getMessage();
    }
}

// Получаем текущие настройки
$settings = [];
try {
    $stmt = $db->query("SELECT setting_key, setting_value FROM settings");
    $settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
} catch (PDOException $e) {
    $_SESSION['error'] = "Ошибка загрузки настроек: " . $e->getMessage();
}

// Установите значения по умолчанию, если их нет в БД
$site_title = $settings['site_title'] ?? 'ТОП-Сервис';
$admin_email = $settings['admin_email'] ?? 'admin@example.com';
$items_per_page = $settings['items_per_page'] ?? 10;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Настройки системы | Панель администратора</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <?php include '../includes/admin_header.php'; ?>

    <div class="admin-container">
        <h1>Настройки системы</h1>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Название сайта:</label>
                <input type="text" name="site_title" value="<?= htmlspecialchars($site_title) ?>" required>
            </div>

            <div class="form-group">
                <label>Email администратора:</label>
                <input type="email" name="admin_email" value="<?= htmlspecialchars($admin_email) ?>" required>
            </div>

            <div class="form-group">
                <label>Элементов на странице:</label>
                <input type="number" name="items_per_page" value="<?= $items_per_page ?>" min="5" max="50">
            </div>

            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>

    <?php include '../includes/admin_footer.php'; ?>
</body>
</html>