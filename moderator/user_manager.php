<?php
// C:\Program Files\Ampps\www\moderator\user_manager.php

require_once __DIR__ . '/../includes/db_connect.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

// Проверка прав (только модератор или админ)
if (!is_logged_in() || ($_SESSION['user']['role'] !== 'moderator' && $_SESSION['user']['role'] !== 'admin')) {
    header("HTTP/1.0 403 Forbidden");
    exit("Доступ запрещен");
}

// Получение списка пользователей (кроме админов)
$users = [];
try {
    $stmt = $db->prepare("
        SELECT id, username, email, role, is_banned, created_at 
        FROM users 
        WHERE role != 'admin'
        ORDER BY created_at DESC
    ");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Ошибка загрузки пользователей: " . $e->getMessage());
    $_SESSION['error'] = "Ошибка загрузки данных";
}

// Обработка действий
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $user_id = (int)($_POST['user_id'] ?? 0);

    try {
        switch ($action) {
            case 'change_role':
                $new_role = $_POST['new_role'];
                $db->prepare("UPDATE users SET role = ? WHERE id = ? AND role != 'admin'")
                   ->execute([$new_role, $user_id]);
                $_SESSION['success'] = "Роль пользователя изменена";
                break;
                
            case 'toggle_ban':
                $current_status = $db->query("SELECT is_banned FROM users WHERE id = $user_id")->fetchColumn();
                $new_status = $current_status ? 0 : 1;
                $db->exec("UPDATE users SET is_banned = $new_status WHERE id = $user_id AND role != 'admin'");
                $_SESSION['success'] = $new_status ? "Пользователь заблокирован" : "Пользователь разблокирован";
                break;
        }
        
        header("Location: user_manager.php");
        exit;
    } catch (PDOException $e) {
        error_log("Ошибка обработки: " . $e->getMessage());
        $_SESSION['error'] = "Ошибка выполнения действия";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Управление пользователями | Панель модератора</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <style>
        .banned { background-color: #ffe6e6; }
        .user-card { border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <?php include '../includes/admin_header.php'; ?>

    <div class="admin-container">
        <h1>Управление пользователями</h1>

        <!-- Вывод сообщений -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= e($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= e($_SESSION['success']) ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <div class="user-list">
            <?php foreach ($users as $user): ?>
                <div class="user-card <?= $user['is_banned'] ? 'banned' : '' ?>">
                    <h3><?= e($user['username']) ?></h3>
                    <p>Email: <?= e($user['email']) ?></p>
                    <p>Роль: <?= e($user['role']) ?></p>
                    <p>Дата регистрации: <?= date('d.m.Y H:i', strtotime($user['created_at'])) ?></p>
                    <p>Статус: <?= $user['is_banned'] ? '❌ Заблокирован' : '✅ Активен' ?></p>
                    
                    <div class="user-actions">
                        <!-- Форма смены роли -->
                        <form method="POST" class="inline-form">
                            <input type="hidden" name="user_id" value="<?= e($user['id']) ?>">
                            <select name="new_role" class="role-select">
                                <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>Пользователь</option>
                                <option value="moderator" <?= $user['role'] === 'moderator' ? 'selected' : '' ?>>Модератор</option>
                            </select>
                            <button type="submit" name="action" value="change_role" class="btn btn-sm">Изменить роль</button>
                        </form>

                        <!-- Форма бана/разбана -->
                        <form method="POST" class="inline-form">
                            <input type="hidden" name="user_id" value="<?= e($user['id']) ?>">
                            <button type="submit" name="action" value="toggle_ban" class="btn btn-sm <?= $user['is_banned'] ? 'btn-success' : 'btn-warning' ?>">
                                <?= $user['is_banned'] ? 'Разблокировать' : 'Заблокировать' ?>
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php include '../includes/admin_footer.php'; ?>

    <script>
        // Подтверждение опасных действий
        document.querySelectorAll('form').forEach(form => {
            if (form.querySelector('[name="action"][value="toggle_ban"]')) {
                form.addEventListener('submit', function(e) {
                    const button = this.querySelector('[type="submit"]');
                    if (!confirm(`Вы уверены, что хотите ${button.textContent.trim()} этого пользователя?`)) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>
</body>
</html>