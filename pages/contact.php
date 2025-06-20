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
        <div class="row">
            <div class="col-md-12">
                <h3>Адрес офиса в Москве</h3>
                <h4>Москва, улица Земляной Вал, 64с2</h4>
                <div class="yandex-map">
                    <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Ac60a8269ed6c6fa4a4084f0ecab17c80b6e1e6959fd2f6b5275e1df30928a49f&amp;source=constructor" 
                            width="100%" height="400" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Блок со второй картой -->
<section id="map-sochi" class="map-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Адрес офиса в Сочи</h3>
                <h4>Краснодарский край, Сочи, улица Мира, 42</h4>
                <div class="yandex-map">
                    <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A6d086fb90b7155018d13ffd0a985b4efcd43f34ec08f470b92e516d959b75086&amp;source=constructor" 
                            width="100%" height="400" frameborder="0"></iframe>
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
<?php require_once '../includes/footer.php'; ?>
</body>
</html>