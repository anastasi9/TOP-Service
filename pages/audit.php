<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=<?= time() ?>">
</head>
<body>
<?php 
$title = "Аудит IT-инфраструктуры ресторана";
require_once '../includes/header.php'; 
?>

<div class="container audit-page">
    <h1>Аудит действующей IT-инфраструктуры ресторана</h1>
    
    <div class="audit-intro">
        <p>Профессиональный анализ вашей текущей IT-системы для выявления слабых мест и возможностей оптимизации.</p>
        <img src="/assets/images/audit-banner.jpg" alt="IT-аудит ресторана" class="img-fluid">
    </div>
    
    <div class="audit-benefits">
        <h2>Преимущества аудита</h2>
        <div class="benefits-grid">
            <div class="benefit-card">
                <i class="fas fa-search"></i>
                <h3>Полная диагностика</h3>
                <p>Выявление всех проблемных мест в IT-инфраструктуре</p>
            </div>
            <div class="benefit-card">
                <i class="fas fa-chart-line"></i>
                <h3>Оптимизация затрат</h3>
                <p>Рекомендации по снижению эксплуатационных расходов</p>
            </div>
            <div class="benefit-card">
                <i class="fas fa-shield-alt"></i>
                <h3>Безопасность</h3>
                <p>Проверка системы на уязвимости и риски</p>
            </div>
            <div class="benefit-card">
                <i class="fas fa-lightbulb"></i>
                <h3>Рекомендации</h3>
                <p>Готовый план модернизации и улучшений</p>
            </div>
        </div>
    </div>
    
    <div class="audit-process">
        <h2>Как проходит аудит</h2>
        <ol class="process-steps">
            <li>
                <span class="step-number">1</span>
                <div class="step-content">
                    <h3>Заявка и подготовка</h3>
                    <p>Вы оставляете заявку, мы согласовываем сроки и составляем план проверки</p>
                </div>
            </li>
            <li>
                <span class="step-number">2</span>
                <div class="step-content">
                    <h3>Выезд специалиста</h3>
                    <p>Наш эксперт приезжает в ваш ресторан для сбора данных</p>
                </div>
            </li>
            <li>
                <span class="step-number">3</span>
                <div class="step-content">
                    <h3>Анализ и отчет</h3>
                    <p>Мы готовим подробный отчет с выводами и рекомендациями</p>
                </div>
            </li>
            <li>
                <span class="step-number">4</span>
                <div class="step-content">
                    <h3>Презентация результатов</h3>
                    <p>Обсуждение отчета и ответы на ваши вопросы</p>
                </div>
            </li>
        </ol>
    </div>
    
    <div class="audit-request">
        <h2>Заказать IT-аудит</h2>
        <form id="audit-form" class="request-form">
            <div class="form-group">
                <input type="text" name="name" placeholder="Ваше имя" required>
            </div>
            <div class="form-group">
                <input type="tel" name="phone" placeholder="Телефон" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="E-mail">
            </div>
            <div class="form-group">
                <textarea name="message" placeholder="Опишите вашу текущую систему и проблемы"></textarea>
            </div>
            <button type="submit" class="submit-btn">Отправить заявку</button>
        </form>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>