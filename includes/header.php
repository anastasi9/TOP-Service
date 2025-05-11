<header>
    <div class="header-top">
        <h1>ТОП Сервис</h1>
        <p>Автоматизация ресторанного бизнеса</p>
    </div>
    
    <link rel="stylesheet" href="/css/style.css">
    
    <!-- Основная навигация -->
    <nav class="main-nav">
        <ul class="nav-list">
            <li class="nav-item"><a href="index.php" class="nav-link">Главная</a></li>
            <li class="nav-item"><a href="about.php" class="nav-link">О нас</a></li>
            <li class="nav-item"><a href="contact.php" class="nav-link">Контакты</a></li>
            <li class="nav-item"><a href="/pages/tickets.php" class="nav-link">Заявки</a></li>
            <li><a href="/pages/service.php">Сервисное обслуживание</a></li>
            
            <?php if (isset($_SESSION['user'])): ?>
                <!-- Пользователь авторизован -->
                <?php if ($_SESSION['user']['role'] == 'admin'): ?>
                    <li class="nav-item admin-item">
                        <a href="/admin/" class="nav-link admin-link">
                            <i class="fas fa-cog"></i> Админка
                        </a>
                    </li>
                <?php elseif ($_SESSION['user']['role'] == 'moderator'): ?>
                    <li class="nav-item">
                        <a href="/moderator/" class="nav-link moderator-link">
                            <i class="fas fa-edit"></i> Модератор
                        </a>
                    </li>
                <?php endif; ?>
                
                <li class="nav-item user-item">
                    <a href="/user_profile.php" class="nav-link user-link">
                        <i class="fas fa-user"></i> <?= htmlspecialchars($_SESSION['user']['username']) ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/logout.php" class="nav-link logout-link">
                        <i class="fas fa-sign-out-alt"></i> Выйти
                    </a>
                </li>
            <?php else: ?>
                <!-- Гость -->
                <li class="nav-item">
                    <a href="/login.php" class="nav-link login-link">
                        <i class="fas fa-sign-in-alt"></i> Войти
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/register.php" class="nav-link register-link">
                        <i class="fas fa-user-plus"></i> Регистрация
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</header>