<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Автоматизация</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=<?= time() ?>">
    <link rel="icon" href="/assets/img/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon">
</head>
<body>
<?php
require_once '../includes/header.php';
?>

<main class="automation-page">
    <!-- Герой-секция -->
    <section class="automation-hero">
        <div class="container">
            <h1 class="hero-title">Автоматизация для всей HoReCa</h1>
            <div class="hero-features">
                <div class="feature-item">
                    <svg><!-- Иконка кассы --></svg>
                    <span>Кассовая автоматизация</span>
                </div>
                <div class="feature-item">
                    <svg><!-- Иконка склада --></svg>
                    <span>Складской учет</span>
                </div>
                <div class="feature-item">
                    <svg><!-- Иконка ключа --></svg>
                    <span>Автоматизация под ключ</span>
                </div>
                <div class="feature-item">
                    <svg><!-- Иконка поддержки --></svg>
                    <span>Техническая поддержка 24/7</span>
                </div>
            </div>
            <a href="#order" class="cta-button">Заказать внедрение</a>
        </div>
    </section>

    <!-- Кассовая автоматизация -->
    <section id="cash-system" class="section">
        <div class="container">
            <h2 class="section-title">Кассовая автоматизация</h2>
            <p class="section-description">
                R-keeper - автоматизированная система для управления и контроля рестораном, баром, кофейней, столовой 
                и другими видами бизнеса
            </p>
            
            <div class="solutions-grid">
                <!-- Решение 1 -->
                <div class="solution-card">
                    <div class="solution-header">
                        <h3>R-keeper Базовый</h3>
                        <div class="price-tag">от 25 000 ₽</div>
                    </div>
                    <ul class="solution-features">
                        <li>Управление заказами и обслуживанием</li>
                        <li>Интеграция с кассовыми аппаратами</li>
                        <li>Базовая аналитика продаж</li>
                        <li>Поддержка 1 рабочего места</li>
                    </ul>
                    <div class="solution-actions">
                        <a href="#order" class="btn-primary" data-solution="R-keeper Базовый">Заказать</a>
                        <a href="#details-rk-basic" class="btn-outline">Подробнее</a>
                    </div>
                </div>
                
                <!-- Решение 2 -->
                <div class="solution-card highlighted">
                    <div class="solution-badge">Популярный</div>
                    <div class="solution-header">
                        <h3>R-keeper Cloud</h3>
                        <div class="price-tag">от 45 000 ₽</div>
                    </div>
                    <ul class="solution-features">
                        <li>Все возможности Базовой версии</li>
                        <li>Удаленный доступ из любой точки</li>
                        <li>Автоматическое обновление</li>
                        <li>Резервное копирование данных</li>
                        <li>Поддержка до 5 рабочих мест</li>
                    </ul>
                    <div class="solution-actions">
                        <a href="#order" class="btn-primary" data-solution="R-keeper Cloud">Заказать</a>
                        <a href="#details-rk-cloud" class="btn-outline">Подробнее</a>
                    </div>
                </div>
                
                <!-- Решение 3 -->
                <div class="solution-card">
                    <div class="solution-header">
                        <h3>Полный пакет</h3>
                        <div class="price-tag">от 75 000 ₽</div>
                    </div>
                    <ul class="solution-features">
                        <li>Все возможности Cloud версии</li>
                        <li>Интеграция с 1С и другими системами</li>
                        <li>Персональный менеджер</li>
                        <li>Обучение персонала</li>
                        <li>Неограниченные рабочие места</li>
                    </ul>
                    <div class="solution-actions">
                        <a href="#order" class="btn-primary" data-solution="Полный пакет">Заказать</a>
                        <a href="#details-full" class="btn-outline">Подробнее</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Форма заказа -->
    <section id="order" class="order-section">
        <div class="container">
            <div class="order-form-container">
                <h2 class="form-title">Оставить заявку</h2>
                <form class="automation-form" id="automation-form">
                    <div class="form-group">
                        <label for="solution-type">Решение</label>
                        <select id="solution-type" name="solution_type" required>
                            <option value="" disabled selected>Выберите решение</option>
                            <option value="rk-basic">R-keeper Базовый</option>
                            <option value="rk-cloud">R-keeper Cloud</option>
                            <option value="full-pack">Полный пакет</option>
                            <option value="custom">Индивидуальное решение</option>
                        </select>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="contact-name">Ваше имя*</label>
                            <input type="text" id="contact-name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="contact-phone">Телефон*</label>
                            <input type="tel" id="contact-phone" name="phone" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="business-type">Тип бизнеса</label>
                        <select id="business-type" name="business_type">
                            <option value="" selected>Не выбрано</option>
                            <option value="restaurant">Ресторан</option>
                            <option value="cafe">Кафе</option>
                            <option value="bar">Бар</option>
                            <option value="hotel">Отель</option>
                            <option value="other">Другое</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Дополнительная информация</label>
                        <textarea id="message" name="message" rows="4"></textarea>
                    </div>
                    
                    <div class="form-footer">
                        <button type="submit" class="submit-btn">Отправить заявку</button>
                        <p class="form-notice">
                            Нажимая кнопку, вы соглашаетесь с 
                            <a href="/privacy-policy">политикой конфиденциальности</a>
                        </p>
                    </div>
                </form>
            </div>
            
            <div class="order-image">
                <img src="/img/automation/order-image.jpg" alt="Автоматизация HoReCa">
            </div>
        </div>
    </section>
</main>

<?php
require_once '../includes/footer.php';
?>
</body>