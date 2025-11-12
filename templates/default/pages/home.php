<?php
ob_start();
?>

<?php include __DIR__ . '/../partials/post.php'; ?>

<?php
$page_content = ob_get_clean();
require_once __DIR__ . '/../layouts/default.php';
?>