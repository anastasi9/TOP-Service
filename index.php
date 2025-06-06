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
        <section class="services">
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
        </div>
    </section>

        </article>
    </main>

    <?php include_once 'includes/footer.php'; ?>
    
    <!-- Подключение скриптов -->
    <script src="scripts/app.js" defer></script>
</body>
</html>






