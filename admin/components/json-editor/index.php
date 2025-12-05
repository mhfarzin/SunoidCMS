<?php
if (!defined('CMS_LOADED')) exit('Direct access not allowed.');

if (!isset($GLOBALS['admin_json_editor_printed'])) {
    $GLOBALS['admin_json_editor_printed'] = false;
}

function admin_json_editor(string $name, string $value = ''): void
{
    if (!$GLOBALS['admin_json_editor_printed']) {
        echo '
            <link rel="stylesheet" href="/admin/assets/vendor/jsonedtr/JSONedtr.css">
            <script src="/admin/assets/vendor/jsonedtr/JSONedtr.js"></script>
            <link rel="stylesheet" href="/admin/components/json-editor/style.css">
            <script src="/admin/components/json-editor/script.js"></script>
        ';
        $GLOBALS['admin_json_editor_printed'] = true;
    }

    $jsonValue = json_decode($value, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        $jsonValue = [];
    }
    $jsonString = json_encode($jsonValue);

    $id = 'json-editor-' . uniqid();
    
    echo '<div class="json-editor-container">';
    echo '<input type="hidden" name="' . htmlspecialchars($name) . '" id="' . $id . '-input" value="' . htmlspecialchars($value) . '">';
    echo '<div id="' . $id . '" class="json-editor-element" data-input-id="' . $id . '-input" data-json="' . htmlspecialchars($jsonString) . '"></div>';
    echo '</div>';
}
?>