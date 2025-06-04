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
require_once '../includes/header.php';
?>

<main class="education-page">
    <!-- Герой-секция -->
    <section class="education-hero">
        <div class="container">
            <h1>Профессиональное обучение</h1>
            <p class="hero-subtitle">Освойте современные системы автоматизации для вашего бизнеса</p>
            <a href="#courses" class="cta-button">Смотреть программы</a>
        </div>
    </section>

    <!-- Курсы обучения -->
    <section id="courses" class="courses-section">
        <div class="container">
            <div class="section-header">
                <h2>Наши учебные программы</h2>
                <p class="section-subtitle">Выберите подходящий курс для вашей команды</p>
            </div>

            <div class="courses-grid">
                <!-- Курс 1 -->
                <div class="course-card">
                    <div class="course-badge">Популярный</div>
                    <div class="course-image" style="background-image: url('/img/education/rkeeper-course.jpg');"></div>
                    <div class="course-content">
                        <h3>R-Keeper для начинающих</h3>
                        <ul class="course-features">
                            <li><i class="fas fa-clock"></i> 24 академических часа</li>
                            <li><i class="fas fa-user-graduate"></i> Сертификат по окончании</li>
                            <li><i class="fas fa-users"></i> До 10 человек в группе</li>
                        </ul>
                        <p class="course-description">Полный курс по работе с системой R-Keeper для новых сотрудников и владельцев заведений.</p>
                        <div class="course-footer">
                            <div class="course-price">15 000 ₽</div>
                            <a href="#enroll" class="enroll-btn" data-course="R-Keeper для начинающих">Записаться</a>
                        </div>
                    </div>
                </div>

                <!-- Курс 2 -->
                <div class="course-card">
                    <div class="course-image" style="background-image: url('/img/education/1c-course.jpg');"></div>
                    <div class="course-content">
                        <h3>1С:Ресторан ПРОФ</h3>
                        <ul class="course-features">
                            <li><i class="fas fa-clock"></i> 36 академических часов</li>
                            <li><i class="fas fa-user-graduate"></i> Сертификат 1С</li>
                            <li><i class="fas fa-users"></i> До 8 человек в группе</li>
                        </ul>
                        <p class="course-description">Профессиональное обучение работе с 1С:Ресторан для администраторов и управляющих.</p>
                        <div class="course-footer">
                            <div class="course-price">25 000 ₽</div>
                            <a href="#enroll" class="enroll-btn" data-course="1С:Ресторан ПРОФ">Записаться</a>
                        </div>
                    </div>
                </div>

                <!-- Курс 3 -->
                <div class="course-card">
                    <div class="course-image" style="background-image: url('/img/education/bitrix-course.jpg');"></div>
                    <div class="course-content">
                        <h3>Битрикс24 для HoReCa</h3>
                        <ul class="course-features">
                            <li><i class="fas fa-clock"></i> 20 академических часов</li>
                            <li><i class="fas fa-user-graduate"></i> Сертификат Битрикс</li>
                            <li><i class="fas fa-users"></i> До 12 человек в группе</li>
                        </ul>
                        <p class="course-description">Эффективное использование Битрикс24 для управления ресторанным бизнесом.</p>
                        <div class="course-footer">
                            <div class="course-price">18 000 ₽</div>
                            <a href="#enroll" class="enroll-btn" data-course="Битрикс24 для HoReCa">Записаться</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Форма записи -->
    <section id="enroll" class="enroll-section">
        <div class="container">
            <div class="enroll-form-container">
                <h2>Запись на обучение</h2>
                <form class="enroll-form" id="enroll-form">
                    <div class="form-group">
                        <label for="course-select">Выберите курс*</label>
                        <select id="course-select" name="course" required>
                            <option value="" disabled selected>-- Выберите курс --</option>
                            <option value="R-Keeper для начинающих">R-Keeper для начинающих</option>
                            <option value="1С:Ресторан ПРОФ">1С:Ресторан ПРОФ</option>
                            <option value="Битрикс24 для HoReCa">Битрикс24 для HoReCa</option>
                            <option value="Индивидуальное обучение">Индивидуальное обучение</option>
                        </select>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="student-name">Ваше имя*</label>
                            <input type="text" id="student-name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="student-phone">Телефон*</label>
                            <input type="tel" id="student-phone" name="phone" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="student-email">Email*</label>
                        <input type="email" id="student-email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="student-count">Количество участников</label>
                        <input type="number" id="student-count" name="count" min="1" value="1">
                    </div>
                    
                    <div class="form-group">
                        <label for="student-comment">Комментарий</label>
                        <textarea id="student-comment" name="comment" rows="3"></textarea>
                    </div>
                    
                    <button type="submit" class="submit-btn">Отправить заявку</button>
                    
                    <div class="form-notice">
                        Нажимая кнопку, вы соглашаетесь с 
                        <a href="/privacy-policy">политикой конфиденциальности</a>
                    </div>
                </form>
            </div>
            
            <div class="enroll-info">
                <h3>Как проходит обучение?</h3>
                <ul class="info-list">
                    <li><i class="fas fa-check-circle"></i> Очные и онлайн-форматы</li>
                    <li><i class="fas fa-check-circle"></i> Практические занятия на реальных примерах</li>
                    <li><i class="fas fa-check-circle"></i> Сертифицированные преподаватели</li>
                    <li><i class="fas fa-check-circle"></i> Учебные материалы предоставляются</li>
                    <li><i class="fas fa-check-circle"></i> Поддержка после обучения</li>
                </ul>
                
                <div class="contacts-block">
                    <h3>Контакты учебного центра</h3>
                    <p><i class="fas fa-phone"></i> +7 (999) 123-45-67</p>
                    <p><i class="fas fa-envelope"></i> education@topservice.ru</p>
                    <p><i class="fas fa-map-marker-alt"></i> г. Сочи, ул. Примерная, 123</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
require_once '../includes/footer.php';
?>
</body>