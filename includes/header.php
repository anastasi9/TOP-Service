<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>ТОП Сервис - Автоматизация ресторанного бизнеса</title>
    
    <!-- Подключение стилей -->
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    

</head>
<body>
    <header>
        <div class="header-container">
            <div class="header-top">
                <div class="branding">
                    <h1>ТОП Сервис</h1>
                    <p>Автоматизация ресторанного бизнеса</p>
                </div>
                
                <div class="header-actions">
                    <a href="tel:+78005006468" class="phone-link">
                        <i class="fas fa-phone"></i> +7 (800) 500-64-68
                    </a>
                    <button class="callback-btn">
                        <i class="fas fa-phone-volume"></i> Заказать звонок
                    </button>
                    <a href="#request-form" class="request-btn">
                        <i class="fas fa-paper-plane"></i> Оставить заявку
                    </a>
                </div>
            </div>
            
            <!-- Основная навигация -->
            <nav class="main-nav">
        <ul class="nav-list">
            <li class="nav-item"><a href="../index.php" class="nav-link">Главная</a></li>
            <li class="nav-item"><a href="/pages/automation.php" class="nav-link">Автоматизация</a></li>
            <li class="nav-item"><a href="/pages/audit.php" class="nav-link">Аудит</a></li>
            <li class="nav-item"><a href="/pages/service.php" class="nav-link">Сервисное обслуживание</a></li>
            <li class="nav-item"><a href="/pages/services.php" class="nav-link">Услуги</a></li>
            <li class="nav-item"><a href="/pages/about.php" class="nav-link">О компании</a></li>
            <li class="nav-item"><a href="/pages/contact.php" class="nav-link">Контакты и адреса</a></li>

            
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
            <?php endif; ?>
        </ul>
    </nav>
</header>
<nav class="breadcrumbs">
    <div class="container">
        <ul class="breadcrumb-list">
            <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
            <?php 
            // Словарь перевода частей URL на русский язык
            $translations = [
                'index' => 'Главная',
                'automation' => 'Автоматизация',
                'audit' => 'Аудит',
                'service' => 'Сервисное обслуживание',
                'services' => 'Услуги',
                'about' => 'О компании',
                'contact' => 'Контакты и адреса',
                'contacts' => 'Контакты',
                'login' => 'Вход',
                'register' => 'Регистрация',
                'user_profile' => 'Профиль',
                'admin' => 'Админка',
                'moderator' => 'Модератор',
                // Добавьте другие страницы по мере необходимости
            ];

            $uri = $_SERVER['REQUEST_URI'];
            $path = parse_url($uri, PHP_URL_PATH);
            $parts = explode('/', trim($path, '/'));

            $breadcrumbs = [];
            $url = '';

            foreach ($parts as $part) {
                if (!empty($part)) {
                    $url .= '/' . $part;

                    // Получаем имя файла без расширения, если есть
                    $fileName = pathinfo($part, PATHINFO_FILENAME);

                    // Проверяем, является ли это "pages"
                    if ($fileName === 'pages') {
                        $name = 'Страница';
                    } else {
                        // Используем перевод, если он задан, иначе преобразуем автоматически
                        $name = $translations[$fileName] ?? ucfirst(str_replace(['-', '_'], ' ', $fileName));
                    }

                    $breadcrumbs[] = ['url' => $url, 'name' => $name];
                }
            }

            foreach ($breadcrumbs as $index => $crumb) {
                $is_last = ($index === count($breadcrumbs) - 1);
                if ($is_last) {
                    echo '<li class="breadcrumb-item active">' . htmlspecialchars($crumb['name']) . '</li>';
                } else {
                    echo '<li class="breadcrumb-item"><a href="' . htmlspecialchars($crumb['url']) . '">' . htmlspecialchars($crumb['name']) . '</a></li>';
                    echo '<li class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></li>';
                }
            }
            ?>
        </ul>
    </div>
</nav>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


