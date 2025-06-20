<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Аудит IT-инфраструктуры</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=<?= time() ?>">
    <link rel="icon" href="/assets/img/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon">
</head>
<body>

<?php
$bodyClass = 'audit-page';
$pageTitle = 'Аудит IT-инфраструктуры';
require_once '../includes/header.php';
?>

<main class="audit-page">
    <!-- Микроразметка -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Service",
      "serviceType": "IT аудит ресторанов",
      "provider": {
        "@type": "Organization",
        "name": "ТОП Сервис"
      }
    }
    </script>

    <!-- Герой-секция -->
    <section class="audit-hero">
        <div class="hero-content">
            <h1>Аудит IT-инфраструктуры ресторана</h1>
            <p class="subtitle">Профессиональный анализ вашей текущей IT-системы для выявления слабых мест и возможностей оптимизации</p>
            <div class="highlight-box">
                <p>Полная диагностика • Рекомендации по оптимизации • Повышение безопасности</p>
            </div>
            <a href="#order" class="cta-button">Заказать аудит</a>
        </div>
    </section>

    <!-- Преимущества -->
    <section class="audit-section">
        <div class="container">
            <div class="section-header">
                <h2>Преимущества IT-аудита</h2>
                <p>Почему стоит провести аудит вашей IT-инфраструктуры</p>
            </div>
            
            <div class="row">
                <div class="col-md-3">
                    <div class="service-card">
                        <h3>Полная диагностика</h3>
                        <p>Выявление всех проблемных мест в IT-инфраструктуре</p>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="service-card">
                        <h3>Оптимизация затрат</h3>
                        <p>Рекомендации по снижению эксплуатационных расходов</p>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="service-card">
                        <h3>Безопасность</h3>
                        <p>Проверка системы на уязвимости и риски</p>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="service-card">
                        <h3>Рекомендации</h3>
                        <p>Готовый план модернизации и улучшений</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Варианты аудита -->
    <section class="audit-section">
        <div class="container">
            <div class="section-header">
                <h2>Варианты аудита</h2>
                <p>Выберите подходящий тип проверки для вашего бизнеса</p>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="plan-card">
                        <h3>Базовый</h3>
                        <ul>
                            <li>Обследование оборудования</li>
                            <li>Проверка сети</li>
                            <li>Базовые рекомендации</li>
                        </ul>
                        <div class="plan-price">от 25 000 ₽</div>
                        <a href="#order" class="service-btn btn-primary">Заказать</a>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="plan-card featured">
                        <h3>Стандартный</h3>
                        <ul>
                            <li>Полная диагностика</li>
                            <li>Анализ безопасности</li>
                            <li>Подробный отчет</li>
                            <li>Рекомендации</li>
                        </ul>
                        <div class="plan-price">от 45 000 ₽</div>
                        <a href="#order" class="service-btn btn-primary">Заказать</a>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="plan-card">
                        <h3>Премиум</h3>
                        <ul>
                            <li>Глубокий анализ</li>
                            <li>Тестирование нагрузки</li>
                            <li>План модернизации</li>
                            <li>Гарантия результата</li>
                        </ul>
                        <div class="plan-price">от 75 000 ₽</div>
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
                    <?php include '..\includes\form.php'; ?>
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