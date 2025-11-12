<?php
require_once __DIR__ . '/../../core/DB.php';
require_once __DIR__ . '/../../core/functions.php';
$current_page = 'pages-list';
$title = lang('pages.list_title');
ob_start();
?>

<div>
    Hello
    <?php
    for($index = 1; $index<100; $index++)
    {
        echo "<br />";
    }
    ?>
</div>

<script>
  
</script>

<?php
$page_content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>