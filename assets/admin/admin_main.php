<?php
require_once __DIR__ . '/includes/admin_header.php';

// Получаем статистику
$user_count = get_user_count();
$service_count = get_service_count();
$active_requests = get_active_requests();
$recent_activities = get_recent_activities();
?>

<div class="admin-dashboard">
    <h1><i class="fas fa-tachometer-alt"></i> Панель управления</h1>
    
    <div class="stats-grid">
        <div class="stat-card bg-primary">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3>Пользователи</h3>
                <p><?= e($user_count) ?></p>
                <a href="user_management/list_users.php" class="stat-link">
                    Управление <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        
        <div class="stat-card bg-success">
            <div class="stat-icon">
                <i class="fas fa-concierge-bell"></i>
            </div>
            <div class="stat-content">
                <h3>Услуги</h3>
                <p><?= e($service_count) ?></p>
                <a href="content_management/services.php" class="stat-link">
                    Управление <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        
        <div class="stat-card bg-warning">
            <div class="stat-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="stat-content">
                <h3>Заявки</h3>
                <p><?= e($active_requests) ?></p>
                <a href="requests/list_requests.php" class="stat-link">
                    Просмотр <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
    
    <div class="dashboard-row">
        <div class="recent-activity">
            <h3><i class="fas fa-history"></i> Последние действия</h3>
            <div class="activity-list">
                <?php if (empty($recent_activities)): ?>
                    <p class="no-activity">Нет последних действий</p>
                <?php else: ?>
                    <?php foreach ($recent_activities as $activity): ?>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="activity-details">
                                <p class="activity-user"><?= e($activity['username']) ?></p>
                                <p class="activity-action"><?= e($activity['action']) ?></p>
                                <small class="activity-time">
                                    <?= date('d.m.Y H:i', strtotime($activity['created_at'])) ?>
                                </small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>