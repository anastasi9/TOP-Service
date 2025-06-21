<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>О компании | ТОП СЕРВИС</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=<?= time() ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="icon" href="/assets/img/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon">

</head>
<body>

<?php
require_once '../includes/header.php';
?>

<section class="hero-section">
    <div class="container">
        <h1 class="animate__animated animate__fadeInDown">О компании</h1>
        <p class="animate__animated animate__fadeIn animate__delay-1s">«ТОП СЕРВИС» — аккредитованная IT-компания, которая помогает бизнесу в HoReCa работать без перебоев.</p>
    </div>
</section>

<section class="content-section">
    <div class="container">
        <div class="about-content">
            <h2 class="animate__animated animate__fadeIn">Кто мы?</h2>
            <p class="animate__animated animate__fadeIn animate__delay-1s">
                <strong>«ТОП СЕРВИС»</strong> — это команда профессионалов, специализирующихся на комплексном ИТ-обслуживании объектов общественного питания.
                Мы делаем так, чтобы ваш бизнес работал бесперебойно, даже в самых сложных ситуациях.
            </p>

            <h2 class="animate__animated animate__fadeIn">Чем занимаемся?</h2>
            <ul class="features-list">
                <li class="animate__animated animate__fadeInLeft animate__delay-1s">ИТ-сопровождение объектов HoReCa</li>
                <li class="animate__animated animate__fadeInLeft animate__delay-1s">Обслуживание кассовых систем (R-Keeper от UCS)</li>
                <li class="animate__animated animate__fadeInLeft animate__delay-1s">Онлайн-мониторинг заявок через собственный сайт</li>
                <li class="animate__animated animate__fadeInLeft animate__delay-1s">Технический запуск и эксплуатация объектов</li>
                <li class="animate__animated animate__fadeInLeft animate__delay-1s">Прокладка инженерных сетей и ремонт помещений</li>
            </ul>

            <h2 class="animate__animated animate__fadeIn">Наши клиенты</h2>
            <p class="animate__animated animate__fadeIn animate__delay-1s">
                Мы обслуживаем объекты всех масштабов: от маленьких кофеен формата to go до крупных ресторанов и холдингов,
                работающих в премиальном сегменте. Также наши услуги востребованы в учебных заведениях, аэропортах и кинотеатрах.
            </p>

            <h2 class="animate__animated animate__fadeIn">Как мы прошли пандемию?</h2>
            <p class="animate__animated animate__fadeIn animate__delay-1s">
                В самый сложный период мы сохранили команду и нашли решения, которые позволили нам остаться на плаву.
                На тот момент нас было всего шестеро, но мы не оставили ни одного клиента без поддержки.
            </p>
        </div>
    </div>
</section>

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

<?php
require_once '../includes/footer.php';
?>
<script src="/assets/js/script.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script>
    // Инициализация анимаций
    new WOW().init();
    
    // Плавный скролл для якорей
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
    
    console.log("Скрипт работает!");
</script>
</body>
</html>