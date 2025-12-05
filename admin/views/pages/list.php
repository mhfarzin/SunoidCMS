<?php
require_once __DIR__ . '../../../../core/db.php';
require_once __DIR__ . '../../../../core/functions.php';
require_once __DIR__ . '../../../components/table/index.php';
$current_page = 'pages-list';
$title = lang('pages.list_title');
ob_start();
?>

<div>
    <?php
    admin_table(
        table: 'pages',
        columns: ['title', 'slug', 'created_at'],
        labels: ['Title', 'Slug', 'Date'],
        actions: [
        [
            'label' => 'Edit',
            'class' => 'btn-primary',
            'icon' => '<i class="bi bi-pencil"></i>',
            'action' => fn($r) => "window.location.href='manage.php?id={$r['id']}'"
        ],
        [
            'label' => 'Delete',
            'class' => 'btn-outline-danger',
            'icon' => '<i class="bi bi-trash"></i>',
            'action' => fn($r) => "window.location.href='delete.php?id={$r['id']}'"
        ]
    ]
    );
    ?>
</div>

<script>

</script>

<?php
$page_content = ob_get_clean();
require_once __DIR__ . '../../../layouts/main.php';
?>