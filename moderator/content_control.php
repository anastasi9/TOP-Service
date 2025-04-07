<?php
// C:\Program Files\Ampps\www\moderator\content_control.php

require_once __DIR__ . '/../includes/db_connect.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

// Проверка прав (только модератор или админ)
if (!is_logged_in() || ($_SESSION['user']['role'] !== 'moderator' && $_SESSION['user']['role'] !== 'admin')) {
    header("HTTP/1.0 403 Forbidden");
    exit("Доступ запрещен");
}

// Получение списка материалов
$content = [];
try {
    $stmt = $db->query("
        SELECT c.*, u.username as author 
        FROM content c
        JOIN users u ON c.user_id = u.id
        ORDER BY c.created_at DESC
    ");
    $content = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Ошибка загрузки контента: " . $e->getMessage());
    $_SESSION['error'] = "Ошибка загрузки данных";
}

// Обработка действий
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $content_id = (int)($_POST['content_id'] ?? 0);

    try {
        switch ($action) {
            case 'approve':
                $db->prepare("UPDATE content SET status = 'approved' WHERE id = ?")->execute([$content_id]);
                $_SESSION['success'] = "Материал одобрен";
                break;
                
            case 'reject':
                $db->prepare("UPDATE content SET status = 'rejected' WHERE id = ?")->execute([$content_id]);
                $_SESSION['success'] = "Материал отклонен";
                break;
                
            case 'delete':
                $db->prepare("DELETE FROM content WHERE id = ?")->execute([$content_id]);
                $_SESSION['success'] = "Материал удален";
                break;
        }
        
        header("Location: content_control.php");
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
    <title>Управление контентом | Панель модератора</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <style>
        .content-item { border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; }
        .pending { background-color: #fff3cd; }
        .approved { background-color: #d4edda; }
        .rejected { background-color: #f8d7da; }
    </style>
</head>
<body>
    <?php include '../includes/admin_header.php'; ?>

    <div class="admin-container">
        <h1>Управление контентом</h1>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= e($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= e($_SESSION['success']) ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <div class="content-list">
            <?php foreach ($content as $item): ?>
                <div class="content-item <?= e($item['status']) ?>">
                    <h3><?= e($item['title']) ?></h3>
                    <p>Автор: <?= e($item['author']) ?></p>
                    <p>Дата: <?= date('d.m.Y H:i', strtotime($item['created_at'])) ?></p>
                    <p>Статус: <?= e($item['status']) ?></p>
                    
                    <div class="content-actions">
                        <form method="POST" style="display: inline-block;">
                            <input type="hidden" name="content_id" value="<?= e($item['id']) ?>">
                            
                            <?php if ($item['status'] !== 'approved'): ?>
                                <button type="submit" name="action" value="approve" class="btn btn-success">Одобрить</button>
                            <?php endif; ?>
                            
                            <?php if ($item['status'] !== 'rejected'): ?>
                                <button type="submit" name="action" value="reject" class="btn btn-warning">Отклонить</button>
                            <?php endif; ?>
                            
                            <button type="submit" name="action" value="delete" class="btn btn-danger" 
                                onclick="return confirm('Удалить этот материал?')">Удалить</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php include '../includes/admin_footer.php'; ?>
</body>
</html>