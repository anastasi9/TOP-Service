<nav class="admin-navbar">
    <div class="admin-brand">
        <a href="/admin/admin_main.php">ТОП Сервис - Админ-панель</a>
    </div>
    <div class="admin-user">
        <span><?= htmlspecialchars($current_user['username']) ?> (<?= $current_user['role'] ?>)</span>
        <a href="/logout.php">Выйти</a>
    </div>
    <ul class="admin-menu">
        <li><a href="/admin/admin_main.php">Главная</a></li>
        <li class="dropdown">
            <a href="#">Контент</a>
            <ul>
                <li><a href="/admin/content_management/edit_page.php">Редактировать страницы</a></li>
                <li><a href="/admin/content_management/edit_section.php">Редактировать секции</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="#">Пользователи</a>
            <ul>
                <li><a href="/admin/user_management/list_users.php">Список пользователей</a></li>
                <li><a href="/admin/user_management/create_user.php">Создать пользователя</a></li>
            </ul>
        </li>
        <li><a href="/admin/system_settings.php">Настройки</a></li>
        <li><a href="/admin/logs/activity_log.php">Логи</a></li>
    </ul>
</nav>