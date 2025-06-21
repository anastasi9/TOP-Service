<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контакты и адреса</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=<?= time() ?>">
    <link rel="icon" href="/assets/img/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
</head>
<body>
<?php
session_start();
require_once '../includes/header.php';
require_once '../includes/db_connect.php';
?>
<!-- Блок с первой картой -->
<section id="map" class="map-section">
    <div class="container">
        <div class="section-header">
            <h2><i class="fas fa-map-marker-alt"></i> Москва</h2>
            <p>Наш главный офис в столице</p>
        </div>
        <div class="office-card">
            <div class="office-info">
                <h3><i class="fas fa-building"></i> Адрес офиса в Москве</h3>
                <p class="address"><i class="fas fa-map-pin"></i> Москва, улица Земляной Вал, 64с2</p>
                <div class="contact-details">
                    <p><i class="fas fa-phone"></i> Телефон: <a href="tel:+74951234567">+7 (495) 123-45-67</a></p>
                    <p><i class="fas fa-clock"></i> Часы работы: Пн-Пт с 10:00 до 19:00</p>
                </div>
            </div>
            <div class="yandex-map">
                <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Ac60a8269ed6c6fa4a4084f0ecab17c80b6e1e6959fd2f6b5275e1df30928a49f&amp;source=constructor" 
                        width="100%" height="400" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</section>

<!-- Блок со второй картой -->
<section id="map-sochi" class="map-section">
    <div class="container">
        <div class="section-header">
            <h2><i class="fas fa-umbrella-beach"></i> Сочи</h2>
            <p>Наш южный филиал на берегу Черного моря</p>
        </div>
        <div class="office-card">
            <div class="office-info">
                <h3><i class="fas fa-building"></i> Адрес офиса в Сочи</h3>
                <p class="address"><i class="fas fa-map-pin"></i> Краснодарский край, Сочи, улица Мира, 42</p>
                <div class="contact-details">
                    <p><i class="fas fa-phone"></i> Телефон: <a href="tel:+78622123456">+7 (862) 212-34-56</a></p>
                    <p><i class="fas fa-clock"></i> Часы работы: Пн-Пт с 10:00 до 19:00</p>
                </div>
            </div>
            <div class="yandex-map">
                <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A6d086fb90b7155018d13ffd0a985b4efcd43f34ec08f470b92e516d959b75086&amp;source=constructor" 
                        width="100%" height="400" frameborder="0"></iframe>
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
<?php require_once '../includes/footer.php'; ?>
</body>
</html>