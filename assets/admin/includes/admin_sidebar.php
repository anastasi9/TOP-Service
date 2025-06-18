<?php
// Проверка авторизации администратора
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}
?>

<!-- Sidebar -->
<div class="sidebar">
    <h2>Панель управления</h2>
    <a href="/assets/admin/admin_main.php" <?= basename($_SERVER['PHP_SELF']) === 'admin_main.php' ? 'class="active"' : '' ?>>
        <i class="fas fa-tachometer-alt"></i> Главная
    </a>
    <a href="\assets\admin\user_management\list_users.php" <?= basename($_SERVER['PHP_SELF']) === 'list_users.php' ? 'class="active"' : '' ?>>
        <i class="fas fa-users"></i> Пользователи
    </a>
    <a href="\assets\admin\leads.php" <?= basename($_SERVER['PHP_SELF']) === 'leads.php' ? 'class="active"' : '' ?>>
        <i class="fas fa-tachometer-alt"></i> Лиды
    </a>
    <a href="\assets\admin\helpline\helpline.php" <?= basename($_SERVER['PHP_SELF']) === 'helpline.php' ? 'class="active"' : '' ?>>
        <i class="fas fa-tachometer-alt"></i> Заявки
    </a>
</div>
