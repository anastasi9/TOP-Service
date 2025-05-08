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
                <p>Наши услуги</p>
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

