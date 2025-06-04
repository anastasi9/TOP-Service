<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=<?= time() ?>">
</head>
<body>
<?php
require_once '../includes/header.php';
?>
<link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
<main class="equipment-page">
    <!-- Герой-секция -->
    <section class="equipment-hero">
        <div class="container">
            <h1>Каталог оборудования</h1>
            <p class="hero-subtitle">Полные решения для автоматизации вашего бизнеса</p>
            <div class="hero-description">
                <p>Наша компания предоставляет готовые решения, программы для учета бизнеса, POS-системы и лицензии 1С. С помощью этих инструментов ваш бизнес будет развиваться, ведь автоматизация процессов — необходимый фактор успеха.</p>
            </div>
        </div>
    </section>

    <!-- Категории оборудования -->
    <section class="equipment-categories">
        <div class="container">
            <div class="section-header">
                <h2>Наши решения</h2>
                <p class="section-subtitle">Выберите подходящую категорию оборудования</p>
            </div>

            <div class="categories-grid">
                <!-- Категория 1 -->
                <div class="category-card">
                    <div class="category-header">
                        <h3>Готовые сайты</h3>
                        <span class="items-count">3 товара</span>
                    </div>
                    <div class="category-body">
                        <ul class="features-list">
                            <li>Интернет-магазины</li>
                            <li>Корпоративные сайты</li>
                            <li>Отраслевые сайты</li>
                        </ul>
                        <p class="category-description">Готовые решения интернет-магазина, корпоративных и отраслевых сайтов с гибкими настройками.</p>
                    </div>
                    <div class="category-footer">
                        <a href="/catalog/websites" class="btn-primary">Смотреть товары</a>
                    </div>
                </div>

                <!-- Категория 2 -->
                <div class="category-card">
                    <div class="category-header">
                        <h3>Лицензии 1С</h3>
                        <span class="items-count">4 товара</span>
                    </div>
                    <div class="category-body">
                        <ul class="features-list">
                            <li>1С:Предприятие</li>
                            <li>1С:Бухгалтерия</li>
                            <li>1С:Розница</li>
                            <li>1С:Документооборот</li>
                        </ul>
                        <p class="category-description">Прикладные решения, предназначенные для автоматизации ключевых задач учета и управления.</p>
                    </div>
                    <div class="category-footer">
                        <a href="/catalog/1c" class="btn-primary">Смотреть товары</a>
                    </div>
                </div>

                <!-- Категория 3 -->
                <div class="category-card">
                    <div class="category-header">
                        <h3>1С-Битрикс</h3>
                        <span class="items-count">4 товара</span>
                    </div>
                    <div class="category-body">
                        <ul class="features-list">
                            <li>Битрикс24</li>
                            <li>1С-Битрикс: Управление сайтом</li>
                            <li>Битрикс: CRM</li>
                            <li>Битрикс: Маркетинг</li>
                        </ul>
                        <p class="category-description">Профессиональная система для создания, поддержки и успешного развития веб-проектов.</p>
                    </div>
                    <div class="category-footer">
                        <a href="/catalog/bitrix" class="btn-primary">Смотреть товары</a>
                    </div>
                </div>

                <!-- Категория 4 -->
                <div class="category-card">
                    <div class="category-header">
                        <h3>Системы управления</h3>
                        <span class="items-count">3 товара</span>
                    </div>
                    <div class="category-body">
                        <ul class="features-list">
                            <li>KPI-системы</li>
                            <li>CRM-системы</li>
                            <li>ERP-системы</li>
                        </ul>
                        <p class="category-description">Комплексные программы для автоматизации бизнес-процессов и повышения KPI сотрудников.</p>
                    </div>
                    <div class="category-footer">
                        <a href="/catalog/management" class="btn-primary">Смотреть товары</a>
                    </div>
                </div>

                <!-- Категория 5 -->
                <div class="category-card">
                    <div class="category-header">
                        <h3>Битрикс24</h3>
                        <span class="items-count">2 товара</span>
                    </div>
                    <div class="category-body">
                        <ul class="features-list">
                            <li>Битрикс24 Старт</li>
                            <li>Битрикс24 Проект+</li>
                        </ul>
                        <p class="category-description">Полный комплекс инструментов для организации работы компании.</p>
                    </div>
                    <div class="category-footer">
                        <a href="/catalog/bitrix24" class="btn-primary">Смотреть товары</a>
                    </div>
                </div>

                <!-- Категория 6 -->
                <div class="category-card">
                    <div class="category-header">
                        <h3>Программы для учета</h3>
                        <span class="items-count">3 товара</span>
                    </div>
                    <div class="category-body">
                        <ul class="features-list">
                            <li>Учет производства</li>
                            <li>Учет персонала</li>
                            <li>Финансовый учет</li>
                        </ul>
                        <p class="category-description">Продукты для автоматизации процессов производства: от формирования электронных систем до управления кадровыми отделами.</p>
                    </div>
                    <div class="category-footer">
                        <a href="/catalog/accounting" class="btn-primary">Смотреть товары</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Преимущества -->
    <section class="equipment-benefits">
        <div class="container">
            <div class="section-header">
                <h2>Почему выбирают наше оборудование</h2>
            </div>
            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3>Простота внедрения</h3>
                    <p>Готовые решения, не требующие сложной настройки</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Техподдержка 24/7</h3>
                    <p>Круглосуточная помощь наших специалистов</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-ruble-sign"></i>
                    </div>
                    <h3>Гибкие цены</h3>
                    <p>Возможность подобрать решение под любой бюджет</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Форма запроса -->
    <section class="equipment-request">
        <div class="container">
            <div class="request-form">
                <h2>Нужна консультация?</h2>
                <p>Оставьте заявку и наш специалист поможет подобрать оптимальное решение</p>
                <form action="/submit-equipment-request" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Ваше имя" required>
                        </div>
                        <div class="form-group">
                            <input type="tel" name="phone" placeholder="Телефон" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <select name="category">
                            <option value="" disabled selected>Выберите категорию</option>
                            <option value="websites">Готовые сайты</option>
                            <option value="1c">Лицензии 1С</option>
                            <option value="bitrix">1С-Битрикс</option>
                            <option value="management">Системы управления</option>
                            <option value="bitrix24">Битрикс24</option>
                            <option value="accounting">Программы для учета</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <textarea name="message" placeholder="Ваш вопрос или комментарий"></textarea>
                    </div>
                    <button type="submit" class="btn-submit">Отправить запрос</button>
                </form>
            </div>
        </div>
    </section>
</main>

<?php
require_once '../includes/footer.php';
?>
</body>