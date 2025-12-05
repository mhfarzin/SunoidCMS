<?php
require_once __DIR__ . '../../../../core/db.php';
require_once __DIR__ . '../../../../core/functions.php';
require_once __DIR__ . '../../../components/form/index.php';
require_once __DIR__ . '../../../components/accordion/index.php';
require_once __DIR__ . '../../../components/richtext/index.php';
require_once __DIR__ . '../../../components/json-editor/index.php';

$current_page = 'manage-list';

$page_id = $_GET['id'] ?? null;
$is_edit = $page_id !== null;

if ($is_edit && !ctype_digit((string)$page_id)) {
    die('Invalid page ID.');
}

if ($is_edit) {
    $page = DB::query("SELECT * FROM pages WHERE id = ?", [$page_id]);
    if (empty($page)) {
        die('Page not found.');
    }
    $page = $page[0];
    $title = lang('pages.edit_title');;
} else {
    $page = [
        'title' => '',
        'slug' => '',
        'content' => '',
        'template' => 'raw',
        'is_published' => 1,
        'meta_title' => '',
        'meta_description' => ''
    ];
    $title = lang('pages.create_title');;
}

$errors = [];
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf()) {
        die('Invalid CSRF token.');
    }

    $title            = trim($_POST['title'] ?? '');
    $slug             = trim($_POST['slug'] ?? '');
    $is_published     = !empty($_POST['is_published']) ? 1 : 0;
    $template         = $_POST['template'] ?? 'raw';
    $content          = $_POST['content'] ?? '';
    $options          = $_POST['options'] ?? [];
    $meta_title       = trim($_POST['meta_title'] ?? '');
    $meta_description = trim($_POST['meta_description'] ?? '');

    // Validation
    if (empty($title)) {
        $errors['title'] = 'Title is required.';
    }

    // Auto generate slug if empty
    if (empty($slug)) {
        $slug = preg_replace('/[^a-z0-9]+/', '-', strtolower($title));
        $slug = trim($slug, '-');
    }

    // Sanitize slug - only lowercase letters, numbers, hyphens
    $slug = preg_replace('/[^a-z0-9\-]/', '-', strtolower($slug));
    $slug = trim($slug, '-');
    if (empty($slug)) {
        $slug = 'page';
    }

    // Check slug uniqueness
    $existing = DB::query(
        "SELECT id FROM pages WHERE slug = ? AND id != ?",
        [$slug, $is_edit ? $page_id : 0]
    );

    if (!empty($existing)) {
        $errors['slug'] = 'This slug is already in use.';
    }

    if (empty($errors)) {
        $data = [
            'title'             => $title,
            'slug'              => $slug,
            'template'          => $template,
            'content'           => $content,
            'options'           => $options,
            'is_published'      => $is_published,
            'meta_title'        => $meta_title,
            'meta_description'  => $meta_description,
        ];

        try {
            if ($is_edit) {
                $data['updated_at'] = date('Y-m-d H:i:s');
                DB::update('pages', $data, 'id = ?', [$page_id]);
                $success_message = 'Page updated successfully.';
            } else {
                $data['created_at'] = date('Y-m-d H:i:s');
                DB::insert('pages', $data);
                $success_message = 'Page created successfully.';
            }

            header('Location: list.php?success=1');
            exit;
        } catch (Exception $e) {
            $errors['general'] = 'Database error. Please try again.';
        }
    }

    $page = array_merge($page, $data);
}

ob_start();
?>

<?php if (!empty($success_message) && empty($errors)): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= htmlspecialchars($success_message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (!empty($errors['general'])): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($errors['general']) ?>
    </div>
<?php endif; ?>

<? admin_accordion() ?>

<div class="form">
    <form method="post">
        <?= csrf_field() ?>
        <?= hidden('id', $page_id) ?>

        <?= text('title', 'Page Title', $page['title'] ?? '', $errors['title'] ?? null, ['required' => true]) ?>

        <?= text('slug', 'Page Slug (URL)', $page['slug'] ?? '', $errors['slug'] ?? null, [
            'class' => 'form-control font-monospace',
            'placeholder' => 'leave-empty-to-auto-generate'
        ]) ?>
        <small class="text-muted d-block mb-3">
            Only lowercase letters, numbers and hyphens allowed.
        </small>

        <?= checkbox('is_published', 'Publish this page', !empty($page['is_published'])) ?>

        <?= text('template', 'Template', $page['template']) ?>

        <?= admin_richtext('content', $page['content'] ?? ''); ?>

        <div class="admin-accordion-item mb-3">
            <div class="admin-accordion-button">Options</div>
            <div class="admin-accordion-body show">
                <?= admin_json_editor('options', $page['options'] ?? ''); ?>
            </div>
        </div>

        <div class="admin-accordion-item mb-3">
            <div class="admin-accordion-button">SEO</div>
            <div class="admin-accordion-body">
                <?= text('meta_title', 'Meta Title (SEO)', $page['meta_title'] ?? '') ?>

                <?= textarea('meta_description', 'Meta Description (SEO)', $page['meta_description'] ?? '', null, ['rows' => 3]) ?>
            </div>
        </div>

        <button type="submit">Submit</button>
    </form>
</div>

<?php
$page_content = ob_get_clean();
require_once __DIR__ . '../../../layouts/main.php';
?>