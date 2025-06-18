<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/admin.css?v=<?= time() ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Добавляем класс collapsed к сайдбару при загрузке
            document.querySelector('.sidebar').classList.add('collapsed');
            
            // Для мобильных устройств добавляем кнопку меню
            if (window.innerWidth <= 768) {
                const trigger = document.querySelector('.sidebar-trigger');
                trigger.addEventListener('click', function() {
                    document.querySelector('.sidebar').classList.toggle('active');
                });
            }
        });
    </script>
</head>
<body>

<div class="admin-container">
    <!-- Триггер для показа сайдбара -->
    <div class="sidebar-trigger"></div>
    
    <!-- Подключаем сайдбар -->
    <?php include __DIR__ . '/admin_sidebar.php'; ?>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="dashboard-header">
            <h1><?= $page_heading ?? 'Личный кабинет' ?></h1>
            <a href="/logout.php" class="logout-btn">Выйти</a>
        </div>

        <!-- Flash сообщения -->
        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="flash-message"><?= $_SESSION['flash_message'] ?></div>
            <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>