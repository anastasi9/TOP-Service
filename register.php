<?php
require_once 'includes/db_connect.php';
require_once 'includes/auth.php';
require_once 'includes/check_role.php';

// Инициализация переменных для формы
$username = $email = $role = '';
$errors = [];

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение и валидация данных
    $username = trim($_POST['username'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $secret_code = $_POST['secret_code'] ?? '';

    // Валидация
    if (empty($username)) $errors[] = 'Логин обязателен';
    if (!$email) $errors[] = 'Некорректный email';
    if (strlen($password) < 8) $errors[] = 'Пароль должен быть не менее 8 символов';
    if ($password !== $confirm_password) $errors[] = 'Пароли не совпадают';

    // Если ошибок нет - пробуем регистрацию
    if (empty($errors)) {
        try {
            // Определение роли
            $role = 'user';
            if ($secret_code === 'ADMIN123') {
                $role = 'admin';
            } elseif ($secret_code === 'MOD456') {
                $role = 'moderator';
            }

            // Хеширование пароля
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // Запрос к БД
            $stmt = $db->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->execute([$username, $email, $password_hash, $role]);

            // Редирект после успешной регистрации
            $_SESSION['registration_success'] = true;
            header('Location: login.php');
            exit;
        } catch (PDOException $e) {
            // Обработка ошибок БД
            if ($e->getCode() == 23000) {
                $errors[] = 'Пользователь с таким именем или email уже существует';
            } else {
                $errors[] = 'Ошибка регистрации: ' . $e->getMessage();
            }
        }
    }
}

// Подключение шаблонов с проверкой их существования
function load_template($name) {
    $path = __DIR__ . '/templates/' . $name . '.php';
    if (file_exists($path)) {
        include $path;
    } else {
        die("Шаблон $name не найден");
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Регистрация</h1>
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label for="username">Логин:</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($username) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Подтвердите пароль:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <div class="form-group">
                <label for="secret_code">Секретный код (если есть):</label>
                <input type="text" id="secret_code" name="secret_code">
            </div>
            
            <button type="submit" class="btn">Зарегистрироваться</button>
        </form>
        
        <p>Уже есть аккаунт? <a href="login.php">Войдите</a></p>
    </div>
</body>
</html>