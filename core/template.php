<?php
/**
 * Template Rendering Engine
 *
 * Handles loading and rendering of theme-based page templates.
 * Sanitizes input to prevent directory traversal and ensures theme/template validity.
 */

// Prevent direct access
if (!defined('CMS_LOADED')) {
    exit('Direct access not allowed.');
}

class Template
{
    private string $theme = 'default';
    private string $basePath;

    public function __construct()
    {
        $this->basePath = __DIR__ . '/../templates';
    }

    /**
     * Set active theme (only if it exists and name is safe)
     *
     * @param string $theme Theme directory name
     * @return void
     */
    public function setTheme(string $theme): void
    {
        // Allow only safe characters (prevent directory traversal / code injection)
        $theme = preg_replace('/[^a-zA-Z0-9_-]/', '', $theme);
        if ($theme !== '' && is_dir($this->basePath . '/' . $theme)) {
            $this->theme = $theme;
        }
    }

    /**
     * Render a template with provided data
     *
     * @param string $templateName Template file name (without .php)
     * @param array  $data         Data to pass into the template
     * @return void
     */
    public function render(string $templateName, array $data = []): void
    {
        if (empty($templateName) || $templateName === 'raw') {
            echo $data['content'] ?? '';
            return;
        }

        // Sanitize template name
        $templateName = preg_replace('/[^a-zA-Z0-9_-]/', '', $templateName);
        if ($templateName === '') {
            http_response_code(500);
            echo 'Invalid template name.';
            return;
        }

        $pageFile = $this->basePath . '/' . $this->theme . '/pages/' . $templateName . '.php';

        if (!file_exists($pageFile)) {
            http_response_code(500);
            if (defined('DEBUG') && DEBUG) {
                echo "Template not found: {$this->theme}/pages/{$templateName}.php";
            } else {
                echo 'Template error.';
            }
            return;
        }

        // Extract variables into local scope (skip if name conflicts)
        extract($data, EXTR_SKIP);

        // Include template safely
        include $pageFile;
    }

    /**
     * Get full filesystem path to the current theme
     *
     * @return string Absolute path to theme directory
     */
    public function getThemePath(): string
    {
        return $this->basePath . '/' . $this->theme;
    }
}