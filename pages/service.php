<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сервисное обслуживание</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=<?= time() ?>">
    <link rel="icon" href="/assets/img/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon">
</head>
<body>

<?php
$bodyClass = 'service-page';
$pageTitle = 'Сервисное обслуживание';
require_once '../includes/header.php';
?>
<link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
<main class="service-page">
    <!-- Микроразметка -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Service",
      "serviceType": "IT обслуживание ресторанов",
      "provider": {
        "@type": "Organization",
        "name": "ТОП Сервис"
      }
    }
    </script>

    <!-- Герой-секция -->
    <section class="service-hero">
        <div class="hero-content">
            <h1>Сервисное обслуживание</h1>
            <p class="subtitle">Профессиональная поддержка вашего бизнеса 24/7</p>
            <div class="highlight-box">
                <p>Техническая поддержка • Проактивный мониторинг • Гарантированное время реакции</p>
            </div>
            <a href="#order" class="cta-button">Оставить заявку</a>
        </div>
    </section>

    <!-- Преимущества -->
    <section class="service-section">
        <div class="container">
            <div class="section-header">
                <h2>Почему выбирают наше обслуживание</h2>
                <p>Мы обеспечиваем максимальную надежность ваших систем</p>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="service-card">
                        <h3>24/7 Поддержка</h3>
                        <p>Круглосуточная техническая поддержка без выходных и праздников</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="service-card">
                        <h3>Гарантия SLA</h3>
                        <p>Строгое соблюдение соглашений об уровне сервиса</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="service-card">
                        <h3>Эксперты</h3>
                        <p>Сертифицированные специалисты с опытом от 5 лет</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Тарифы -->
    <section class="service-section">
        <div class="container">
            <div class="section-header">
                <h2>Пакеты обслуживания</h2>
                <p>Выберите оптимальное решение для вашего бизнеса</p>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="plan-card">
                        <h3>Информационное</h3>
                        <ul>
                            <li>Удаленный мониторинг</li>
                            <li>Консультации</li>
                            <li>Отчеты</li>
                        </ul>
                        <div class="plan-price">от 32 000 ₽/мес</div>
                        <a href="#order" class="service-btn btn-primary">Заказать</a>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="plan-card">
                        <h3>Техническое</h3>
                        <ul>
                            <li>Выезд специалиста</li>
                            <li>Ремонт оборудования</li>
                            <li>Профилактика</li>
                        </ul>
                        <div class="plan-price">от 45 000 ₽/мес</div>
                        <a href="#order" class="service-btn btn-primary">Заказать</a>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="plan-card">
                        <h3>Комплексное</h3>
                        <ul>
                            <li>Полный спектр услуг</li>
                            <li>Персональный менеджер</li>
                            <li>Гарантия 24/7</li>
                        </ul>
                        <div class="plan-price">от 75 000 ₽/мес</div>
                        <a href="#order" class="service-btn btn-primary">Заказать</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Форма заявки -->
    <section id="order" class="service-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/form.php'; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
require_once '../includes/footer.php';
?>
    
</body>
</html>