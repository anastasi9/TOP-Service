<?php
// Проверяем, не подключены ли уже необходимые файлы
if (!isset($conn)) {
    require_once __DIR__ . '/../includes/db_connect.php';

}

// Функция для валидации телефона
function validatePhone($phone) {
    $cleaned = preg_replace('/[^0-9]/', '', $phone);
    
    if (strlen($cleaned) === 10) {
        return '7' . $cleaned;
    } elseif (strlen($cleaned) === 11 && ($cleaned[0] === '7' || $cleaned[0] === '8')) {
        return '7' . substr($cleaned, 1);
    }
    
    return false;
}

// Обработка отправки формы
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_form_submit'])) {
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Пожалуйста, укажите ваше имя.";
    }
    
    if (empty($phone)) {
        $errors[] = "Пожалуйста, укажите ваш телефон.";
    } elseif (!($validatedPhone = validatePhone($phone))) {
        $errors[] = "Пожалуйста, укажите корректный номер телефона.";
    } else {
        $phone = $validatedPhone;
    }
    
    if (empty($email)) {
        $errors[] = "Пожалуйста, укажите ваш email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Пожалуйста, укажите корректный email.";
    }
    
    if (empty($errors)) {
        try {
            $stmt = $conn->prepare("INSERT INTO leads (name, phone, email, message) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $phone, $email, $message);

            if ($stmt->execute()) {
                $_SESSION['form_submitted'] = true;
                $_SESSION['form_data'] = ['name' => $name];

            } else {
                $_SESSION['error_message'] = "Ошибка: Не удалось отправить заявку.";
            }

            $stmt->close();
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Произошла ошибка: " . htmlspecialchars($e->getMessage());
        }
    } else {
        $_SESSION['error_message'] = implode("<br>", $errors);
    }
}
?>



<!-- Вывод сообщений об ошибках -->
<?php if (isset($_SESSION['error_message'])): ?>
    <div class='error-message'><?= $_SESSION['error_message'] ?></div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<!-- Форма -->
<div class="service-form-container">
    <div class="section-header">
        <h2>Оставить заявку на консультацию</h2>
        <p>Заполните форму и мы с вами свяжемся</p>
    </div>
    
    <form class="service-form" method="POST" action="" id="contactForm">
        <input type="hidden" name="contact_form_submit" value="1">
        
        <div class="form-group">
            <label>Ваше имя <span class="required">*</span></label>
            <input type="text" name="name" required minlength="2" maxlength="50">
        </div>
        
        <div class="form-group">
            <label>Телефон <span class="required">*</span></label>
            <input type="tel" name="phone" id="phoneInput" required>

        </div>
        
        <div class="form-group">
            <label>Email <span class="required">*</span></label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Комментарий</label>
            <textarea name="message" maxlength="500"></textarea>
        </div>
        
        <button type="submit" class="service-btn btn-primary">Отправить заявку</button>
    </form>
</div>



<!-- Скрипты -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
<script>
$(document).ready(function() {
    // Маска для телефона
    $('#phoneInput').inputmask({
        mask: '+7 (999) 999-99-99',
        placeholder: '_',
        showMaskOnHover: false,
        showMaskOnFocus: true,
        clearIncomplete: true
    });

    // Валидация формы
    $('#contactForm').on('submit', function(e) {
        let isValid = true;
        const phone = $('#phoneInput').val();
        const phoneDigits = phone.replace(/\D/g, '');

        if (phoneDigits.length !== 11 || (phoneDigits[0] !== '7' && phoneDigits[0] !== '8')) {
            alert('Пожалуйста, введите корректный номер телефона');
            $('#phoneInput').focus();
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
});


</script>