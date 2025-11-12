<?php
/**
 * Database Configuration
 *
 * This file contains the database connection settings.
 * Ensure that this file is stored outside the web root directory in production,
 * or that direct access to the /config/ directory is blocked via .htaccess or server config.
 */

// Prevent direct access to this file
if (!defined('CMS_LOADED')) {
    exit('Direct access not allowed.');
}

// Database connection constants
define('DB_HOST', 'db:3306');       // Database server host
define('DB_NAME', 'cmsdb');      // Database name
define('DB_USER', 'sa');            // Database username
define('DB_PASS', 'Aa@12345');      // Database password (empty by default for local dev)