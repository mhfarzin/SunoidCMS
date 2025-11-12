<?php
/**
 * Bootstrap & Setup Guard
 *
 * This file initializes the CMS environment and redirects to setup
 * if the database is not ready. It ensures only one entry point is used.
 */

// Prevent double inclusion (optional but safe)
if (defined('CMS_LOADED')) {
    return;
}

// Security & environment constants
define('CMS_LOADED', true);
define('__ROOT__', __DIR__); // Points to project root (where this file is)
define('DEBUG', true);       // Set to false in production!

// Load core dependencies
require_once __DIR__ . '/core/db.php';

try {
    // Check if required table exists
    $tables = DB::query("SHOW TABLES LIKE 'settings'");
    if (empty($tables)) {
        header('Location: /setup.php', true, 302);
        exit;
    }
} catch (Throwable $e) {
    // If DB connection fails, go to setup
    header('Location: /setup.php', true, 302);
    exit;
}

// Hand over to the real public entry point
require_once __DIR__ . '/public/index.php';