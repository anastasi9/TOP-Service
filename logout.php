<?php
// C:\Program Files\Ampps\www\logout.php
session_start();
session_unset();
session_destroy();

header("Location: /index.php"); // Перенаправляем на страницу входа
exit();
?>