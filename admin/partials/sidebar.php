<?
require_once __DIR__ . '/../../config/cms.php';
?>

<!-- Desktop Sidebar -->
<nav id="main-sidebar" class="col-md-3 col-lg-2 d-none d-md-flex flex-column flex-shrink-0 p-3 bg-success text-white">
    <?php include 'sidebar-content.php'; ?>
</nav>

<!-- Mobile Sidebar (Offcanvas) -->
<div class="offcanvas offcanvas-start bg-success text-white" tabindex="-1" id="mobile-sidebar" aria-labelledby="sidebarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title text-white" id="sidebarLabel">
            <i class="bi bi-bootstrap fs-1 me-2"></i><?= CMS_NAME ?>
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body p-3">
        <?php include 'sidebar-content.php'; ?>
    </div>
</div>
