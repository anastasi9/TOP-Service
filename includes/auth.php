<?php
// C:\Program Files\Ampps\www\includes\auth.php

// Старт сессии с улучшенными параметрами безопасности
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 86400,
        'path' => '/',
        'domain' => $_SERVER['HTTP_HOST'],
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Strict'
    ]);
    session_start();
    session_regenerate_id(true);
}

require_once 'db_connect.php';

class Auth {
    private static $db;
    
    public static function init($db_connection) {
        self::$db = $db_connection;
    }

    /**
     * Регистрация нового пользователя с валидацией
     */
    public static function register($username, $email, $password, $secret_code = null) {
        // Валидация ввода
        if (!self::validate_username($username)) {
            return 'Логин должен быть от 3 до 30 символов (a-z, 0-9, _)';
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Некорректный email';
        }
        
        if (strlen($password) < 8) {
            return 'Пароль должен содержать минимум 8 символов';
        }

        // Определение роли
        $role = self::determine_role($secret_code);

        try {
            $stmt = self::$db->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->execute([
                self::sanitize_input($username),
                self::sanitize_input($email),
                self::hash_password($password),
                $role
            ]);
            return true;
        } catch (PDOException $e) {
            return self::handle_registration_error($e);
        }
    }

    /**
     * Аутентификация пользователя с защитой от brute-force
     */
    public static function login($username, $password) {
        try {
            // Задержка для защиты от brute-force
            sleep(1);
            
            $stmt = self::$db->prepare("
                SELECT id, username, email, password, role, is_banned, login_attempts 
                FROM users 
                WHERE username = ? OR email = ?
                LIMIT 1
            ");
            $stmt->execute([$username, $username]);
            $user = $stmt->fetch();

            if (!$user) {
                return 'Неверный логин или пароль';
            }

            // Проверка блокировки
            if ($user['is_banned']) {
                return 'Ваш аккаунт заблокирован';
            }

            // Проверка пароля
            if (password_verify($password, $user['password'])) {
                // Сброс счетчика попыток
                self::reset_login_attempts($user['id']);
                
                // Создание сессии
                self::create_user_session($user);
                return true;
            } else {
                // Увеличение счетчика попыток
                self::increment_login_attempts($user['id']);
                return 'Неверный логин или пароль';
            }
        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            return 'Ошибка входа';
        }
    }

    // Остальные методы класса (logout, is_logged_in и т.д.)...
    
    private static function determine_role($secret_code) {
        $roles = [
            'ADMIN123' => 'admin',
            'MOD456' => 'moderator'
        ];
        return $roles[$secret_code] ?? 'user';
    }
    
    private static function create_user_session($user) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'role' => $user['role'],
            'ip' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'last_login' => time()
        ];
    }
    
    private static function validate_username($username) {
        return preg_match('/^[a-zA-Z0-9_]{3,30}$/', $username);
    }
    
    private static function sanitize_input($data) {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }
    
    private static function hash_password($password) {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }
    
    private static function handle_registration_error($e) {
        if ($e->getCode() == 23000) {
            return 'Пользователь с таким email или логином уже существует';
        }
        error_log("Registration error: " . $e->getMessage());
        return 'Ошибка регистрации';
    }
}

// Инициализация класса Auth
Auth::init($dbname);

// Обработка POST-запросов
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $result = Auth::login($_POST['username'], $_POST['password']);
        if ($result === true) {
            header("Location: /dashboard.php");
            exit;
        } else {
            $_SESSION['login_error'] = $result;
            header("Location: /login.php");
            exit;
        }
    }
    
    if (isset($_POST['register'])) {
        $result = Auth::register(
            $_POST['username'],
            $_POST['email'],
            $_POST['password'],
            $_POST['secret_code'] ?? null
        );
        
        if ($result === true) {
            $_SESSION['register_success'] = "Регистрация успешна! Теперь вы можете войти.";
            header("Location: /login.php");
            exit;
        } else {
            $_SESSION['register_error'] = $result;
            $_SESSION['register_form_data'] = [
                'username' => $_POST['username'],
                'email' => $_POST['email']
            ];
            header("Location: /register.php");
            exit;
        }
    }
    
    if (isset($_POST['logout'])) {
        Auth::logout();
        header("Location: /");
        exit;
    }
}
?>