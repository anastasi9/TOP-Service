<?php
/**
 * Основные функции системы
 */

/**
 * Устанавливает соединение с базой данных
 */
function get_db_connection() {
    static $pdo = null;
    
    if ($pdo === null) {
        try {
            $pdo = new PDO(
                'mysql:host=localhost;dbname=topservice_db;charset=utf8mb4',
                'root',
                'mysql',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            error_log("DB Connection Error: " . $e->getMessage());
            die("Ошибка подключения к базе данных");
        }
    }
    
    return $pdo;
}

/**
 * Проверяет авторизацию пользователя
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Проверяет роль пользователя
 */
function has_role($role) {
    if (!is_logged_in()) return false;
    
    $pdo = get_db_connection();
    $stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    
    return $user && $user['role'] === $role;
}

/**
 * Перенаправление с сообщением
 */
function redirect_with_message($url, $message, $type = 'success') {
    $_SESSION['flash_message'] = [
        'text' => $message,
        'type' => $type
    ];
    header("Location: $url");
    exit;
}

/**
 * Получает количество пользователей
 */
function get_user_count() {
    $pdo = get_db_connection();
    try {
        return $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    } catch (PDOException $e) {
        error_log("User count error: " . $e->getMessage());
        return 0;
    }
}

/**
 * Получает количество услуг
 */
function get_service_count() {
    $pdo = get_db_connection();
    try {
        return $pdo->query("SELECT COUNT(*) FROM services")->fetchColumn();
    } catch (PDOException $e) {
        error_log("Service count error: " . $e->getMessage());
        return 0;
    }
}

/**
 * Получает активные заявки
 */
function get_active_requests() {
    $pdo = get_db_connection();
    try {
        return $pdo->query("SELECT COUNT(*) FROM requests WHERE status = 'pending'")->fetchColumn();
    } catch (PDOException $e) {
        error_log("Requests count error: " . $e->getMessage());
        return 0;
    }
}

/**
 * Получает последние действия
 */
function get_recent_activities($limit = 5) {
    $pdo = get_db_connection();
    try {
        $stmt = $pdo->prepare("
            SELECT l.*, u.username 
            FROM logs l
            JOIN users u ON l.user_id = u.id
            ORDER BY l.created_at DESC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Recent activities error: " . $e->getMessage());
        return [];
    }
}

/**
 * Защита от XSS
 */
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
