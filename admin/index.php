<?php
/**
 * Admin Front Controller
 *
 * Automatically loads view files based on the request path.
 * Example: /admin/pages/list → loads admin/views/pages/list.php
 * Special routes: /admin/login, /admin/logout
 */

if (!defined('CMS_LOADED')) {
    define('CMS_LOADED', true);
    define('__ROOT__', __DIR__ . '/..');
    define('DEBUG', true); // Set to false in production

    require_once __DIR__ . '/../core/db.php';
    require_once __DIR__ . '/../core/functions.php';
}

// Get and sanitize the path after /admin/
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$adminPath = parse_url($requestUri, PHP_URL_PATH);

if (strpos($adminPath, '/admin') === 0) {
    $relativePath = substr($adminPath, 6); // Remove "/admin"
} else {
    $relativePath = $adminPath;
}

$relativePath = trim($relativePath, '/');

// Default route
if ($relativePath === '') {
    $relativePath = 'dashboard';
}

// Handle special routes
if ($relativePath === 'login') {
    // Login logic
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['password'])) {
        if ($_POST['password'] === 'admin') { // ⚠️ Replace with proper auth later
            $_SESSION['admin_logged_in'] = true;
            header('Location: /admin');
            exit;
        }
    }

    // Show login form
    $viewFile = __DIR__ . '/views/login.php';
    if (file_exists($viewFile)) {
        include $viewFile;
    } else {
        echo '<h2>Login view not found</h2>';
    }
    exit;
}

if ($relativePath === 'logout') {
    session_start();
    unset($_SESSION['admin_logged_in']);
    session_destroy();
    header('Location: /admin/login');
    exit;
}

// === Authentication check ===
session_start();
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: /admin/login');
    exit;
}

// === Auto-load view based on path ===
if (!str_ends_with($relativePath, '.php')) {
    $relativePath .= '.php';
}

// Security: block dangerous patterns
if (preg_match('#(\.\./|://|\\\\)#', $relativePath)) {
    http_response_code(403);
    exit('Forbidden');
}

if (!preg_match('#^[a-zA-Z0-9/_-]+\.php$#', $relativePath)) {
    http_response_code(400);
    exit('Invalid path');
}

$viewFile = __DIR__ . '/views/' . $relativePath;

if (!file_exists($viewFile)) {
    http_response_code(404);
    echo "<h2>Admin page not found: " . htmlspecialchars(basename($relativePath)) . "</h2>";
    exit;
}

// Render the view
include $viewFile;