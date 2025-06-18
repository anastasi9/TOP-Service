<?php
// Подключение к БД
require_once '../../../includes/db_connect.php';

session_start();

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// Определяем роль пользователя
$is_moderator = ($_SESSION['user_role'] == 'moderator' || $_SESSION['user_role'] == 'admin');

// Обработка отправки новой заявки
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_ticket'])) {
    $user_id = $_SESSION['user_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $status = 'open';
    $created_at = date('Y-m-d H:i:s');
    
    $query = "INSERT INTO tickets (user_id, title, description, status, created_at) 
              VALUES ('$user_id', '$title', '$description', '$status', '$created_at')";
    mysqli_query($conn, $query);
    $ticket_id = mysqli_insert_id($conn);
    
    // Обработка загрузки файлов
    if (!empty($_FILES['attachments']['name'][0])) {
        foreach ($_FILES['attachments']['tmp_name'] as $key => $tmp_name) {
            $file_name = $_FILES['attachments']['name'][$key];
            $file_tmp = $_FILES['attachments']['tmp_name'][$key];
            $file_path = "/uploads/tickets/" . time() . "_" . basename($file_name);
            move_uploaded_file($file_tmp, $_SERVER['DOCUMENT_ROOT'] . $file_path);
            
            $query = "INSERT INTO ticket_attachments (ticket_id, file_path) 
                      VALUES ('$ticket_id', '$file_path')";
            mysqli_query($conn, $query);
        }
    }
    
    header("Location: helpline.php?success=1");
    exit;
}

// Обработка комментария модератора
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_comment'], $_POST['ticket_id'])) {
    $user_id = $_SESSION['user_id'];
    $ticket_id = mysqli_real_escape_string($conn, $_POST['ticket_id']);
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    
    // Только модераторы и админы могут менять статус
    if ($_SESSION['user_role'] === 'moderator' || $_SESSION['user_role'] === 'admin') {
        $status = mysqli_real_escape_string($conn, $_POST['status'] ?? 'open');

        // Вставка комментария
        $query = "INSERT INTO ticket_comments (ticket_id, user_id, comment, created_at) 
                  VALUES ('$ticket_id', '$user_id', '$comment', NOW())";
        mysqli_query($conn, $query);

        // Обновление статуса заявки
        $update_query = "UPDATE tickets SET status = '$status' WHERE id = '$ticket_id'";
        mysqli_query($conn, $update_query);
    }

    header("Location: helpline.php?ticket=$ticket_id");
    exit;
}

// Получение списка заявок
if ($is_moderator) {
    $query = "SELECT t.*, u.username FROM tickets t JOIN users u ON t.user_id = u.id ORDER BY t.created_at DESC";
} else {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM tickets WHERE user_id = '$user_id' ORDER BY created_at DESC";
}
$tickets_result = mysqli_query($conn, $query);

// Получение данных конкретной заявки
if (isset($_GET['ticket'])) {
    $ticket_id = mysqli_real_escape_string($conn, $_GET['ticket']);
    $ticket_query = "SELECT t.*, u.username FROM tickets t JOIN users u ON t.user_id = u.id WHERE t.id = '$ticket_id'";
    $ticket_result = mysqli_query($conn, $ticket_query);
    $ticket = mysqli_fetch_assoc($ticket_result);
    
    // Получение комментариев
    $comments_query = "SELECT tc.*, u.username FROM ticket_comments tc JOIN users u ON tc.user_id = u.id WHERE tc.ticket_id = '$ticket_id' ORDER BY tc.created_at ASC";
    $comments_result = mysqli_query($conn, $comments_query);
    
    // Получение вложений
    $attachments_query = "SELECT * FROM ticket_attachments WHERE ticket_id = '$ticket_id'";
    $attachments_result = mysqli_query($conn, $attachments_query);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Система заявок</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/admin.css?v=<?= time() ?>">
</head>
<body>
<?php include '../includes/admin_header.php'; ?>
<div class="helpline-container">
    <div class="helpline-header">
        <h1><i class="fas fa-life-ring"></i> Центр поддержки</h1>
        <?php if (!$is_moderator): ?>
            <button class="btn-new-ticket" id="newTicketBtn"><i class="fas fa-plus"></i> Новая заявка</button>
        <?php endif; ?>
    </div>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            Заявка успешно создана! Мы решим её в ближайшее время.
        </div>
    <?php endif; ?>
    
    <div class="helpline-content">
        <?php if (!isset($_GET['ticket'])): ?>
            <!-- Список заявок -->
            <div class="tickets-list">
                <div class="tickets-filter">
                    <input type="text" id="ticketSearch" placeholder="Поиск по заявкам...">
                    <?php if ($is_moderator): ?>
                        <select id="statusFilter">
                            <option value="">Все статусы</option>
                            <option value="open">Открытые</option>
                            <option value="in_progress">В работе</option>
                            <option value="closed">Закрытые</option>
                        </select>
                    <?php endif; ?>
                </div>
                
                <table class="tickets-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Тема</th>
                            <th>Статус</th>
                            <th>Автор</th>
                            <th>Дата создания</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($ticket = mysqli_fetch_assoc($tickets_result)): ?>
                            <tr data-status="<?= $ticket['status'] ?>">
                                <td><?= $ticket['id'] ?></td>
                                <td><?= htmlspecialchars($ticket['title']) ?></td>
                                <td>
                                    <span class="status-badge status-<?= $ticket['status'] ?>">
                                        <?php 
                                            switch($ticket['status']) {
                                                case 'open': echo 'Открыта'; break;
                                                case 'in_progress': echo 'В работе'; break;
                                                case 'closed': echo 'Закрыта'; break;
                                            }
                                        ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($ticket['username'] ?? 'Пользователь') ?></td>
                                <td><?= date('d.m.Y H:i', strtotime($ticket['created_at'])) ?></td>
                                <td>
                                    <a href="helpline.php?ticket=<?= $ticket['id'] ?>" class="btn-view"><i class="fas fa-eye"></i></a>
                                    <?php if ($is_moderator): ?>
                                        <a href="#" class="btn-edit" data-id="<?= $ticket['id'] ?>"><i class="fas fa-edit"></i></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <!-- Детали заявки -->
            <div class="ticket-details">
                <a href="helpline.php" class="btn-back"><i class="fas fa-arrow-left"></i> Назад к списку</a>
                
                <div class="ticket-header">
                    <h2><?= htmlspecialchars($ticket['title']) ?></h2>
                    <span class="status-badge status-<?= $ticket['status'] ?>">
                        <?php 
                            switch($ticket['status']) {
                                case 'open': echo 'Открыта'; break;
                                case 'in_progress': echo 'В работе'; break;
                                case 'closed': echo 'Закрыта'; break;
                            }
                        ?>
                    </span>
                </div>
                
                <div class="ticket-meta">
                    <span><i class="fas fa-user"></i> <?= htmlspecialchars($ticket['username']) ?></span>
                    <span><i class="fas fa-calendar-alt"></i> <?= date('d.m.Y H:i', strtotime($ticket['created_at'])) ?></span>
                </div>
                
                <div class="ticket-description">
                    <h3>Описание проблемы:</h3>
                    <p><?= nl2br(htmlspecialchars($ticket['description'])) ?></p>
                </div>
                
                <?php if (mysqli_num_rows($attachments_result) > 0): ?>
                    <div class="ticket-attachments">
                        <h3>Вложения:</h3>
                        <div class="attachments-grid">
                            <?php while ($attachment = mysqli_fetch_assoc($attachments_result)): ?>
                                <?php 
                                    $ext = pathinfo($attachment['file_path'], PATHINFO_EXTENSION);
                                    $is_image = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif']);
                                    $is_video = in_array(strtolower($ext), ['mp4', 'mov', 'avi']);
                                ?>
                                <div class="attachment-item">
                                    <?php if ($is_image): ?>
                                        <a href="<?= $attachment['file_path'] ?>" data-lightbox="ticket-attachments">
                                            <img src="<?= $attachment['file_path'] ?>" alt="Вложение">
                                        </a>
                                    <?php elseif ($is_video): ?>
                                        <video controls>
                                            <source src="<?= $attachment['file_path'] ?>" type="video/<?= $ext ?>">
                                        </video>
                                    <?php else: ?>
                                        <a href="<?= $attachment['file_path'] ?>" download>
                                            <i class="fas fa-file-download"></i> Скачать файл
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="ticket-comments">
                    <h3>Комментарии:</h3>
                    
                    <div class="comments-list">
                        <?php while ($comment = mysqli_fetch_assoc($comments_result)): ?>
                            <div class="comment-item <?= $comment['user_id'] == $ticket['user_id'] ? 'user-comment' : 'moderator-comment' ?>">
                                <div class="comment-header">
                                    <strong><?= htmlspecialchars($comment['username']) ?></strong>
                                    <span><?= date('d.m.Y H:i', strtotime($comment['created_at'])) ?></span>
                                </div>
                                <div class="comment-body">
                                    <?= nl2br(htmlspecialchars($comment['comment'])) ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    
                    <?php if ($ticket['status'] != 'closed'): ?>
                        <form method="POST" class="comment-form">
                            <input type="hidden" name="ticket_id" value="<?= $ticket['id'] ?>">
                            <textarea name="comment" placeholder="Оставьте ваш комментарий..." required></textarea>
                            <?php if ($is_moderator): ?>
                                <div class="comment-actions">
                                    <select name="status" required>
                                        <option value="open" <?= $ticket['status'] == 'open' ? 'selected' : '' ?>>Открыта</option>
                                        <option value="in_progress" <?= $ticket['status'] == 'in_progress' ? 'selected' : '' ?>>В работе</option>
                                        <option value="closed" <?= $ticket['status'] == 'closed' ? 'selected' : '' ?>>Закрыта</option>
                                    </select>
                                    <button type="submit" name="submit_comment" class="btn-submit">Отправить</button>
                                </div>
                            <?php else: ?>
                                <button type="submit" name="submit_comment" class="btn-submit">Отправить</button>
                            <?php endif; ?>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
    
    <!-- Модальное окно новой заявки -->
    <div id="newTicketModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Создание новой заявки</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Тема заявки:</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="description">Описание проблемы:</label>
                    <textarea id="description" name="description" rows="5" required></textarea>
                </div>
                <div class="form-group">
                    <label for="attachments">Вложения (если есть):</label>
                    <input type="file" id="attachments" name="attachments[]" multiple>
                    <small>Можно прикрепить несколько файлов (изображения, видео, документы)</small>
                </div>
                <button type="submit" name="submit_ticket" class="btn-submit">Отправить заявку</button>
            </form>
        </div>
    </div>
    

</body>
</html>
