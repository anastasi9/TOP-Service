<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'moderator') {
    header('Location: ../login.php');
    exit();
}
// Подключение к БД
require_once '../../includes/db_connect.php';

// Получение количества лидов
$lead_count = 0;
$sql = "SELECT COUNT(*) as total FROM leads";
$result = $conn->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $lead_count = $row['total'];
}

// Получение количества пользователей (без админов)
$user_count = 0;
$sql = "SELECT COUNT(*) as total FROM users WHERE role != 'admin'";
$result = $conn->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $user_count = $row['total'];
}

// Пример последних действий
$recent_activities = [
    ['username' => 'moderator1', 'action' => 'Проверен пользователь user123', 'time' => date('Y-m-d H:i', strtotime('-1 hour'))],
    ['username' => 'moderator1', 'action' => 'Одобрена заявка #456', 'time' => date('Y-m-d H:i', strtotime('-3 hours'))],
    ['username' => 'moderator1', 'action' => 'Отклонен комментарий', 'time' => date('Y-m-d H:i', strtotime('-5 hours'))],
];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Панель модератора</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/admin.css?v=<?= time() ?>">

</head>
<body>

<div class="admin-container">
<div class="sidebar">
    <h2>Панель управления</h2>
    <a href="/assets/moderator/moderator.php" <?= basename($_SERVER['PHP_SELF']) === 'moderator.php' ? 'class="active"' : '' ?>>
        <i class="fas fa-tachometer-alt"></i> Главная
    </a>
    <a href="/assets/admin/user_management/list_users.php" <?= basename($_SERVER['PHP_SELF']) === 'list_users.php' ? 'class="active"' : '' ?>>
        <i class="fas fa-users"></i> Пользователи
    </a>
    <a href="/assets/admin/leads.php" <?= basename($_SERVER['PHP_SELF']) === 'leads.php' ? 'class="active"' : '' ?>>
        <i class="fas fa-tachometer-alt"></i> Лиды
    </a>
        <a href="/assets/admin/helpline/helpline.php" <?= basename($_SERVER['PHP_SELF']) === 'helpline.php' ? 'class="active"' : '' ?>>
            <i class="fas fa-tachometer-alt"></i> Заявки
        </a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="dashboard-header">
            <h1><i class="fas fa-user-shield"></i> Модератор</h1>
            <div class="user-info">

                <a href="/logout.php" class="logout-btn">Выйти</a>
            </div>
        </div>

        <!-- Статистика -->
        <div class="stats-grid">
            <div class="stat-card moderator-card">
                <div class="stat-icon"><i class="fas fa-user-check"></i></div>
                <div class="stat-content">
                    <h3>Пользователи</h3>
                    <p><?= $user_count ?></p>
                    <a href="user_management\list_users.php" class="stat-link">Проверить <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-user-tag"></i></div>
                <div class="stat-content">
                    <h3>Лиды</h3>
                    <p><?= $lead_count ?></p>
                    <a href="/assets/admin/leads.php" class="stat-link">Просмотр <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-clipboard-list"></i></div>
                <div class="stat-content">
                    <h3>Заявки</h3>
                    <p>5</p>
                    <a href="../../assets/admin/helpline/helpline.php" class="stat-link">Просмотр <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            
            
        <!-- Последние действия -->
        <div class="recent-activity">
            <h3><i class="fas fa-history"></i> Ваши последние действия</h3>
            <?php if (!empty($recent_activities)): ?>
                <?php foreach ($recent_activities as $activity): ?>
                    <div class="activity-item">
                        <div class="activity-icon"><i class="fas fa-user-shield"></i></div>
                        <div class="activity-details">
                            <p class="activity-user"><?= htmlspecialchars($activity['username']) ?></p>
                            <p class="activity-action"><?= htmlspecialchars($activity['action']) ?></p>
                            <small class="activity-time"><?= date('d.m.Y H:i', strtotime($activity['time'])) ?></small>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-activity">Нет записей о действиях.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>