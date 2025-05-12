<?php 
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
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
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if(empty($username) || empty($password)){
          echo('Поля не заполнены');
        } else {
          $sql = "SELECT * FROM `users` WHERE username = '$username' AND password = '$password'";
          $result = $conn->query($sql);

          if($result -> num_rows > 0){
            while($row = $result->fetch_assoc()){
              $_SESSION['user_role'] = $row['role'];
              /* $_SESSION['user_id'] = $row['id']; */
              header('Location: admin/admin_main.php');
              exit();
            }
          }else{
            echo 'Пользователя не существует';
          }
        }
      }
    ?>

    <script src="/assets/js/form_validation.js"></script>
    <script src="/assets/js/main.js"></script>
</body>
</html>