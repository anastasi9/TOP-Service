<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>О компании</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=<?= time() ?>">
    
    <link rel="icon" href="/assets/img/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon">
</head>
<body>

<?php
require_once '../includes/header.php';
?>

<section class="hero-section">
    <div class="container">
        <h1>О компании</h1>
        <p>«ТОП СЕРВИС» — IT-аккредитованная компания, которая помогает бизнесу в HoReCa работать без перебоев.</p>
    </div>
</section>

<section class="content-section">
    <div class="container">
        <div class="about-content">
            <h2 class="animate-on-load">Кто мы?</h2>
            <p class="animate-on-load">
                <strong>«ТОП СЕРВИС»</strong> — это команда профессионалов, специализирующихся на комплексном ИТ-обслуживании объектов общественного питания.
                Мы делаем так, чтобы ваш бизнес работал бесперебойно, даже в самых сложных ситуациях.
            </p>

            <h2 class="animate-on-load">Чем занимаемся?</h2>
            <ul class="features-list animate-on-load">
                <li>ИТ-сопровождение объектов HoReCa</li>
                <li>Обслуживание кассовых систем (R-Keeper от UCS)</li>
                <li>Онлайн-мониторинг заявок через собственный</li>
                <li>Технический запуск и эксплуатация объектов</li>
                <li>Прокладка инженерных сетей и ремонт помещений</li>
            </ul>

            <h2 class="animate-on-load">Наши клиенты</h2>
            <p class="animate-on-load">
                Мы обслуживаем объекты всех масштабов: от маленьких кофеен формата to go до крупных ресторанов и холдингов,
                работающих в премиальном сегменте. Также наши услуги востребованы в учебных заведениях, аэропортах и кинотеатрах.
            </p>

            <h2 class="animate-on-load">Как мы прошли пандемию?</h2>
            <p class="animate-on-load">
                В самый сложный период мы сохранили команду и нашли решения, которые позволили нам остаться на плаву.
                На тот момент нас было всего шестеро, но мы не оставили ни одного клиента без поддержки.
            </p>

            <!-- Красивая кнопка внизу -->
            <div class="cta-wrapper">
                <div class="cta-button">
                    <a href="/contact.php">Связаться с нами</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
require_once '../includes/footer.php';
?>
<script src="/assets/js/script.js"></script>
<script>
    console.log("Скрипт работает!");
</script>
</body>
</html>