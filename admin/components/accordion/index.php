<?php
if (!defined('CMS_LOADED')) exit('Direct access not allowed.');

if (!isset($GLOBALS['admin_accordion_printed'])) {
    $GLOBALS['admin_accordion_printed'] = false;
}

function admin_accordion(): void
{
    if ($GLOBALS['admin_accordion_printed']) return;

    echo '
        <link rel="stylesheet" href="/admin/components/accordion/style.css">
        <script src="/admin/components/accordion/script.js"></script>
    ';

    $GLOBALS['admin_accordion_printed'] = true;
}