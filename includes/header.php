<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    <title>ТОП Сервис - Автоматизация ресторанного бизнеса</title>
    
    <!-- Подключение стилей -->
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* Основные цвета */
        :root {
            --primary-color: #e17400; /* Оранжевый */
            --secondary-color: #533b77; /* Фиолетовый */
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --text-color: #333;
            --text-light: #fff;
        }
        
        /* Мобильные стили */
        @media (max-width: 768px) {
            .header-container {
                padding: 10px;
                background: var(--light-color);
            }
            
            .header-top {
                flex-direction: column;
                align-items: center;
            }
            
            .branding {
                text-align: center;
                margin-bottom: 15px;
            }
            
            .branding h1 {
                color: var(--secondary-color);
            }
            
            .header-actions {
                display: flex;
                flex-direction: column;
                width: 100%;
                gap: 8px;
            }
            
            .header-actions a {
                margin: 0;
                padding: 12px;
                text-align: center;
                width: 100%;
                box-sizing: border-box;
                border-radius: 6px;
                font-weight: 500;
                transition: all 0.3s;
            }
            
            .phone-link {
                background: var(--secondary-color);
                color: var(--text-light);
            }
            
            .callback-btn {
                background: var(--primary-color);
                color: var(--text-light);
            }
            
            .request-btn {
                background: var(--light-color);
                color: var(--secondary-color);
                border: 1px solid var(--secondary-color);
            }
            
            .main-nav {
                position: relative;
                margin-top: 10px;
            }
            
            .mobile-menu-btn {
                display: block;
                padding: 15px;
                text-align: center;
                background: var(--secondary-color);
                color: var(--text-light);
                cursor: pointer;
                margin-bottom: 0;
                border-radius: 6px;
                font-weight: 500;
            }
            
            .nav-list {
                display: none;
                flex-direction: column;
                width: 100%;
                position: absolute;
                background: var(--light-color);
                z-index: 1000;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                border-radius: 0 0 6px 6px;
                overflow: hidden;
            }
            
            .nav-list.active {
                display: flex;
            }
            
            .nav-item {
                width: 100%;
                border-bottom: 1px solid rgba(83, 59, 119, 0.1);
            }
            
            .nav-link {
                padding: 14px 15px;
                display: block;
                color: var(--text-color);
                transition: all 0.3s;
            }
            
            .nav-link:hover {
                background: rgba(225, 116, 0, 0.1);
                color: var(--primary-color);
            }
            
            /* Стили для авторизованных пользователей */
            .admin-link {
                color: var(--secondary-color);
                font-weight: 500;
            }
            
            .moderator-link {
                color: #6c757d;
            }
            
            .user-link {
                color: var(--primary-color);
            }
            
            .logout-link {
                color: #dc3545;
            }
            
            .login-link {
                color: var(--secondary-color);
                font-weight: 500;
            }
            
            .breadcrumb-list {
                flex-wrap: wrap;
                font-size: 14px;
                padding: 10px 0;
            }
            
            .breadcrumb-item, .breadcrumb-separator {
                margin: 2px 0;
            }
            
            .breadcrumb-item a {
                color: var(--secondary-color);
            }
            
            .breadcrumb-item.active {
                color: var(--primary-color);
            }
            
            .breadcrumb-separator {
                color: var(--secondary-color);
                opacity: 0.6;
            }
        }
        
        /* Скрыть кнопку меню на десктопе */
        @media (min-width: 769px) {
            .mobile-menu-btn {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <div class="header-top">
                <div class="branding">
                    <h1>ТОП Сервис</h1>
                    <p style="color: #533b77;">Автоматизация ресторанного бизнеса</p>
                </div>
                
                <div class="header-actions">
                    <a href="tel:+78005006468" class="phone-link">
                        <i class="fas fa-phone"></i> +7 (800) 500-64-68
                    </a>
                    <a href="#order" class="callback-btn">
                        <i class="fas fa-phone-volume"></i> Заказать звонок
                    </a>
                    <a href="/login.php" class="request-btn">
                        <i class="fas fa-paper-plane"></i> Оставить заявку
                    </a>
                </div>
            </div>
            
            <!-- Кнопка мобильного меню -->
            <button class="mobile-menu-btn" onclick="toggleMenu()">
                <i class="fas fa-bars"></i> Меню
            </button>
            
            <!-- Основная навигация -->
            <nav class="main-nav">
                <ul class="nav-list" id="mainNav">
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
        </div>
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
                ];

                $uri = $_SERVER['REQUEST_URI'];
                $path = parse_url($uri, PHP_URL_PATH);
                $parts = explode('/', trim($path, '/'));

                $breadcrumbs = [];
                $url = '';

                foreach ($parts as $part) {
                    if (!empty($part)) {
                        $url .= '/' . $part;
                        $fileName = pathinfo($part, PATHINFO_FILENAME);
                        $name = $translations[$fileName] ?? ucfirst(str_replace(['-', '_'], ' ', $fileName));
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

    <script>
        // Функция для переключения мобильного меню
        function toggleMenu() {
            var nav = document.getElementById('mainNav');
            nav.classList.toggle('active');
        }
        
        // Закрытие меню при клике вне его области
        document.addEventListener('click', function(event) {
            var nav = document.getElementById('mainNav');
            var btn = document.querySelector('.mobile-menu-btn');
            
            if (!nav.contains(event.target) && event.target !== btn && !btn.contains(event.target)) {
                nav.classList.remove('active');
            }
        });
    </script>
</body>
</html>
