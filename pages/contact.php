<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контакты</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=<?= time() ?>">
    <link rel="icon" href="/assets/img/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon">
</head>
<body>
<?php
session_start();
require_once '../includes/header.php';
require_once '../includes/db_connect.php';

// Обработка отправки формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    // Валидация полей
    if (empty($name) || empty($phone)) {
        $_SESSION['error_message'] = "Пожалуйста, заполните все поля.";
    } else {
        try {
            // Подготовленный запрос для вставки данных в таблицу leads
            $stmt = $conn->prepare("INSERT INTO leads (name, phone) VALUES (?, ?)");
            $stmt->bind_param("ss", $name, $phone);

            // Выполняем запрос
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Спасибо! Мы свяжемся с вами.";
            } else {
                $_SESSION['error_message'] = "Ошибка: Не удалось отправить заявку.";
            }

            // Закрываем подготовленный запрос
            $stmt->close();
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Произошла ошибка: " . htmlspecialchars($e->getMessage());
        }
        
        // Перенаправляем на эту же страницу, чтобы избежать повторной отправки формы
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!-- Вывод сообщений об ошибках/успехе -->
<?php if (isset($_SESSION['error_message'])): ?>
    <div class='error-message'><?= $_SESSION['error_message'] ?></div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['success_message'])): ?>
    <div class='success-message'><?= $_SESSION['success_message'] ?></div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<section id="offices" class="offices-section small-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-header">
                    <h2>Наши офисы</h2>
                    <p>
                        <strong>Телефон:</strong> 
                        <a href="tel:+78005006468">+7 (800) 500-64-68</a>
                        <br>
                        <strong>Email:</strong> 
                        <a href="mailto:support@it-horeca.ru">support@it-horeca.ru</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
    </section>
<!-- Блок с первой картой -->
<section id="map" class="map-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Адрес офиса в Москве</h3>
                <h4>Москва, улица Земляной Вал, 64с2</h4>
                <div class="yandex-map">
                    <iframe src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Ac60a8269ed6c6fa4a4084f0ecab17c80b6e1e6959fd2f6b5275e1df30928a49f" 
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
                    <iframe src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A6d086fb90b7155018d13ffd0a985b4efcd43f34ec08f470b92e516d959b75086" 
                            width="100%" height="400" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>


<section id="order" class="service-section">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="service-form-container">
                    <div class="section-header">
                        <h2>Оставить заявку на консультацию</h2>
                        <p>Заполните форму и мы с вами свяжемся</p>
                    </div>
                    
                    <form class="service-form" method="POST" action="">
                        <div class="form-group">
                            <label>Ваше имя</label>
                            <input type="text" name="name" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Телефон</label>
                            <input type="tel" name="phone" required>
                        </div>
                        <button type="submit" class="service-btn btn-primary">Отправить заявку</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
</body>