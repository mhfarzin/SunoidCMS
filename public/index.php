<?php
/**
 * Public Entry Point
 *
 * This is the main front controller. All web requests go through this file.
 * It initializes the router and defines public routes.
 */

// Ensure CMS is loaded through the correct bootstrap
if (!defined('CMS_LOADED')) {
    exit('Direct access not allowed.');
}

require_once __DIR__ . '/../core/router.php';
require_once __DIR__ . '/../core/template.php';
require_once __DIR__ . '/../core/functions.php';

$router = new Router();

// Public routes (admin & setup are included directly for simplicity)
$router->add('admin', function () {
    require_once __DIR__ . '/../admin/index.php';
});

$router->add('admin/add_page', function () {
    require_once __DIR__ . '/../admin/add_page.php';
});

$router->add('setup', function () {
    require_once __DIR__ . '/../setup.php';
});

// Dispatch current request
$router->dispatch($_SERVER['REQUEST_URI']);