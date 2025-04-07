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
?>