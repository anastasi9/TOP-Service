<?php
require_once 'includes/auth.php';  // Сессия запускается здесь
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ТОП Сервис автоматизация ресторанного бизнеса</title>
    <meta name="description" content="Автоматизация ресторанного бизнеса от компании ТОП Сервис. IT-решения для HoReCa.">
    <meta name="keywords" content="автоматизация, рестораны, IT, HoReCa, ТОПСервис">
    <link rel="stylesheet" href="assets/css/style.css">
    <meta property="og:title" content="Заголовок страницы в OG">
    <meta property="og:description" content="Описание страницы в OG">
    <meta property="og:image" content="https://example.com/image.jpg">
    <meta property="og:url" content="https://example.com/">
    <link rel="icon" href="/assets/img/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "ТОП Сервис",
      "url": "https://<?php echo $_SERVER['HTTP_HOST']; ?>",
      "logo": "https://<?php echo $_SERVER['HTTP_HOST']; ?>/img/logo.png",
      "description": "Автоматизация ресторанного бизнеса и IT обслуживание",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Земляной Вал, 64с2",
        "addressLocality": "Москва",
        "postalCode": "109004",
        "addressCountry": "RU"
      },
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+7-800-500-64-68",
        "contactType": "customer service",
        "email": "support@it-horeca.ru",
        "availableLanguage": ["Russian"]
      },
    }
    </script>

    
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "name": "ТОП Сервис",
      "url": "https://<?php echo $_SERVER['HTTP_HOST']; ?>",
      "potentialAction": {
        "@type": "SearchAction",
        "target": "https://<?php echo $_SERVER['HTTP_HOST']; ?>/search?q={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    }
    </script>
 
</head>

<body>
    <?php 
    include_once 'includes/header.php'; 
    ?>
<section class="hero-section">
    <div class="container">

        <p class="animate__animated animate__fadeIn animate__delay-1s">«ТОП СЕРВИС» — аккредитованная IT-компания, которая помогает бизнесу в HoReCa работать без перебоев.</p>
    </div>
</section>
<main>
    <section class="container">
        <div class="service-grid">
            <div class="service-card animate__animated animate__fadeInLeft">
                <h3>Автоматизация для всей HoReCa</h3>
                <p>Кассовая автоматизация — Системы учета — Автоматизация под ключ</p>
                <a href="#order" class="more-link">Подробнее</a>
            </div>
            <div class="service-card animate__animated animate__fadeInRight">
                <h3>Сервисное обслуживание</h3>
                <p>ИТ-сопровождение объектов HoReCa, обслуживание кассовых систем, онлайн-мониторинг</p>
                <a href="#order" class="more-link">Подробнее</a>
            </div>
            <div class="service-card animate__animated animate__fadeInLeft">
                <h3>Технический запуск объектов</h3>
                <p>Полный цикл работ от проектирования до ввода в эксплуатацию</p>
                <a href="#order" class="more-link">Подробнее</a>
            </div>
            <div class="service-card animate__animated animate__fadeInRight">
                <h3>Инженерные решения</h3>
                <p>Прокладка сетей, ремонт помещений, монтаж оборудования</p>
                <a href="#order" class="more-link">Подробнее</a>
            </div>
        </div>
    </section>
</main>

<section class="stats-section">
    <div class="container">
        <h2 class="section-header animate__animated animate__fadeIn">Наши достижения</h2>
        <div class="stats-grid">
            <div class="stat-item animate__animated animate__fadeInUp animate__delay-1s">
                <div class="stat-number">6+</div>
                <div class="stat-label">лет на рынке</div>
            </div>
            <div class="stat-item animate__animated animate__fadeInUp animate__delay-1s">
                <div class="stat-number">500+</div>
                <div class="stat-label">довольных клиентов</div>
            </div>
            <div class="stat-item animate__animated animate__fadeInUp animate__delay-1s">
                <div class="stat-number">24/7</div>
                <div class="stat-label">поддержка</div>
            </div>
            <div class="stat-item animate__animated animate__fadeInUp animate__delay-1s">
                <div class="stat-number">99%</div>
                <div class="stat-label">успешных решений</div>
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
    <?php include_once 'includes/footer.php'; ?>
</body>
</html>