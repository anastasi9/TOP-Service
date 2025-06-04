<?php 
session_start();
require 'includes/db_connect.php'; 
?>

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

    <?php
    if (isset($_POST['login'])) {
        $username = $conn->real_escape_string($_POST['username']);
        $password = $conn->real_escape_string($_POST['password']);
        
        if(empty($username) || empty($password)){
            echo('Поля не заполнены');
        } else {
            $sql = "SELECT * FROM users WHERE username = '$username'";
            $result = $conn->query($sql);

            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                // Проверка пароля (в реальном проекте используйте password_verify())
                if($password === $row['password']) {
                    $_SESSION['user_role'] = $row['role'];
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['username'] = $row['username'];
                    
                    if($row['role'] === 'admin') {
                        header('Location: /assets/admin/admin_main.php');
                    } else {
                        header('Location: /');
                    }
                    exit();
                } else {
                    echo 'Неверный пароль';
                }
            } else {
                echo 'Пользователя не существует';
            }
        }
    }
    ?>

    <script src="/assets/js/form_validation.js"></script>
</body>
</html>