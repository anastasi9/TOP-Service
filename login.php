<?php require 'includes/auth.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Вход</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <form method="post" id="login-form" class="auth-form">
        <input type="text" name="username" placeholder="Логин" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit" name="login">Войти</button>
    </form>

    <script src="/assets/js/form_validation.js"></script>
    <script src="/assets/js/main.js"></script>
</body>
</html>