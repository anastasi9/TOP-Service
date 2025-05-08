<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/okdesk_api.php';

// Для отладки
echo "<pre>Session email: " . htmlspecialchars($_SESSION['m.baryshnikov@it-horeca.ru']) . "</pre>";

$okdesk = new OKdeskIntegration();
$response = $okdesk->getIssues([
    'contact_email' => $_SESSION['m.baryshnikov@it-horeca.ru'],
    'limit' => 50 // Ограничение на кол-во заявок
]);

// Отладка ответа API
echo "<pre>API Response: " . print_r($response, true) . "</pre>";

if (!empty($response['data'])) {
    echo '<h2>Мои заявки</h2>';
    echo '<table border="1">';
    echo '<tr><th>ID</th><th>Тема</th><th>Статус</th><th>Дата</th></tr>';
    
    foreach ($response['data'] as $issue) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($issue['id'] ?? 'N/A') . '</td>';
        echo '<td>' . htmlspecialchars($issue['subject'] ?? 'Без темы') . '</td>';
        echo '<td>' . htmlspecialchars($issue['status']['name'] ?? 'Неизвестно') . '</td>';
        echo '<td>' . date('d.m.Y', strtotime($issue['created_at'] ?? 'now')) . '</td>';
        echo '</tr>';
    }
    
    echo '</table>';
} else {
    echo '<p>У вас нет активных заявок.</p>';
}
?>