<?php require 'includes/auth.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Вход</title>
</head>
<body>
    <form method="post">
        <input type="text" name="username" placeholder="Логин" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit" name="login">Войти</button>
    </form>
</body>
</html>