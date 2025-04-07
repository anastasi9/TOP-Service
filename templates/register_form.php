<?php
// C:\Program Files\Ampps\www\templates\register_form.php

// Проверяем, есть ли сообщения об ошибках
$errors = $_SESSION['register_errors'] ?? [];
unset($_SESSION['register_errors']);

// Получаем сохраненные данные формы (если были ошибки)
$form_data = $_SESSION['register_form_data'] ?? [];
unset($_SESSION['register_form_data']);
?>

<div class="registration-form">
    <h2>Регистрация нового пользователя</h2>
    
    <?php if (isset($_SESSION['register_success'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['register_success'], ENT_QUOTES, 'UTF-8') ?>
            <a href="login.php">Войти в систему</a>
        </div>
        <?php unset($_SESSION['register_success']); ?>
    <?php else: ?>
    
    <form method="post" action="register.php" class="needs-validation" novalidate>
        <!-- Поле для имени пользователя -->
        <div class="form-group">
            <label for="username">Логин:</label>
            <input type="text" id="username" name="username" 
                   class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>" 
                   value="<?= htmlspecialchars($form_data['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>" 
                   required minlength="3" maxlength="50">
            <?php if (isset($errors['username'])): ?>
                <div class="invalid-feedback">
                    <?= htmlspecialchars($errors['username'], ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Поле для email -->
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" 
                   class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                   value="<?= htmlspecialchars($form_data['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" 
                   required>
            <?php if (isset($errors['email'])): ?>
                <div class="invalid-feedback">
                    <?= htmlspecialchars($errors['email'], ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Поле для пароля -->
        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" 
                   class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                   required minlength="6">
            <?php if (isset($errors['password'])): ?>
                <div class="invalid-feedback">
                    <?= htmlspecialchars($errors['password'], ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Подтверждение пароля -->
        <div class="form-group">
            <label for="password_confirm">Подтвердите пароль:</label>
            <input type="password" id="password_confirm" name="password_confirm" 
                   class="form-control <?= isset($errors['password_confirm']) ? 'is-invalid' : '' ?>" 
                   required>
            <?php if (isset($errors['password_confirm'])): ?>
                <div class="invalid-feedback">
                    <?= htmlspecialchars($errors['password_confirm'], ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Секретный код (для регистрации модераторов/админов) -->
        <?php if (isset($_GET['secret_code'])): ?>
            <div class="form-group">
                <label for="secret_code">Код доступа:</label>
                <input type="text" id="secret_code" name="secret_code" 
                       class="form-control" 
                       value="<?= htmlspecialchars($_GET['secret_code'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>
        <?php endif; ?>
        
        <!-- Кнопка отправки -->
        <button type="submit" class="btn btn-primary btn-block">Зарегистрироваться</button>
        
        <div class="mt-3 text-center">
            Уже есть аккаунт? <a href="login.php">Войдите</a>
        </div>
    </form>
    
    <?php endif; ?>
</div>

<script>
// Валидация формы на клиенте
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

// Проверка совпадения паролей
document.getElementById('password_confirm').addEventListener('input', function() {
    const password = document.getElementById('password');
    const confirm = this;
    
    if (password.value !== confirm.value) {
        confirm.setCustomValidity('Пароли не совпадают');
    } else {
        confirm.setCustomValidity('');
    }
});
</script>