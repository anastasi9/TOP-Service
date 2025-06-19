<?php

$allowed_roles = ['admin', 'moderator'];

if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], $allowed_roles)) {
    header('Location: ../../../../login.php');
    exit();
}

?>

<!-- Sidebar -->
<div class="sidebar">
    <h2>Панель управления</h2>
    <a href="<?= $_SESSION['user_role'] === 'admin' ? '/assets/admin/admin_main.php' : '/assets/moderator/moderator.php' ?>" 
    <?= ($_SESSION['user_role'] === 'admin' && basename($_SERVER['PHP_SELF']) === 'admin_main.php') || 
        ($_SESSION['user_role'] === 'moderator' && basename($_SERVER['PHP_SELF']) === 'moderator.php') ? 'class="active"' : '' ?>>
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
