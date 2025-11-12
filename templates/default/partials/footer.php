<?php
require_once __DIR__ . '/../../../config/cms.php';
require_once __DIR__ . '/../../../core/settings.php';

$settings = get_site_settings();
?>

<footer class="text-center py-4 mt-auto">
    <div class="container">
        <p>&copy; <?= date('Y') . ' ' . htmlspecialchars($settings['site_name']) ?> . All rights reserved.</p>
        <p class="mb-0">
            <a href="#" class="text-warning">Designed with <?= CMS_NAME ?></a>
        </p>
    </div>
</footer>