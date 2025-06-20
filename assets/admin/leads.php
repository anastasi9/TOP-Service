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

// Обработка формы редактирования
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_lead'])) {
        $lead_id = $_POST['lead_id'];
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $description = $_POST['description'];
        $message = $_POST['message'];
        
        $stmt = $conn->prepare("UPDATE leads SET name = ?, phone = ?, email = ?, description = ?, message = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $name, $phone, $email, $description, $message, $lead_id);
        $stmt->execute();
        
        // Перенаправляем чтобы избежать повторной отправки формы
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    
    // Обработка удаления лида
    if (isset($_POST['delete_lead'])) {
        $lead_id = $_POST['lead_id'];
        $stmt = $conn->prepare("DELETE FROM leads WHERE id = ?");
        $stmt->bind_param("i", $lead_id);
        $stmt->execute();
        
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

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
    <style>
        .combined-description {
            max-width: 300px;
        }
        .description-title {
            font-weight: bold;
            color: #555;
        }
        .message-content {
            margin-top: 5px;
            color: #666;
        }
    </style>
</head>
<body>

<div class="admin-container">
<!-- Sidebar -->
    <div class="sidebar">
        <h2>Панель управления</h2>
        <a href="<?= $_SESSION['user_role'] === 'admin' ? '/assets/admin/admin_main.php' : '/assets/moderator/moderator.php' ?>" 
        <?= ($_SESSION['user_role'] === 'admin' && basename($_SERVER['PHP_SELF']) === 'admin_main.php') || 
            ($_SESSION['user_role'] === 'moderator' && basename($_SERVER['PHP_SELF']) === 'moderator.php') ? 'class="active"' : '' ?>>
            <i class="fas fa-tachometer-alt"></i> Главная
        </a>
        <a href="\assets\admin\user_management\list_users.php" <?= basename($_SERVER['PHP_SELF']) === 'list_users.php' ? 'class="active"' : '' ?>>
            <i class="fas fa-users"></i> Пользователи
        </a>
        <a href="\assets\admin\leads.php" <?= basename($_SERVER['PHP_SELF']) === 'leads.php' ? 'class="active"' : '' ?>>
            <i class="fas fa-user-tag"></i> Лиды
        </a>
        <a href="\assets\admin\helpline\helpline.php" <?= basename($_SERVER['PHP_SELF']) === 'helpline.php' ? 'class="active"' : '' ?>>
            <i class="fas fa-headset"></i> Заявки
        </a>
    </div>

    <!-- Основной контент -->
    <div class="main-content">
        <div class="actions-header">
            <div class="dashboard-header">
                <h1><i class="fas fa-user-tag"></i> Лиды</h1>
            </div>
            <div class="search-filter">
                <input type="text" class="search-box" placeholder="Поиск по имени, email или телефону...">
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
                        <th>Email</th>
                        <th>Информация</th>
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
                            <td><a href="mailto:<?= htmlspecialchars($lead['email']) ?>"><?= htmlspecialchars($lead['email']) ?></a></td>
                            <td class="combined-description">
                                <?php if (!empty($lead['description'])): ?>
                                    <div class="description-title">Пометка:</div>
                                    <div title="<?= htmlspecialchars($lead['description']) ?>">
                                        <?= htmlspecialchars(mb_substr($lead['description'], 0, 30)) . (mb_strlen($lead['description']) > 30 ? '...' : '') ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($lead['message'])): ?>
                                    <div class="description-title" style="margin-top: 5px;">Комментарий лида:</div>
                                    <div class="message-content" title="<?= htmlspecialchars($lead['message']) ?>">
                                        <?= htmlspecialchars(mb_substr($lead['message'], 0, 30)) . (mb_strlen($lead['message']) > 30 ? '...' : '') ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><?= date('d.m.Y H:i', strtotime($lead['created_at'])) ?></td>
                            <td>
                                <button class="btn-edit" onclick="openEditModal(
                                    <?= $lead['id'] ?>, 
                                    '<?= htmlspecialchars($lead['name'], ENT_QUOTES) ?>', 
                                    '<?= htmlspecialchars($lead['phone'], ENT_QUOTES) ?>',
                                    '<?= htmlspecialchars($lead['email'], ENT_QUOTES) ?>',
                                    `<?= htmlspecialchars($lead['description'] ?? '', ENT_QUOTES) ?>`,
                                    `<?= htmlspecialchars($lead['message'] ?? '', ENT_QUOTES) ?>`
                                )">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-delete" onclick="confirmDelete(<?= $lead['id'] ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
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

<!-- Модальное окно редактирования -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <h2>Редактирование лида</h2>
        <form method="POST" action="">
            <input type="hidden" name="lead_id" id="edit_lead_id">
            
            <div class="form-group">
                <label for="name">Имя:</label>
                <input type="text" id="edit_name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Телефон:</label>
                <input type="text" id="edit_phone" name="phone" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="edit_email" name="email">
            </div>
            
            <div class="form-group">
                <label for="description">Пометка:</label>
                <textarea id="edit_description" name="description"></textarea>
            </div>
            
            <div class="form-group">
                <label for="message">Комментарий от лида:</label>
                <textarea id="edit_message" name="message"></textarea>
            </div>
            
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Отмена</button>
                <button type="submit" class="btn btn-primary" name="update_lead">Сохранить</button>
            </div>
        </form>
    </div>
</div>

<!-- Модальное окно подтверждения удаления -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <h2>Подтверждение удаления</h2>
        <p>Вы уверены, что хотите удалить этого лида?</p>
        <form method="POST" action="">
            <input type="hidden" name="lead_id" id="delete_lead_id">
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Отмена</button>
                <button type="submit" class="btn btn-primary" name="delete_lead">Удалить</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Функции для работы с модальными окнами
    function openEditModal(id, name, phone, email, description, message) {
        document.getElementById('edit_lead_id').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_phone').value = phone;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_description').value = description;
        document.getElementById('edit_message').value = message;
        document.getElementById('editModal').style.display = 'block';
    }
    
    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }
    
    function confirmDelete(id) {
        document.getElementById('delete_lead_id').value = id;
        document.getElementById('deleteModal').style.display = 'block';
    }
    
    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }
    
    // Закрытие модальных окон при клике вне их
    window.onclick = function(event) {
        if (event.target.className === 'modal') {
            closeEditModal();
            closeDeleteModal();
        }
    }
</script>

</body>
</html>