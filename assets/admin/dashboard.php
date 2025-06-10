<?php
require_once __DIR__ . '/includes/admin_header.php';

// Статистика для дашборда
$users_count = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$active_users = $users_count;
$content_items = $pdo->query("SELECT COUNT(*) FROM content")->fetchColumn();
$recent_activities = $pdo->query("SELECT a.*, u.username 
                                 FROM activity_log a 
                                 LEFT JOIN users u ON a.user_id = u.id 
                                 ORDER BY a.created_at DESC 
                                 LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
?>
<h1>Административная панель</h1>

<div class="admin-stats">
    <div class="stat-card">
        <h3>Пользователи</h3>
        <p><?= $users_count ?></p>
    </div>
    <div class="stat-card">
        <h3>Активные</h3>
        <p><?= $active_users ?></p>
    </div>
    <div class="stat-card">
        <h3>Элементы контента</h3>
        <p><?= $content_items ?></p>
    </div>
</div>

<div class="recent-activity">
    <h2>Последние действия</h2>
    <table>
        <thead>
            <tr>
                <th>Время</th>
                <th>Пользователь</th>
                <th>Действие</th>
                <th>Детали</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recent_activities as $activity): ?>
            <tr>
                <td><?= date('d.m.Y H:i', strtotime($activity['created_at'])) ?></td>
                <td><?= htmlspecialchars($activity['username'] ?? 'Система') ?></td>
                <td><?= htmlspecialchars($activity['action']) ?></td>
                <td><?= htmlspecialchars($activity['details']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

