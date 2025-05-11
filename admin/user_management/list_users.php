<?php
require_once __DIR__ . '/../includes/admin_header.php';

// Пагинация
$per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $per_page;

// Поиск и фильтрация
$search = $_GET['search'] ?? '';
$role_filter = $_GET['role'] ?? '';

// Запрос пользователей
$query = "SELECT id, username, email, role, is_banned, created_at FROM users WHERE 1=1";
$params = [];

if ($search) {
    $query .= " AND (username LIKE ? OR email LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if ($role_filter) {
    $query .= " AND role = ?";
    $params[] = $role_filter;
}

// Общее количество пользователей
$count_query = "SELECT COUNT(*) FROM (" . $query . ") AS total";
$total_users = $pdo->prepare($count_query);
$total_users->execute($params);
$total_users = $total_users->fetchColumn();

// Получение пользователей для текущей страницы
$query .= " ORDER BY created_at DESC LIMIT ? OFFSET ?";
$params[] = $per_page;
$params[] = $offset;

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Обработка действий (бан/разбан/удаление)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $user_id = $_POST['user_id'];
    $action = $_POST['action'];
    
    switch ($action) {
        case 'ban':
            $stmt = $pdo->prepare("UPDATE users SET is_banned = 1 WHERE id = ?");
            $stmt->execute([$user_id]);
            $message = "Пользователь заблокирован";
            break;
            
        case 'unban':
            $stmt = $pdo->prepare("UPDATE users SET is_banned = 0 WHERE id = ?");
            $stmt->execute([$user_id]);
            $message = "Пользователь разблокирован";
            break;
            
        case 'delete':
            // Нельзя удалить самого себя
            if ($user_id == $_SESSION['user_id']) {
                $message = "Вы не можете удалить свой собственный аккаунт";
            } else {
                $stmt = $pdo->prepare("DELETE FROM users WHERE id = ? AND role != 'admin'");
                $stmt->execute([$user_id]);
                $message = "Пользователь удален";
            }
            break;
            
        case 'make_admin':
            $stmt = $pdo->prepare("UPDATE users SET role = 'admin' WHERE id = ?");
            $stmt->execute([$user_id]);
            $message = "Пользователь назначен администратором";
            break;
    }
    
    // Логирование действия
    $log_stmt = $pdo->prepare("INSERT INTO activity_log (user_id, action, details) VALUES (?, ?, ?)");
    $log_stmt->execute([
        $_SESSION['user_id'],
        'user_' . $action,
        "User ID: $user_id"
    ]);
    
    $_SESSION['flash_message'] = $message;
    header("Location: list_users.php?" . http_build_query($_GET));
    exit;
}

// Отображение flash-сообщений
if (isset($_SESSION['flash_message'])) {
    echo '<div class="flash-message">' . $_SESSION['flash_message'] . '</div>';
    unset($_SESSION['flash_message']);
}
?>

<h1>Управление пользователями</h1>

<form method="get" class="user-filter-form">
    <div class="form-group">
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
    
    <button type="submit" class="btn-filter">Фильтровать</button>
    <a href="list_users.php" class="btn-reset">Сбросить</a>
</form>

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
            <td><?= $user['role'] ?></td>
            <td><?= $user['is_banned'] ? 'Заблокирован' : 'Активен' ?></td>
            <td><?= date('d.m.Y H:i', strtotime($user['created_at'])) ?></td>
            <td class="actions">
                <?php if ($user['id'] != $_SESSION['user_id']): ?>
                    <?php if ($user['is_banned']): ?>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            <button type="submit" name="action" value="unban" class="btn-unban">Разблокировать</button>
                        </form>
                    <?php else: ?>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            <button type="submit" name="action" value="ban" class="btn-ban">Заблокировать</button>
                        </form>
                    <?php endif; ?>
                    
                    <?php if ($user['role'] != 'admin'): ?>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            <button type="submit" name="action" value="make_admin" class="btn-make-admin">Сделать админом</button>
                        </form>
                    <?php endif; ?>
                    
                    <form method="post" style="display: inline;" onsubmit="return confirm('Вы уверены?')">
                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                        <button type="submit" name="action" value="delete" class="btn-delete">Удалить</button>
                    </form>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="pagination">
    <?php
    $total_pages = ceil($total_users / $per_page);
    $query_params = $_GET;
    unset($query_params['page']);
    
    for ($i = 1; $i <= $total_pages; $i++):
        $query_params['page'] = $i;
    ?>
        <a href="?<?= http_build_query($query_params) ?>" <?= $i === $page ? 'class="active"' : '' ?>><?= $i ?></a>
    <?php endfor; ?>
</div>

<?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>