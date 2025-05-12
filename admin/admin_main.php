#панель админ
<?php
/* require '../includes/db_connect.php'; 
require '../includes/auth.php';
require '../includes/check_role.php';
require '../includes/functions.php'; */

/* if ($current_user['role'] !== 'admin') {
    header("Location: ../login.php?error=no_access");
    exit;
} */
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Панель администратора | ТОП Сервис</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <?php include './includes/admin_header.php'; ?>
    
    <div class="admin-container">
        <h1>Административная панель</h1>
        
        <div class="admin-widgets">
            <!-- Статистика -->
            <div class="widget">
                <h3>Статистика сайта</h3>
                <p>Пользователей: <?= get_user_count(); ?></p>
                <p>Посетителей сегодня: 142</p>
            </div>
            
            <!-- Управление пользователями -->
            <div class="widget">
                <h3>Управление пользователями</h3>
                <a href="users.php" class="btn">Список пользователей</a>
                <a href="create_user.php" class="btn">Создать нового</a>
            </div>
            
            <!-- Настройки системы -->
            <div class="widget">
                <h3>Настройки сайта</h3>
                <form action="update_settings.php" method="POST">
                    <label>Название сайта:</label>
                    <input type="text" name="site_title" value="ТОП Сервис">
                    
                    <button type="submit" class="btn-save">Сохранить</button>
                </form>
            </div>
        </div>
    </div>

    <!-- <script src="../assets/js/admin.js"></script> -->
</body>
</html>


