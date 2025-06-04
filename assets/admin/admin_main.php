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
    <style>
        /* === Общие стили === */
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f9; 
            color: #000000;
        }

        .admin-container {
            display: flex;
        }

        .sidebar {
            width: 250px;
            background-color: #533b77;
            color: white;
            min-height: 100vh;
            padding: 2rem 1rem;
            position: fixed;
        }

        .sidebar h2 {
            font-size: 20px;
            margin-bottom: 2rem;
            text-align: center;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            margin-bottom: 10px;
            border-radius: 6px;
            transition: background 0.3s ease;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #e17400;
        }

        .main-content {
            margin-left: 250px;
            padding: 2rem;
            width: 100%;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .dashboard-header h1 {
            font-size: 28px;
            color: #533b77;
            margin: 0;
        }

        .logout-btn {
            background-color: #e17400;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background-color: #ffffff;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            position: relative;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            background-color: #533b77;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            position: absolute;
            top: -20px;
            left: 20px;
        }

        .stat-content {
            margin-left: 70px;
        }

        .stat-content h3 {
            margin: 0;
            font-size: 18px;
            color: #533b77;
        }

        .stat-content p {
            font-size: 24px;
            margin: 5px 0;
            font-weight: bold;
            color: #000000;
        }

        .stat-link {
            display: inline-block;
            margin-top: 10px;
            color: #e17400;
            text-decoration: none;
            font-size: 14px;
        }

        .stat-link i {
            margin-left: 5px;
        }

        .recent-activity {
            background-color: #ffffff;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .recent-activity h3 {
            margin-top: 0;
            font-size: 20px;
            color: #533b77;
            margin-bottom: 1rem;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            background-color: #533b77;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .activity-details {
            flex: 1;
        }

        .activity-user {
            margin: 0;
            font-weight: bold;
            color: #000000;
        }

        .activity-action {
            margin: 4px 0;
            font-size: 14px;
            color: #555;
        }

        .activity-time {
            color: #999;
            font-size: 12px;
        }

        .no-activity {
            text-align: center;
            color: #999;
            margin-top: 1rem;
        }
    </style>
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
            <a href="logout.php" class="logout-btn">Выйти</a>
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
                    <a href="content_management/services.php" class="stat-link">Управление <i class="fas fa-arrow-right"></i></a>
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