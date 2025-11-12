<?php

/**
 * Dump and die - for debugging
 *
 * @param mixed ...$vars Variables to output
 * @return void
 */
function dd(...$vars): void
{
    echo '<pre style="background: #f4f4f4; padding: 10px; border: 1px solid #ccc; font-family: monospace; direction: ltr;">';
    foreach ($vars as $var) {
        print_r($var);
        echo "\n\n";
    }
    echo '</pre>';
    die(1);
}

/**
 * Generate versioned URL for theme assets
 *
 * Constructs a full URL to an asset file inside the current theme's assets directory.
 * Appends a cache-busting query string (?v=timestamp) if the file exists on disk.
 *
 * @param string $path Relative path to the asset (e.g., 'css/style.css' or 'js/app.js')
 * @return string Full URL (e.g., '/templates/default/assets/css/style.css?v=1712345678')
 */
function asset(string $path): string
{
    $theme = 'default';
    $path = ltrim($path, '/');

    $url = "/templates/{$theme}/assets/{$path}";
    $fullPath = __ROOT__ . "/templates/{$theme}/assets/{$path}";

    // Only add version if file exists to avoid broken URLs
    if (file_exists($fullPath)) {
        $url .= '?v=' . filemtime($fullPath);
    }

    return $url;
}

/**
 * Load language file and return translations array
 *
 * @param string $lang Language code (e.g., 'en', 'fa')
 * @return array Associative array of translations
 */
function load_lang(string $lang = 'en'): array
{
    static $loaded = [];
    
    if (isset($loaded[$lang])) {
        return $loaded[$lang];
    }
    
    $langFile = __ROOT__ . "/lang/{$lang}.php";
    
    if (file_exists($langFile)) {
        $translations = require $langFile;
        $loaded[$lang] = is_array($translations) ? $translations : [];
    } else {
        // Fallback to English if language file doesn't exist
        if ($lang !== 'en') {
            return load_lang('en');
        }
        $loaded[$lang] = [];
    }
    
    return $loaded[$lang];
}

/**
 * Get translation string
 *
 * @param string $key Translation key (e.g., 'login.title')
 * @param string $default Default value if key not found
 * @param string $lang Language code
 * @return string Translated string
 */
function lang(string $key, string $default = '', string $lang = 'en'): string
{
    $translations = load_lang($lang);
    
    // Support dot notation (e.g., 'login.title' -> $translations['login']['title'])
    $keys = explode('.', $key);
    $value = $translations;
    
    foreach ($keys as $k) {
        if (isset($value[$k])) {
            $value = $value[$k];
        } else {
            return $default !== '' ? $default : $key;
        }
    }
    
    return is_string($value) ? $value : ($default !== '' ? $default : $key);
}