<?php
require_once __DIR__ . '/../includes/admin_header.php';

// Получение списка страниц
$pages = $pdo->query("SELECT DISTINCT page FROM content")->fetchAll(PDO::FETCH_COLUMN);

// Фильтрация по странице
$current_page = $_GET['page'] ?? $pages[0] ?? '';
$sections = [];
$content_items = [];

if ($current_page) {
    // Получение секций для выбранной страницы
    $stmt = $pdo->prepare("SELECT DISTINCT section FROM content WHERE page = ?");
    $stmt->execute([$current_page]);
    $sections = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Получение контента
    $stmt = $pdo->prepare("SELECT * FROM content WHERE page = ? ORDER BY section, content_key");
    $stmt->execute([$current_page]);
    $content_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Обработка формы редактирования
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content_id'])) {
    $content_id = $_POST['content_id'];
    $content_value = $_POST['content_value'];
    
    $stmt = $pdo->prepare("UPDATE content SET content_value = ?, updated_by = ?, updated_at = NOW() WHERE id = ?");
    $stmt->execute([$content_value, $_SESSION['user_id'], $content_id]);
    
    // Логирование действия
    $log_stmt = $pdo->prepare("INSERT INTO activity_log (user_id, action, details) VALUES (?, ?, ?)");
    $log_stmt->execute([
        $_SESSION['user_id'],
        'content_update',
        "Updated content item ID: $content_id"
    ]);
    
    header("Location: edit_content.php?page=$current_page&updated=1");
    exit;
}
?>

<h1>Редактирование контента</h1>

<form method="get" class="filter-form">
    <label for="page">Страница:</label>
    <select name="page" id="page" onchange="this.form.submit()">
        <?php foreach ($pages as $page): ?>
        <option value="<?= htmlspecialchars($page) ?>" <?= $page === $current_page ? 'selected' : '' ?>>
            <?= htmlspecialchars($page) ?>
        </option>
        <?php endforeach; ?>
    </select>
</form>

<?php if ($current_page && !empty($content_items)): ?>
<div class="content-editor">
    <?php foreach ($content_items as $item): ?>
    <form method="post" class="content-item-form">
        <input type="hidden" name="content_id" value="<?= $item['id'] ?>">
        
        <div class="form-group">
            <label for="key_<?= $item['id'] ?>">Ключ:</label>
            <input type="text" id="key_<?= $item['id'] ?>" value="<?= htmlspecialchars("{$item['section']}.{$item['content_key']}") ?>" readonly>
        </div>
        
        <div class="form-group">
            <label for="value_<?= $item['id'] ?>">Значение:</label>
            <?php if ($item['is_html']): ?>
            <textarea id="value_<?= $item['id'] ?>" name="content_value" rows="6"><?= htmlspecialchars($item['content_value']) ?></textarea>
            <?php else: ?>
            <input type="text" id="value_<?= $item['id'] ?>" name="content_value" value="<?= htmlspecialchars($item['content_value']) ?>">
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn-save">Сохранить</button>
        </div>
    </form>
    <?php endforeach; ?>
</div>
<?php else: ?>
<p>Контент не найден для выбранной страницы.</p>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>