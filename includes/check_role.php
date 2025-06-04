<?php
function is_admin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

function is_moderator() {
    return isset($_SESSION['user_role']) && ($_SESSION['user_role'] === 'moderator' || is_admin());
}

function checkRole($requiredRole) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login.php');
        exit;
    }
    
    global $conn;
    
    // Проверяем, не забанен ли пользователь
    $stmt = $conn->prepare("SELECT is_banned FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    if ($user['is_banned'] == 1) {
        session_destroy();
        header('Location: /login.php?banned=1');
        exit;
    }
    
    // Проверяем роль
    if ($_SESSION['user_role'] !== $requiredRole) {
        header('HTTP/1.0 403 Forbidden');
        die('Доступ запрещен. Недостаточно прав.');
    }
}
?>