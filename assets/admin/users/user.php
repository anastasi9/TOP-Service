<?php
// Включение отображения ошибок для разработки
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Подключение к БД и проверка авторизации
require_once '../../../includes/db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit;
}

// Проверка соединения с БД
if (!$conn) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

// Определяем режим работы (список или детали заявки)
$ticket_id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;
$is_ticket_details = ($ticket_id !== null);

if ($is_ticket_details) {
    // Режим просмотра деталей заявки
    $user_id = $_SESSION['user_id'];
    
    // Получение данных заявки
    $query = "SELECT t.*, u.username 
              FROM tickets t 
              JOIN users u ON t.user_id = u.id 
              WHERE t.id = '$ticket_id' AND t.user_id = '$user_id'";
    $ticket_result = mysqli_query($conn, $query);

    if (!$ticket_result || mysqli_num_rows($ticket_result) == 0) {
        header("Location: my_tickets.php");
        exit;
    }

    $ticket = mysqli_fetch_assoc($ticket_result);

    // Получение комментариев
    $comments_query = "SELECT tc.*, u.username 
                       FROM ticket_comments tc 
                       JOIN users u ON tc.user_id = u.id 
                       WHERE tc.ticket_id = '$ticket_id' 
                       ORDER BY tc.created_at ASC";
    $comments_result = mysqli_query($conn, $comments_query);

    // Получение вложений
    $attachments_query = "SELECT * FROM ticket_attachments WHERE ticket_id = '$ticket_id'";
    $attachments_result = mysqli_query($conn, $attachments_query);

    // Обработка нового комментария
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_comment'])) {
        $comment = mysqli_real_escape_string($conn, $_POST['comment']);
        
        $query = "INSERT INTO ticket_comments (ticket_id, user_id, comment, created_at) 
                  VALUES ('$ticket_id', '$user_id', '$comment', NOW())";
        
        if (mysqli_query($conn, $query)) {
            header("Location: ?id=$ticket_id");
            exit;
        } else {
            $comment_error = "Ошибка при добавлении комментария: " . mysqli_error($conn);
        }
    }
} else {
    // Режим списка заявок
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_ticket'])) {
        $user_id = $_SESSION['user_id'];
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $status = 'open';
        $created_at = date('Y-m-d H:i:s');
        
        $query = "INSERT INTO tickets (user_id, title, description, status, created_at) 
                  VALUES ('$user_id', '$title', '$description', '$status', '$created_at')";
        
        if (mysqli_query($conn, $query)) {
            $ticket_id = mysqli_insert_id($conn);
            
            // Обработка загрузки файлов
            if (!empty($_FILES['attachments']['name'][0])) {
                $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/tickets/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                foreach ($_FILES['attachments']['tmp_name'] as $key => $tmp_name) {
                    if ($_FILES['attachments']['error'][$key] === UPLOAD_ERR_OK) {
                        $file_name = basename($_FILES['attachments']['name'][$key]);
                        $file_tmp = $_FILES['attachments']['tmp_name'][$key];
                        $file_path = "/uploads/tickets/" . time() . "_" . $file_name;
                        
                        if (move_uploaded_file($file_tmp, $_SERVER['DOCUMENT_ROOT'] . $file_path)) {
                            $query = "INSERT INTO ticket_attachments (ticket_id, file_path) 
                                      VALUES ('$ticket_id', '$file_path')";
                            mysqli_query($conn, $query);
                        }
                    }
                }
            }
            
            header("Location: ?success=1");
            exit;
        } else {
            $ticket_error = "Ошибка при создании заявки: " . mysqli_error($conn);
        }
    }

    // Получение заявок пользователя
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM tickets WHERE user_id = '$user_id' ORDER BY created_at DESC";
    $tickets_result = mysqli_query($conn, $query);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $is_ticket_details ? 'Заявка #'.$ticket['id'] : 'Мои заявки' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/admin.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/assets/css/user_tickets.css?v=<?= time() ?>">
</head>
<body>

    
    <?php if ($is_ticket_details): ?>
        <!-- Детали заявки -->
        <div class="ticket-container">
            <a href="?" class="btn-back"><i class="fas fa-arrow-left"></i> Назад к списку</a>
            
            <?php if (isset($comment_error)): ?>
                <div class="alert alert-error"><?= $comment_error ?></div>
            <?php endif; ?>
            
            <div class="ticket-header">
                <h1>Заявка #<?= $ticket['id'] ?>: <?= htmlspecialchars($ticket['title']) ?></h1>
                <span class="status-badge status-<?= $ticket['status'] ?>">
                    <?= match($ticket['status']) {
                        'open' => 'Открыта',
                        'in_progress' => 'В работе',
                        'closed' => 'Закрыта'
                    } ?>
                </span>
            </div>
            
            <div class="ticket-meta">
                <span><i class="fas fa-user"></i> <?= htmlspecialchars($ticket['username']) ?></span>
                <span><i class="fas fa-calendar-alt"></i> <?= date('d.m.Y H:i', strtotime($ticket['created_at'])) ?></span>
            </div>
            
            <div class="ticket-description">
                <h2>Описание проблемы:</h2>
                <p><?= nl2br(htmlspecialchars($ticket['description'])) ?></p>
            </div>
            
            <?php if (mysqli_num_rows($attachments_result) > 0): ?>
                <div class="ticket-attachments">
                    <h2>Прикрепленные файлы:</h2>
                    <div class="attachments-grid">
                        <?php while ($attachment = mysqli_fetch_assoc($attachments_result)): ?>
                            <?php 
                                $ext = strtolower(pathinfo($attachment['file_path'], PATHINFO_EXTENSION));
                                $is_image = in_array($ext, ['jpg', 'jpeg', 'png', 'gif']);
                                $is_video = in_array($ext, ['mp4', 'mov', 'avi']);
                            ?>
                            <div class="attachment-item">
                                <?php if ($is_image): ?>
                                    <a href="<?= $attachment['file_path'] ?>" target="_blank">
                                        <img src="<?= $attachment['file_path'] ?>" alt="Вложение">
                                        <span>Открыть</span>
                                    </a>
                                <?php elseif ($is_video): ?>
                                    <video controls>
                                        <source src="<?= $attachment['file_path'] ?>" type="video/<?= $ext ?>">
                                    </video>
                                <?php else: ?>
                                    <a href="<?= $attachment['file_path'] ?>" download>
                                        <i class="fas fa-file-download"></i>
                                        <span>Скачать файл</span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="ticket-comments">
                <h2>Комментарии:</h2>
                
                <div class="comments-list">
                    <?php if (mysqli_num_rows($comments_result) > 0): ?>
                        <?php while ($comment = mysqli_fetch_assoc($comments_result)): ?>
                            <div class="comment-item <?= $comment['user_id'] == $user_id ? 'user-comment' : 'support-comment' ?>">
                                <div class="comment-header">
                                    <strong><?= htmlspecialchars($comment['username']) ?></strong>
                                    <span><?= date('d.m.Y H:i', strtotime($comment['created_at'])) ?></span>
                                </div>
                                <div class="comment-body">
                                    <?= nl2br(htmlspecialchars($comment['comment'])) ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="no-comments">
                            <i class="fas fa-comment-slash"></i>
                            <p>Пока нет комментариев</p>
                        </div>
                    <?php endif; ?>
                </div>
                
                <?php if ($ticket['status'] != 'closed'): ?>
                    <form method="POST" class="comment-form">
                        <div class="form-group">
                            <label for="comment">Добавить комментарий:</label>
                            <textarea id="comment" name="comment" rows="4" placeholder="Напишите ваш вопрос или уточнение..." required></textarea>
                        </div>
                        <button type="submit" name="submit_comment" class="btn-submit">
                            <i class="fas fa-paper-plane"></i> Отправить
                        </button>
                    </form>
                <?php else: ?>
                    <div class="ticket-closed-notice">
                        <i class="fas fa-lock"></i> Заявка закрыта, новые комментарии не принимаются
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <!-- Список заявок -->
        <div class="tickets-container">
            <div class="tickets-header">
                <h1><i class="fas fa-headset"></i> Техническая поддержка</h1>
                <button class="btn-new-ticket" id="newTicketBtn"><i class="fas fa-plus"></i> Новая заявка</button>
                <a href="/logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Выйти</a>
            </div>

            <?php if (isset($ticket_error)): ?>
                <div class="alert alert-error"><?= $ticket_error ?></div>
            <?php endif; ?>
            
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> Ваша заявка успешно создана!
                </div>
            <?php endif; ?>
            
            <div class="tickets-content">
                <?php if (mysqli_num_rows($tickets_result) > 0): ?>
                    <div class="tickets-list">
                        <table class="tickets-table">
                            <thead>
                                <tr>
                                    <th>№</th>
                                    <th>Тема</th>
                                    <th>Статус</th>
                                    <th>Дата создания</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($ticket = mysqli_fetch_assoc($tickets_result)): ?>
                                    <tr>
                                        <td>#<?= $ticket['id'] ?></td>
                                        <td><?= htmlspecialchars($ticket['title']) ?></td>
                                        <td>
                                            <span class="status-badge status-<?= $ticket['status'] ?>">
                                                <?= match($ticket['status']) {
                                                    'open' => 'Открыта',
                                                    'in_progress' => 'В работе',
                                                    'closed' => 'Закрыта'
                                                } ?>
                                            </span>
                                        </td>
                                        <td><?= date('d.m.Y H:i', strtotime($ticket['created_at'])) ?></td>
                                        <td>
                                            <a href="?id=<?= $ticket['id'] ?>" class="btn-view">
                                                <i class="fas fa-eye"></i> Подробнее
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="no-tickets">
                        <i class="fas fa-inbox"></i>
                        <p>У вас пока нет созданных заявок</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Модальное окно новой заявки -->
        <div id="newTicketModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Новая заявка в поддержку</h2>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Тема заявки *</label>
                        <input type="text" id="title" name="title" placeholder="Кратко опишите проблему" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Подробное описание *</label>
                        <textarea id="description" name="description" rows="6" 
                                  placeholder="Опишите проблему как можно подробнее, включая шаги воспроизведения" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="attachments">Прикрепить файлы</label>
                        <div class="file-upload">
                            <label class="file-upload-label">
                                <input type="file" id="attachments" name="attachments[]" multiple>
                                <span><i class="fas fa-paperclip"></i> Выберите файлы</span>
                            </label>
                            <div id="fileList" class="file-list"></div>
                        </div>
                        <small>Можно прикрепить изображения (JPG, PNG), документы (PDF, DOC) или видео (MP4). Макс. размер: 10MB</small>
                    </div>
                    <div class="form-footer">
                        <button type="submit" name="submit_ticket" class="btn-submit">
                            <i class="fas fa-paper-plane"></i> Отправить заявку
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (!$is_ticket_details): ?>
            // Модальное окно новой заявки
            const modal = document.getElementById('newTicketModal');
            const btn = document.getElementById('newTicketBtn');
            const span = document.getElementsByClassName('close')[0];
            
            if (btn) {
                btn.onclick = function() {
                    modal.style.display = 'block';
                    document.body.style.overflow = 'hidden';
                }
            }
            
            span.onclick = function() {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
            
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            }
            
            // Отображение выбранных файлов
            const fileInput = document.getElementById('attachments');
            const fileList = document.getElementById('fileList');
            
            if (fileInput && fileList) {
                fileInput.addEventListener('change', function() {
                    fileList.innerHTML = '';
                    
                    if (this.files.length > 0) {
                        for (let i = 0; i < this.files.length; i++) {
                            const file = this.files[i];
                            const fileItem = document.createElement('div');
                            
                            // Определяем иконку в зависимости от типа файла
                            let iconClass = 'fa-file';
                            if (file.type.match('image.*')) {
                                iconClass = 'fa-file-image';
                            } else if (file.type.match('video.*')) {
                                iconClass = 'fa-file-video';
                            } else if (file.type.match('application/pdf')) {
                                iconClass = 'fa-file-pdf';
                            } else if (file.type.match('application/msword') || 
                                       file.type.match('application/vnd.openxmlformats-officedocument.wordprocessingml.document')) {
                                iconClass = 'fa-file-word';
                            }
                            
                            fileItem.innerHTML = `
                                <i class="fas ${iconClass}"></i>
                                ${file.name} (${formatFileSize(file.size)})
                            `;
                            fileList.appendChild(fileItem);
                        }
                    }
                });
            }
        <?php endif; ?>
        
        // Форматирование размера файла
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    });
    </script>
</body>
</html>