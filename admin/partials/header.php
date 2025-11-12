<?php
require_once __DIR__ . '/../../config/cms.php';
if (!function_exists('lang')) {
    require_once __DIR__ . '/../../core/functions.php';
}
?>

<header class="navbar navbar-dark sticky-top d-flex px-3 py-0 shadow">
    <button class="btn btn-success position-fixed top-0 start-0 m-3 d-md-none shadow-lg"
        type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#mobile-sidebar"
        aria-controls="mobile-sidebar"
        style="z-index: 1050;">
        <i class="bi bi-list fs-4"></i>
    </button>

    <div class="sidebar-header d-flex justify-content-between align-items-center">
        <a href="/admin/index.php" class="navbar-brand text-white">
            <h5 class="fs-2 mb-0"><i class="bi bi-bootstrap fs-1 me-2"></i><?= CMS_NAME ?></h5>
        </a>
    </div>

    <a class="navbar-brand px-3 fs-6" href="/admin">
        <span class="badge bg-warning text-dark"><?= lang('header.admin') ?></span>
    </a>
</header>
