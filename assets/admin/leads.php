<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../../../../login.php');
    exit();
}

// Подключение к БД
require_once '../../includes/db_connect.php';

// Получаем всех лидов из таблицы leads
$sql = "SELECT * FROM leads ORDER BY created_at DESC";
$result = $conn->query($sql);
$leads = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $leads[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Лиды - Админ панель</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/admin.css?v=<?= time() ?>">
</head>
<body>

<div class="admin-container">
    <!-- Боковое меню -->
    <div class="sidebar">
        <h2><i class="fas fa-user-shield"></i> Админ-панель</h2>
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Дашборд</a>
        <a href="services.php"><i class="fas fa-concierge-bell"></i> Услуги</a>
        <a href="leads.php" class="active"><i class="fas fa-user-tag"></i> Лиды</a>
        <a href="users.php"><i class="fas fa-users"></i> Пользователи</a>
        <a href="settings.php"><i class="fas fa-cog"></i> Настройки</a>
        <a href="/logout.php">Выйти</a>
    </div>

    <!-- Основной контент -->
    <div class="main-content">
        <div class="actions-header">
            <div class="dashboard-header">
                <h1><i class="fas fa-user-tag"></i> Лиды</h1>
            </div>
            <div class="search-filter">
                <input type="text" class="search-box" placeholder="Поиск по имени или телефону...">
                <input type="date" class="date-filter">
                <button class="export-btn"><i class="fas fa-file-export"></i> Экспорт</button>
            </div>
        </div>

        <?php if (count($leads) > 0): ?>
            <table class="leads-table">
                <thead>
                    <tr>
                        <th>#</th> 
                        <th>Имя</th>
                        <th>Телефон</th>
                        <th>Дата заявки</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($leads as $index => $lead): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($lead['name']) ?></td>
                            <td><a href="tel:<?= htmlspecialchars($lead['phone']) ?>"><?= htmlspecialchars($lead['phone']) ?></a></td>
                            <td><?= date('d.m.Y H:i', strtotime($lead['created_at'])) ?></td>
                            <td>
                                <button class="btn-edit"><i class="fas fa-eye"></i></button>
                                <button class="btn-delete"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-data"><i class="fas fa-info-circle"></i> Нет лидов. Заявки еще не поступали.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>