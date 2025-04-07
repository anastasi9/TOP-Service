<header>
    <h1>ТОП-Сервис</h1>
    <link rel="stylesheet" href="css/style.css">
    <p>Автоматизация ресторанного бизнеса</p>
    
    <!-- Основная навигация -->
    <nav>
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><a href="about.php">О нас</a></li>
            <li><a href="contact.php">Контакты</a></li>
            
            <!-- Убрали лишние ссылки на .html -->
            
            <?php if (isset($_SESSION['user'])): ?>
                <!-- Админские/модераторские ссылки -->
                <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                    <li><a href="admin_dashboard.php">Админ-панель</a></li>
                <?php endif; ?>
                <?php if (in_array($_SESSION['user']['role'], ['admin', 'moderator'])): ?>
                    <li><a href="moderator_dashboard.php">Модератор</a></li>
                <?php endif; ?>
                
                <!-- Ссылка для выхода -->
                <li><a href="logout.php">Выйти (<?= htmlspecialchars($_SESSION['user']['username']) ?>)</a></li>
            <?php else: ?>
                <li><a href="login.php">Войти</a></li>
                <li><a href="register.php">Регистрация</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>