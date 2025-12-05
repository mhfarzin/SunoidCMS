<?php
if (!function_exists('lang')) {
    require_once __DIR__ . '/../../core/functions.php';
}
$current_page = $_SERVER['SCRIPT_NAME'];
?>

<ul class="menu-nav nav nav-pills flex-column mb-auto">

    <li class="nav-item mb-1">
        <a href="/admin/index.php" class="nav-link text-white <?= ($current_page == '/admin/index.php') ? 'active' : '' ?>">
            <i class="bi bi-house pe-2"></i>
            <span class="menu-text"><?= lang('sidebar.dashboard') ?></span>
        </a>
    </li>

    <li class="nav-item mb-1">
        <a href="#" class="nav-link text-white" data-bs-toggle="collapse" data-bs-target="#pages-sub-menu">
            <i class="bi bi-file-earmark-text pe-2"></i>
            <span class="menu-text"><?= lang('sidebar.pages') ?></span>
            <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <div class="collapse sub-menu" id="pages-sub-menu">
            <ul class="nav nav-pills flex-column ms-4">
                <li class="nav-item mb-1">
                    <a href="/admin/pages/list.php" class="nav-link text-white <?= ($current_page == '/admin/pages/list.php') ? 'active' : '' ?>">
                        <i class="bi bi-list-ul pe-2"></i> <?= lang('sidebar.all_pages') ?>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="/admin/pages/manage.php" class="nav-link text-white <?= ($current_page == '/admin/pages/manage.php') ? 'active' : '' ?>">
                        <i class="bi bi-plus-circle pe-2"></i> <?= lang('sidebar.create_page') ?>
                    </a>
                </li>
            </ul>
        </div>
    </li>

    <li class="nav-item mb-1">
        <a href="/admin/settings.php" class="nav-link text-white <?= ($current_page == '/admin/settings.php') ? 'active' : '' ?>">
            <i class="bi bi-gear pe-2"></i>
            <span class="menu-text"><?= lang('sidebar.settings') ?></span>
        </a>
    </li>

    <li class="nav-item mb-1">
        <a href="/admin/logout.php" class="nav-link">
            <i class="bi bi-box-arrow-right pe-2"></i>
            <span class="menu-text"><?= lang('sidebar.logout') ?></span>
        </a>
    </li>
</ul>

<hr>

<div class="d-flex align-items-center">
    <i class="bi bi-person-circle fs-1 me-3"></i>
    <div>
        <h6 class="mt-1 mb-0 text-white"><?= lang('sidebar.admin') ?></h6>
        <small><?= lang('sidebar.admin_email') ?></small>
    </div>
</div>
