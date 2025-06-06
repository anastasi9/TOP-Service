<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// Пример данных для статистики
$user_count = 128;
$service_count = 24;
$active_requests = 15;

// Пример последних действий
$recent_activities = [
    ['username' => 'admin', 'action' => 'Создан новый пользователь', 'time' => '2025-04-05 14:30'],
    ['username' => 'manager', 'action' => 'Обновлена услуга "Ремонт"', 'time' => '2025-04-05 13:15'],
    ['username' => 'admin', 'action' => 'Удален запрос #123', 'time' => '2025-04-05 12:00'],
];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Административная панель</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>

<div class="admin-container">
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="#" class="active"><i class="fas fa-tachometer-alt"></i> Главная</a>
        <a href="#"><i class="fas fa-users"></i> Пользователи</a>
        <a href="#"><i class="fas fa-concierge-bell"></i> Услуги</a>
        <a href="#"><i class="fas fa-clipboard-list"></i> Заявки</a>
        <a href="#"><i class="fas fa-cog"></i> Настройки</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="dashboard-header">
            <h1><i class="fas fa-tachometer-alt"></i> Панель управления</h1>
            <a href="/logout.php" class="logout-btn">Выйти</a>
        </div>

        <!-- Статистика -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-content">
                    <h3>Пользователи</h3>
                    <p><?= $user_count ?></p>
                    <a href="user_management/list_users.php" class="stat-link">Управление <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-concierge-bell"></i></div>
                <div class="stat-content">
                    <h3>Услуги</h3>
                    <p><?= $service_count ?></p>
                    <a href="\pages\services.php" class="stat-link">Управление <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-clipboard-list"></i></div>
                <div class="stat-content">
                    <h3>Заявки</h3>
                    <p><?= $active_requests ?></p>
                    <a href="requests/list_requests.php" class="stat-link">Просмотр <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Последние действия -->
        <div class="recent-activity">
            <h3><i class="fas fa-history"></i> Последние действия</h3>
            <?php if (!empty($recent_activities)): ?>
                <?php foreach ($recent_activities as $activity): ?>
                    <div class="activity-item">
                        <div class="activity-icon"><i class="fas fa-user"></i></div>
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