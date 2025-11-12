<?php
/**
 * Site Settings Loader
 *
 * Loads dynamic site configuration (name, description, etc.) from the `settings` table.
 * Provides safe fallbacks if table is not yet installed.
 */

if (!defined('CMS_LOADED')) {
    exit('Direct access not allowed.');
}

/**
 * Get site settings from database with fallback defaults
 *
 * @return array Associative array of site settings
 */
function get_site_settings(): array
{
    static $settings = null;

    if ($settings === null) {
        try {
            $result = DB::query("SELECT * FROM settings WHERE id = 1 LIMIT 1");
            if (!empty($result)) {
                $settings = $result[0];
            } else {
                // Fallback if row doesn't exist (should not happen after install)
                $settings = [
                    'site_name'        => 'SimpleCMS',
                    'site_description' => 'A lightweight and secure CMS.',
                    'default_lang'     => 'fa',
                    'timezone'         => 'Asia/Tehran',
                    'admin_email'      => 'admin@example.com',
                ];
            }
        } catch (Throwable $e) {
            // Fallback if table doesn't exist (e.g., before setup)
            $settings = [
                'site_name'        => 'SimpleCMS',
                'site_description' => 'A lightweight and secure CMS.',
                'default_lang'     => 'fa',
                'timezone'         => 'Asia/Tehran',
                'admin_email'      => 'admin@example.com',
            ];
        }

        // Ensure timezone is valid
        if (!empty($settings['timezone'])) {
            date_default_timezone_set($settings['timezone']);
        }
    }

    return $settings;
}