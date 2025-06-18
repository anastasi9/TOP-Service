<?php 
session_start();
require 'includes/db_connect.php'; 
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #533b77; /* Основной фиолетовый фон */
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .auth-form {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            width: 320px;
            text-align: center;
        }

        .auth-form h2 {
            color: #000000;
            margin-bottom: 20px;
        }

        .auth-form input[type="text"],
        .auth-form input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            color: #000000;
        }

        .auth-form button {
            width: 100%;
            padding: 12px;
            background-color: #e17400; /* Цвет призыва */
            color: #ffffff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .auth-form button:hover {
            background-color: #c96400;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <form method="post" id="login-form" class="auth-form">
        <h2>Вход</h2>
        <input type="text" name="username" placeholder="Логин" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit" name="login">Войти</button>

        <?php
        if (isset($_POST['login'])) {
            $username = $conn->real_escape_string($_POST['username']);
            $password = $conn->real_escape_string($_POST['password']);
            
            if(empty($username) || empty($password)){
                echo '<div class="error-message">Поля не заполнены</div>';
            } else {
                $sql = "SELECT * FROM users WHERE username = '$username'";
                $result = $conn->query($sql);

                if($result->num_rows > 0){
                    $row = $result->fetch_assoc();
                    
                    if($password === $row['password']) {
                        $_SESSION['user_role'] = $row['role'];
                        $_SESSION['user_id'] = $row['id'];
                        $_SESSION['username'] = $row['username'];
                        
                        if($row['role'] === 'admin') {
                            header('Location: /assets/admin/admin_main.php');
                        } else if($row['role'] === 'moderator') {
                            header('Location: /assets/moderator/moderator.php');
                        } else if($row['role'] === 'user') {
                            header('Location: /assets/admin/users/user.php');
                        } else {
                            header('Location: /');
                        }
                        exit();
                    } else {
                        echo '<div class="error-message">Неверный пароль</div>';
                    }
                } else {
                    echo '<div class="error-message">Пользователя не существует</div>';
                }
            }
        }
        ?>
    </form>

    <!-- Скрипт для валидации формы -->
    <script src="/assets/js/form_validation.js"></script>
</body>
</html>