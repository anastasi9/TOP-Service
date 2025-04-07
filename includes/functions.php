<?php
// C:\Program Files\Ampps\www\includes\functions.php

/**
 * Проверяет, авторизован ли пользователь
 */
function is_logged_in() {
    return isset($_SESSION['user']);
}

/**
 * Возвращает текущего пользователя
 */
function current_user() {
    return $_SESSION['user'] ?? null;
}

/**
 * Проверяет, имеет ли пользователь указанную роль
 */
function has_role($role) {
    return is_logged_in() && $_SESSION['user']['role'] === $role;
}

/**
 * Редирект с сообщением
 */
function redirect_with_message($url, $message, $type = 'success') {
    $_SESSION['flash'][$type] = $message;
    header("Location: $url");
    exit;
}

/**
 * Хеширование пароля
 */
function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

/**
 * Валидация email
 */
function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Защита от XSS
 */
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Получение настроек сайта
 */
function get_settings($db) {
    try {
        $stmt = $db->query("SELECT setting_key, setting_value FROM settings");
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    } catch (PDOException $e) {
        error_log("Settings error: " . $e->getMessage());
        return [];
    }
}

/**
 * Логирование действий
 */
function log_action($db, $user_id, $action) {
    $stmt = $db->prepare("INSERT INTO logs (user_id, action) VALUES (?, ?)");
    $stmt->execute([$user_id, $action]);
}

/**
 * Генерация CSRF-токена
 */
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Проверка CSRF-токена
 */
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

require_once 'includes/functions.php';
die("Файл functions.php успешно подключен!");

