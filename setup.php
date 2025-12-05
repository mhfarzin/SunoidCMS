<?php
/**
 * CMS Installation Script
 *
 * Creates the initial database structure and sample content.
 * Automatically locks after first run to prevent re-installation.
 */

// Allow direct access to setup (it's meant to be public)
// But still protect against execution after lock

$lockFile = __DIR__ . '/installed.lock';
if (file_exists($lockFile)) {
    http_response_code(403);
    die('Installation already completed. Remove "installed.lock" to reset (not recommended on production).');
}

define('CMS_LOADED', true);

// Load DB class
require_once __DIR__ . '/core/db.php';

try {
    // Check if 'pages' table already exists
    $tables = DB::query("SHOW TABLES LIKE 'pages'");
    if (!empty($tables)) {
        echo "<p style='font-family: Tahoma; direction: rtl; text-align: center;'>";
        echo "Database is already set up.<br><br>";
        echo "<a href='/'>Home</a> | <a href='/admin'>Admin Panel</a>";
        echo "</p>";
        exit;
    }

    // =============== Create `settings` table ===============
    DB::query("
        CREATE TABLE settings (
            id TINYINT PRIMARY KEY DEFAULT 1,
            site_name VARCHAR(255) DEFAULT 'SimpleCMS',
            site_description VARCHAR(500) DEFAULT 'A lightweight and secure CMS built with PHP.',
            default_lang CHAR(2) DEFAULT 'fa',
            timezone VARCHAR(50) DEFAULT 'Asia/Tehran',
            admin_email VARCHAR(100) DEFAULT 'admin@example.com',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");

    // =============== Create `pages` table ===============
    DB::query("
        CREATE TABLE pages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL UNIQUE,
            template VARCHAR(100) DEFAULT NULL,
            content TEXT,
            options JSON DEFAULT NULL,
            is_published TINYINT(1) NOT NULL DEFAULT 1,
            meta_title VARCHAR(255),
            meta_description TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");

    // =============== Insert default settings ===============
    DB::query("
        INSERT INTO settings (id, site_name, site_description, default_lang, timezone, admin_email)
        VALUES (1, 'SimpleCMS', 'Welcome to your new website!', 'fa', 'Asia/Tehran', 'admin@example.com')
        ON DUPLICATE KEY UPDATE id = 1
    ");

    // =============== Insert default home page ===============
    DB::insert('pages', [
        'title'            => 'Home',
        'slug'             => 'home',
        'template'         => 'home',
        'content'          => '<h1>Welcome to SimpleCMS!</h1><p>Your lightweight, secure, and developer-friendly CMS is ready.</p>',
        'meta_title'       => 'Home',
        'meta_description' => 'SimpleCMS – A clean and modern content management system.',
        'options'          => json_encode([
            'background_color' => '#ffffff',
            'text_color'       => '#333333'
        ], JSON_UNESCAPED_UNICODE)
    ]);

    // =============== Optional: Insert sample "About" page ===============
    DB::insert('pages', [
        'title'            => 'About Us',
        'slug'             => 'about',
        'content'          => '<h2>About SimpleCMS</h2><p>SimpleCMS is built for developers who want a minimal, secure, and extendable foundation.</p>',
        'meta_title'       => 'About Us',
        'meta_description' => 'Learn more about SimpleCMS and its philosophy.',
        'options'          => json_encode([], JSON_UNESCAPED_UNICODE)
    ]);

    // Create lock file to prevent re-installation
    file_put_contents($lockFile, 'Installed at ' . date('Y-m-d H:i:s'));

    echo "<p style='font-family: Tahoma; direction: rtl; text-align: center;'>";
    echo "✅ Installation completed successfully!<br><br>";
    echo "<a href='/'>Home</a> | <a href='/admin'>Admin Panel</a>";
    echo "</p>";

} catch (Throwable $e) {
    http_response_code(500);
    if (defined('DEBUG') && DEBUG) {
        echo "<pre style='background:#ffe; padding:10px; border:1px solid red; font-family:monospace;'>";
        echo "Setup error: " . htmlspecialchars($e->getMessage()) . "\n\n";
        echo "Trace:\n" . htmlspecialchars($e->getTraceAsString());
        echo "</pre>";
    } else {
        echo "<p style='text-align:center; color:red;'>Installation failed. Please check database configuration.</p>";
    }
}