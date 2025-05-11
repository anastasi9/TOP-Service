<?php
require_once '../includes/db_connect.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Валидация данных
    $service_type = sanitize_input($_POST['service_type']);
    $name = sanitize_input($_POST['name']);
    $company = sanitize_input($_POST['company']);
    $phone = sanitize_input($_POST['phone']);
    $email = sanitize_input($_POST['email']);
    $message = sanitize_input($_POST['message']);
    
    // Проверка обязательных полей
    if (empty($service_type) || empty($name) || empty($phone) || empty($email)) {
        header('Location: /pages/service.php?error=required_fields');
        exit;
    }
    
    // Проверка email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: /pages/service.php?error=invalid_email');
        exit;
    }
    
    // Сохранение в базу данных
    try {
        $stmt = $pdo->prepare("INSERT INTO service_requests 
                              (service_type, name, company, phone, email, message, created_at) 
                              VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$service_type, $name, $company, $phone, $email, $message]);
        
        // Отправка email уведомления (опционально)
        send_service_request_email($email, $name, $service_type);
        
        header('Location: /pages/service.php?success=request_sent');
        exit;
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        header('Location: /pages/service.php?error=db_error');
        exit;
    }
} else {
    header('Location: /pages/service.php');
    exit;
}