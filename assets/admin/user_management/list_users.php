<?php
$servername = 'localhost';
$username = 'root';
$password = "mysql";
$dbname = 'topservice_db';

// Создаем соединение MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем соединение
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Устанавливаем кодировку
$conn->set_charset("utf8");
?>
<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}
// Установка кодировки
$conn->set_charset('utf8');

// Пагинация
$per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $per_page;

// Поиск и фильтрация
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$role_filter = isset($_GET['role']) ? $conn->real_escape_string($_GET['role']) : '';

// Запрос для подсчета общего количества пользователей
$count_query = "SELECT COUNT(*) as total FROM users WHERE 1=1";
if (!empty($search)) {
    $count_query .= " AND (username LIKE '%$search%' OR email LIKE '%$search%')";
}
if (!empty($role_filter)) {
    $count_query .= " AND role = '$role_filter'";
}

$count_result = $conn->query($count_query);
$total_users = $count_result->fetch_assoc()['total'];
$count_result->free();

// Запрос для получения пользователей
$query = "SELECT id, username, email, role, is_banned, created_at FROM users WHERE 1=1";
if (!empty($search)) {
    $query .= " AND (username LIKE '%$search%' OR email LIKE '%$search%')";
}
if (!empty($role_filter)) {
    $query .= " AND role = '$role_filter'";
}
$query .= " ORDER BY created_at DESC LIMIT $per_page OFFSET $offset";

$result = $conn->query($query);
$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
$result->free();

// Обработка действий
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $user_id = (int)$_POST['user_id'];
    $action = $_POST['action'];
    $message = '';
    
    switch ($action) {
        case 'ban':
            $conn->query("UPDATE users SET is_banned = 1 WHERE id = $user_id");
            $message = "Пользователь заблокирован";
            break;
            
        case 'unban':
            $conn->query("UPDATE users SET is_banned = 0 WHERE id = $user_id");
            $message = "Пользователь разблокирован";
            break;
            
        case 'delete':
            if ($user_id == $_SESSION['user_id']) {
                $message = "Вы не можете удалить свой собственный аккаунт";
            } else {
                $conn->query("DELETE FROM users WHERE id = $user_id AND role != 'admin'");
                $message = "Пользователь удален";
            }
            break;
            
        case 'make_admin':
            $conn->query("UPDATE users SET role = 'admin' WHERE id = $user_id");
            $message = "Пользователь назначен администратором";
            break;
        case 'change_role':
            $new_role = $conn->real_escape_string($_POST['new_role']);
            if (in_array($new_role, ['user', 'moderator', 'admin'])) {
                // Защита от изменения собственной роли
                $current_user_id = $_SESSION['user_id'];
                if ($user_id == $current_user_id) {
                    $message = "Вы не можете изменить свою собственную роль";
                } else {
                    $conn->query("UPDATE users SET role = '$new_role' WHERE id = $user_id");
                    $message = "Роль пользователя изменена на: " . ucfirst($new_role);
                }
            } else {
                $message = "Недопустимая роль";
            }
            break;
    }
    
    $_SESSION['flash_message'] = $message;
    header("Location: list_users.php?" . http_build_query($_GET));
    exit();
}

// Обработка создания пользователя
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_user'])) {
    $username = $conn->real_escape_string(trim($_POST['new_username']));
    $email = $conn->real_escape_string(trim($_POST['new_email']));
    $password = password_hash(trim($_POST['new_password']), PASSWORD_DEFAULT);
    $role = $conn->real_escape_string($_POST['new_role']);

    if (!empty($username) && !empty($email) && !empty($password)) {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssss", $username, $email, $password, $role);

        if ($stmt->execute()) {
            $_SESSION['flash_message'] = "Пользователь успешно создан.";
        } else {
            $_SESSION['flash_message'] = "Ошибка при создании пользователя.";
        }

        $stmt->close();
        header("Location: list_users.php?" . http_build_query($_GET));
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Управление пользователями</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/admin.css?v=<?= time() ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<div class="admin-container">
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Админ панель</h2>
        <a href="/assets/admin/admin_main.php"><i class="fas fa-tachometer-alt"></i> Главная</a>
        <a href="list_users.php" class="active"><i class="fas fa-users"></i> Пользователи</a>
        <a href="#"><i class="fas fa-concierge-bell"></i> Услуги</a>
        <a href="#"><i class="fas fa-clipboard-list"></i> Заявки</a>
        <a href="#"><i class="fas fa-cog"></i> Настройки</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="dashboard-header">
            <h1><i class="fas fa-users"></i> Управление пользователями</h1>
            <a href="/logout.php" class="logout-btn">Выйти</a>
        </div>

        <!-- Flash сообщения -->
        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="flash-message"><?= $_SESSION['flash_message'] ?></div>
            <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>

        <!-- Фильтры -->
        <form method="get" class="user-filter-form">
            <div class="form-group">
                <i class="fas fa-search"></i>
                <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Поиск по имени или email">
            </div>
            
            <div class="form-group">
                <select name="role">
                    <option value="">Все роли</option>
                    <option value="admin" <?= $role_filter === 'admin' ? 'selected' : '' ?>>Администраторы</option>
                    <option value="moderator" <?= $role_filter === 'moderator' ? 'selected' : '' ?>>Модераторы</option>
                    <option value="user" <?= $role_filter === 'user' ? 'selected' : '' ?>>Пользователи</option>
                </select>
            </div>
            
            <button type="submit" class="btn-filter">
                <i class="fas fa-filter"></i> Фильтровать
            </button>
            <a href="list_users.php" class="btn-reset">
                <i class="fas fa-times"></i> Сбросить
            </a>
        </form>
        <!-- Форма добавления нового пользователя -->
        <div class="add-user-form">
            <h2>Добавить нового пользователя</h2>
            <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
                <input type="text" name="new_username" placeholder="Логин" required>
                <input type="email" name="new_email" placeholder="Email" required>
                <input type="password" name="new_password" placeholder="Пароль" required>
                <select name="new_role">
                    <option value="user">Пользователь</option>
                    <option value="moderator">Модератор</option>
                </select>
                <button type="submit" name="create_user" class="btn-create">Создать пользователя</button>
            </form>
        </div>
        <?php if (!empty($search) || !empty($role_filter)): ?>
            <div class="filter-info">
                Применены фильтры:
                <?php if (!empty($search)): ?> Поиск: <strong><?= htmlspecialchars($search) ?></strong><?php endif; ?>
                <?php if (!empty($role_filter)): ?> Роль: <strong><?= htmlspecialchars($role_filter) ?></strong><?php endif; ?>
                <a href="list_users.php" style="color:#007bff;">Сбросить</a>
            </div>
        <?php endif; ?>
        <!-- Таблица пользователей -->
        <div class="table-container">
            <table class="users-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Логин</th>
                        <th>Email</th>
                        <th>Роль</th>
                        <th>Статус</th>
                        <th>Дата регистрации</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td>
                            <span class="role-badge role-<?= $user['role'] ?>">
                                <?= $user['role'] ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($user['is_banned']): ?>
                                <span class="status-badge status-banned">Заблокирован</span>
                            <?php else: ?>
                                <span class="status-badge status-active">Активен</span>
                            <?php endif; ?>
                        </td>
                        <td><?= date('d.m.Y H:i', strtotime($user['created_at'])) ?></td>
                        <td class="actions">
                            <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                <?php if ($user['is_banned']): ?>
                                    <form method="post" class="action-form">
                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                        <button type="submit" name="action" value="unban" class="btn-action btn-unban">
                                            <i class="fas fa-unlock"></i>
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <form method="post" class="action-form">
                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                        <button type="submit" name="action" value="ban" class="btn-action btn-ban">
                                            <i class="fas fa-lock"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                                
                                    <!-- Выпадающий список смены роли -->
                                <form method="post" class="action-form role-change-form">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <input type="hidden" name="action" value="change_role">
                                    <select name="new_role" onchange="this.form.submit()">
                                        <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>Пользователь</option>
                                        <option value="moderator" <?= $user['role'] === 'moderator' ? 'selected' : '' ?>>Модератор</option>
                                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Администратор</option>
                                    </select>
                                </form>
                                
                                <form method="post" class="action-form" onsubmit="return confirm('Вы уверены?')">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <button type="submit" name="action" value="delete" class="btn-action btn-delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
<input type="hidden" name="action" value="change_role">
       <!-- Пагинация -->
<div class="pagination">
    <?php
    $total_pages = ceil($total_users / $per_page);
    // Сохраняем текущие параметры фильтрации и поиска
    $query_params = [];
    if (!empty($search)) $query_params['search'] = $search;
    if (!empty($role_filter)) $query_params['role'] = $role_filter;

    // Кнопка "Назад"
    if ($page > 1): 
        $query_params['page'] = $page - 1;
    ?>
        <a href="?<?= http_build_query($query_params) ?>" class="page-nav">
            <i class="fas fa-chevron-left"></i>
        </a>
    <?php endif; ?>

    <?php 
    // Нумерация страниц
    for ($i = 1; $i <= $total_pages; $i++):
        $query_params['page'] = $i;
    ?>
        <a href="?<?= http_build_query($query_params) ?>" <?= $i === $page ? 'class="active"' : '' ?>>
            <?= $i ?>
        </a>
    <?php endfor; ?>

    <?php 
    // Кнопка "Вперед"
    if ($page < $total_pages): 
        $query_params['page'] = $page + 1;
    ?>
        <a href="?<?= http_build_query($query_params) ?>" class="page-nav">
            <i class="fas fa-chevron-right"></i>
        </a>
    <?php endif; ?>
</div>
    </div>
</div>

<?php $conn->close(); ?>
</body>
</html>

