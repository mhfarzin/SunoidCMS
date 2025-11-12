<?php
/**
 * Router
 *
 * Handles both static route definitions and dynamic page loading from database.
 * Matches incoming URI to registered routes or falls back to database-driven pages.
 */

// Prevent direct access
if (!defined('CMS_LOADED')) {
    exit('Direct access not allowed.');
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/db.php';
require_once __DIR__ . '/../core/functions.php';
require_once __DIR__ . '/../core/template.php';

class Router
{
    private array $routes = [];

    /**
     * Register a new static route
     *
     * @param string   $path     URL path (e.g., 'about')
     * @param callable $callback Function to execute when path matches
     * @return void
     */
    public function add(string $path, callable $callback): void
    {
        $path = trim($path, '/');
        $this->routes[$path] = $callback;
    }

    /**
     * Dispatch incoming request based on URI
     *
     * @param string $uri Request URI (e.g., from $_SERVER['REQUEST_URI'])
     * @return void
     */
    public function dispatch(string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?: '';
        $uri = trim($path, '/');
        $slug = ($uri === '') ? 'home' : $uri;

        // Check static routes first
        foreach ($this->routes as $route => $callback) {
            if ($route === $uri || ($route === '' && $uri === 'home')) {
                call_user_func($callback);
                return;
            }
        }

        // Fallback to database-driven pages
        try {
            $page = DB::query("SELECT * FROM pages WHERE slug = :slug LIMIT 1", ['slug' => $slug]);
            $page = $page[0] ?? null;

            if (!$page) {
                $this->notFound($uri);
                return;
            }

            $data = [
                'title'            => $page['title'],
                'content'          => $page['content'],
                'meta_title'       => $page['meta_title'] ?? $page['title'],
                'meta_description' => $page['meta_description'] ?? '',
                'options' => $page['options'] ? json_decode($page['options'], true) : [],
                'template'         => $page['template'] ?? 'raw',
            ];

            $this->addCustomData($data, $page);
            $this->renderPage($data);
        } catch (Throwable $e) {
            $this->handleError($e);
        }
    }

    private function renderPage(array $data): void
    {
        $template = new Template();
        $template->setTheme('default');
        $templateFile = $data['template'];
        $template->render($templateFile, $data);
    }

    private function addCustomData(array &$data, array $page): void
    {
        if ($data['template'] === 'blog' && !empty($page['content'])) {
            $content = json_decode($page['content'], true);
            if (is_array($content) && isset($content['posts'])) {
                $data['posts'] = $content['posts'];
            }
        }
    }

    private function notFound(string $uri): void
    {
        http_response_code(404);
        echo "<h1>404 - Page Not Found</h1>";
        echo "<p>Requested URL: <code>/{$uri}</code></p>";
        echo "<p><a href='/'>Back to Home</a></p>";
    }

    private function handleError(Throwable $e): void
    {
        http_response_code(500);
        if (defined('DEBUG') && DEBUG && function_exists('dd')) {
            dd("Database error: " . $e->getMessage(), $e->getTraceAsString());
        } else {
            echo "An internal error occurred.";
            // Optionally log error to file in production
            // error_log("Router error: " . $e->getMessage());
        }
    }
}