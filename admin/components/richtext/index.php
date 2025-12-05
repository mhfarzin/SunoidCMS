<?php
if (!defined('CMS_LOADED')) exit('Direct access not allowed.');

if (!isset($GLOBALS['admin_richtext_printed'])) {
    $GLOBALS['admin_richtext_printed'] = false;
}

function admin_richtext(string $name, string $value = '', array $options = []): void
{
    if (!$GLOBALS['admin_richtext_printed']) {
        echo '
            <link rel="stylesheet" href="/admin/assets/vendor/summernote/summernote-bs5.min.css">
            <script src="/admin/assets/vendor/summernote/summernote-bs5.min.js"></script>
            <link rel="stylesheet" href="/admin/components/richtext/style.css">
            <script src="/admin/components/richtext/script.js"></script>
        ';
        $GLOBALS['admin_richtext_printed'] = true;
    }

    $id = 'richtext-' . uniqid();
    
    echo '<div class="richtext-container mb-4">';
    echo '<textarea name="' . htmlspecialchars($name) . '" id="' . $id . '" class="richtext-textarea">' . $value . '</textarea>';
    echo '</div>';
}
?>