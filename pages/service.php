<?php
require_once '../includes/header.php';
?>

<main class="service-page">
    <!-- Герой-секция с параллакс-эффектом -->
    <section class="service-hero parallax">
        <div class="overlay"></div>
        <div class="container">
            <div class="hero-content">
                <h1 class="animate-fade-in">Сервисное обслуживание</h1>
                <p class="subtitle animate-slide-up">Профессиональная поддержка вашего бизнеса 24/7</p>
                <div class="highlight-box animate-slide-up">
                    <p>Техническая поддержка • Проактивный мониторинг • Гарантированное время реакции</p>
                </div>
                <a href="#order" class="cta-button pulse">Оставить заявку</a>
            </div>
        </div>
    </section>

    <!-- Преимущества -->
    <section class="benefits-section">
        <div class="container">
            <div class="section-header">
                <h2>Почему выбирают наше обслуживание</h2>
                <p class="section-subtitle">Мы обеспечиваем максимальную надежность ваших систем</p>
            </div>
            
            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg><!-- Иконка часов --></svg>
                    </div>
                    <h3>24/7 Поддержка</h3>
                    <p>Круглосуточная техническая поддержка без выходных и праздников</p>
                </div>
                
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg><!-- Иконка гарантии --></svg>
                    </div>
                    <h3>Гарантия SLA</h3>
                    <p>Строгое соблюдение соглашений об уровне сервиса</p>
                </div>
                
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <svg><!-- Иконка специалистов --></svg>
                    </div>
                    <h3>Эксперты</h3>
                    <p>Сертифицированные специалисты с опытом от 5 лет</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Тарифы -->
    <section class="plans-section">
        <div class="container">
            <div class="section-header">
                <h2>Пакеты обслуживания</h2>
                <p class="section-subtitle">Выберите оптимальное решение для вашего бизнеса</p>
            </div>
            
            <div class="plans-tabs">
                <div class="tab-nav">
                    <button class="tab-btn active" data-tab="info">Информационное</button>
                    <button class="tab-btn" data-tab="tech">Техническое</button>
                    <button class="tab-btn" data-tab="complex">Комплексное</button>
                </div>
                
                <div class="tab-content active" id="info">
                    <div class="plan-card">
                        <div class="plan-header">
                            <h3>Информационное обслуживание</h3>
                            <p class="tech-note">Технология: Эксперт удаления</p>
                        </div>
                        
                        <div class="plan-details">
                            <div class="details-col">
                                <h4>Преимущества:</h4>
                                <ul class="feature-list">
                                    <li>Удаленный мониторинг систем</li>
                                    <li>Консультационная поддержка</li>
                                    <li>Регулярные отчеты</li>
                                    <li>Рекомендации по оптимизации</li>
                                </ul>
                            </div>
                            
                            <div class="details-col">
                                <h4>Что входит:</h4>
                                <ul class="included-list">
                                    <li>Круглосуточная поддержка</li>
                                    <li>Реагирование в течение 2 часов</li>
                                    <li>10 удаленных подключений в месяц</li>
                                    <li>Ежемесячный аудит</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="plan-footer">
                            <div class="price">от 32 000 ₽/мес</div>
                            <div class="plan-actions">
                                <a href="#order" class="order-btn" data-plan="Информационное">Заказать</a>
                                <a href="#consult" class="consult-btn">Консультация</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Аналогичные блоки для других тарифов -->
            </div>
        </div>
    </section>

    <!-- Форма заявки -->
    <section id="order" class="order-section">
        <div class="container">
            <div class="form-container">
                <div class="form-header">
                    <h2>Оставить заявку</h2>
                    <p>Заполните форму и наш менеджер свяжется с вами в течение 15 минут</p>
                </div>
                
                <form class="order-form" id="service-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="service-type">Тип обслуживания*</label>
                            <select id="service-type" name="service_type" required>
                                <option value="" disabled selected>Выберите тип</option>
                                <option value="information">Информационное</option>
                                <option value="technical">Техническое</option>
                                <option value="complex">Комплексное</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Ваше имя*</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Телефон*</label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Дополнительная информация</label>
                        <textarea id="message" name="message" rows="4"></textarea>
                    </div>
                    
                    <div class="form-footer">
                        <button type="submit" class="submit-btn">
                            <span>Отправить заявку</span>
                            <svg><!-- Иконка стрелки --></svg>
                        </button>
                        <p class="form-note">Нажимая кнопку, вы соглашаетесь с политикой конфиденциальности</p>
                    </div>
                </form>
            </div>
            
            <div class="form-image">
                <img src="/img/service-form-image.jpg" alt="Сервисное обслуживание">
            </div>
        </div>
    </section>

    <!-- Отзывы -->
    <section class="testimonials-section">
        <div class="container">
            <div class="section-header">
                <h2>Отзывы клиентов</h2>
                <p class="section-subtitle">Что говорят о нашем сервисе</p>
            </div>
            
            <div class="testimonials-slider">
                <!-- Слайды с отзывами -->
            </div>
        </div>
    </section>

    <!-- Клиенты -->
    <section class="clients-section">
        <div class="container">
            <div class="section-header">
                <h2>Нам доверяют</h2>
                <p class="section-subtitle">Более 200 компаний по всей России</p>
            </div>
            
            <div class="clients-slider">
                <div class="client-logo">
                    <img src="/img/clients/client1.svg" alt="Логотип клиента">
                </div>
                <!-- Остальные логотипы -->
            </div>
        </div>
    </section>
</main>

<?php
require_once '../includes/footer.php';
?>