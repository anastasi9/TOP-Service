#проверка прав
<?php
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$current_user = $_SESSION['user'];
?>
<?php
// includes/check_role.php
session_start();

function is_admin() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}

function is_moderator() {
    return isset($_SESSION['user']) && ($_SESSION['user']['role'] === 'moderator' || is_admin());
}

function check_permission($required_role) {
    switch ($required_role) {
        case 'admin':
            if (!is_admin()) die("Доступ запрещен");
            break;
        case 'moderator':
            if (!is_moderator()) die("Доступ запрещен");
            break;
    }
}

function can_edit_services() {
    return is_admin() || is_moderator();
}

function can_manage_users() {
    return is_admin();
}

function can_view_requests() {
    return is_admin() || is_moderator();
}

function can_change_request_status() {
    return is_admin() || is_moderator();
}

function can_view_portfolio() {
    return true; // Доступно всем
}

function can_edit_portfolio() {
    return is_admin() || is_moderator();
}
?>
