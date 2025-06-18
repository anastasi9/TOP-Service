<?php
session_start();

// Проверка авторизации
$allowed_roles = ['admin', 'moderator'];

if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], $allowed_roles)) {
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
    <title>Лиды</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/admin.css?v=<?= time() ?>">
</head>
<body>

<div class="admin-container">
<!-- Sidebar -->
    <div class="sidebar">
        <h2>Панель управления</h2>
        <a href="\assets\admin\admin_main.php" <?= basename($_SERVER['PHP_SELF']) === 'admin_main.php' ? 'class="active"' : '' ?>>
            <i class="fas fa-tachometer-alt"></i> Главная
        </a>
        <a href="\assets\admin\user_management\list_users.php" <?= basename($_SERVER['PHP_SELF']) === 'list_users.php' ? 'class="active"' : '' ?>>
            <i class="fas fa-users"></i> Пользователи
        </a>
        <a href="\assets\admin\leads.php" <?= basename($_SERVER['PHP_SELF']) === 'leads.php' ? 'class="active"' : '' ?>>
            <i class="fas fa-tachometer-alt"></i> Лиды
        </a>
        <a href="\assets\admin\helpline\helpline.php" <?= basename($_SERVER['PHP_SELF']) === 'helpline.php' ? 'class="active"' : '' ?>>
            <i class="fas fa-tachometer-alt"></i> Заявки
        </a>
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