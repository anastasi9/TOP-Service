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
        "streetAddress": "ул. Примерная, 123",
        "addressLocality": "Москва",
        "postalCode": "123456",
        "addressCountry": "RU"
      },
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+7-XXX-XXX-XX-XX",
        "contactType": "customer service",
        "email": "info@topservice.ru",
        "availableLanguage": ["Russian"]
      },
      "sameAs": [
        "https://vk.com/topservice",
        "https://facebook.com/topservice"
      ]
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

    <main>
        <article>
            <section>
                <h2>Первая секция</h2>
                <p>О компании</p>
                <img src="images/image.png" alt="IT обслуживание ресторанов">
                <p>Наши партнеры</p>
            </section>
            <section>
                <h2>Вторая секция</h2>
                <p></p>
                <section class="services">
                <section class="catalog-preview">
                <h2>Каталог товаров</h2>
                <p>Наша компания предоставляет готовые решения.</p>
                <a href="#" class="cta-button">Перейти в каталог</a>
                </section>
        <section class="services">
        <h2>Наши услуги</h2>
        <div class="service-grid">
            <div class="service-card">
                <h3>Автоматизация для всей HoReCa</h3>
                <p>Кассовая автоматизация — Системы учета — Автоматизация под ключ</p>
                <a href="#" class="more-link">Подробнее</a>
            </div>
            <div class="service-card">
                <h3>Сервисное обслуживание</h3>
                <p>Описание услуги и преимущества</p>
                <a href="#" class="more-link">Подробнее</a>
            </div>
            <div class="service-card">
                <h3>Обучение персонала</h3>
                <p>Rkeeper – StoreHouse – Видеоуроки</p>
                <a href="#" class="more-link">Подробнее</a>
            </div>
        </div>
        
    </section>
        <div class="service-grid">
            <div class="service-card">
                <h3>Автоматизация для всей HoReCa</h3>
                <p>Кассовая автоматизация — Системы учета — Автоматизация под ключ</p>
                <a href="#" class="more-link">Подробнее</a>
            </div>
            <div class="service-card">
                <h3>Сервисное обслуживание</h3>
                <p>Описание услуги и преимущества</p>
                <a href="#" class="more-link">Подробнее</a>
            </div>
            <div class="service-card">
                <h3>Обучение персонала</h3>
                <p>Rkeeper – StoreHouse – Видеоуроки</p>
                <a href="#" class="more-link">Подробнее</a>
            </div>
        </div>
    </section>
            </section>
            <section>
                <h2>И третья</h2>
                <p>Контакты</p>
            </section>
        </article>
    </main>

    <?php include_once 'includes/footer.php'; ?>
    
    <!-- Подключение скриптов -->
    <script src="scripts/app.js" defer></script>
</body>
</html>






