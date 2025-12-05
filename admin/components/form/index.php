<?php

if (!defined('CMS_LOADED')) {
    exit('Direct access not allowed.');
}

/**
 * Text input field
 */
function text(string $name, ?string $label = null, ?string $value = '', ?string $error = null, array $options = []): string
{
    $label = $label ?? ucfirst($name);
    $required = $options['required'] ?? false;
    $class = $options['class'] ?? 'form-control';
    $value = $value ?? '';

    $html = "<div class=\"mb-3\">\n";
    $html .= "  <label class=\"form-label\">" . htmlspecialchars($label) . "</label>\n";
    $html .= "  <input type=\"text\" name=\"" . htmlspecialchars($name) . "\" value=\"" . htmlspecialchars($value) . "\" class=\"$class\"";
    if ($required) $html .= ' required';
    $html .= ">\n";
    if ($error) {
        $html .= "  <div class=\"text-danger\">" . htmlspecialchars($error) . "</div>\n";
    }
    $html .= "</div>\n";
    return $html;
}

/**
 * Textarea field
 */
function textarea(string $name, ?string $label = null, ?string $value = '', ?string $error = null, array $options = []): string
{
    $label = $label ?? ucfirst($name);
    $required = $options['required'] ?? false;
    $class = $options['class'] ?? 'form-control';
    $rows = $options['rows'] ?? 4;
    $value = $value ?? '';

    $html = "<div class=\"mb-3\">\n";
    $html .= "  <label class=\"form-label\">" . htmlspecialchars($label) . "</label>\n";
    $html .= "  <textarea name=\"" . htmlspecialchars($name) . "\" class=\"$class\" rows=\"$rows\"";
    if ($required) $html .= ' required';
    $html .= ">" . htmlspecialchars($value) . "</textarea>\n";
    if ($error) {
        $html .= "  <div class=\"text-danger\">" . htmlspecialchars($error) . "</div>\n";
    }
    $html .= "</div>\n";
    return $html;
}

/**
 * Select dropdown
 */
function select(string $name, array $optionsList, ?string $label = null, ?string $value = '', ?string $error = null, array $config = []): string
{
    $label = $label ?? ucfirst($name);
    $required = $config['required'] ?? false;
    $class = $config['class'] ?? 'form-control';

    $html = "<div class=\"mb-3\">\n";
    $html .= "  <label class=\"form-label\">" . htmlspecialchars($label) . "</label>\n";
    $html .= "  <select name=\"" . htmlspecialchars($name) . "\" class=\"$class\"";
    if ($required) $html .= ' required';
    $html .= ">\n";
    foreach ($optionsList as $optValue => $optText) {
        $selected = ($optValue == $value) ? ' selected' : '';
        $html .= "    <option value=\"" . htmlspecialchars($optValue) . "\"$selected>" . htmlspecialchars($optText) . "</option>\n";
    }
    $html .= "  </select>\n";
    if ($error) {
        $html .= "  <div class=\"text-danger\">" . htmlspecialchars($error) . "</div>\n";
    }
    $html .= "</div>\n";
    return $html;
}

/**
 * Checkbox
 */
function checkbox(string $name, string $label, bool $checked = false, ?string $error = null): string
{
    $id = "chk_" . preg_replace('/[^a-z0-9_]/i', '_', $name);
    $html = "<div class=\"form-check mb-3\">\n";
    $html .= "  <input class=\"form-check-input\" type=\"checkbox\" name=\"" . htmlspecialchars($name) . "\" id=\"$id\" value=\"1\"";
    if ($checked) $html .= ' checked';
    $html .= ">\n";
    $html .= "  <label class=\"form-check-label\" for=\"$id\">" . htmlspecialchars($label) . "</label>\n";
    if ($error) {
        $html .= "  <div class=\"text-danger\">" . htmlspecialchars($error) . "</div>\n";
    }
    $html .= "</div>\n";
    return $html;
}

/**
 * Hidden input
 */
function hidden(string $name, ?string $value = ''): string
{
    $value = $value ?? '';
    return "<input type=\"hidden\" name=\"" . htmlspecialchars($name) . "\" value=\"" . htmlspecialchars($value) . "\">";
}

/**
 * Number input
 */
function number(string $name, ?string $label = null, ?string $value = '', ?string $error = null, array $options = []): string
{
    $label = $label ?? ucfirst($name);
    $required = $options['required'] ?? false;
    $class = $options['class'] ?? 'form-control';
    $min = $options['min'] ?? null;
    $max = $options['max'] ?? null;
    $step = $options['step'] ?? null;
    $value = $value ?? '';

    $html = "<div class=\"mb-3\">\n";
    $html .= "  <label class=\"form-label\">" . htmlspecialchars($label) . "</label>\n";
    $html .= "  <input type=\"number\" name=\"" . htmlspecialchars($name) . "\" value=\"" . htmlspecialchars($value) . "\" class=\"$class\"";
    if ($required) $html .= ' required';
    if ($min !== null) $html .= ' min="' . (int)$min . '"';
    if ($max !== null) $html .= ' max="' . (int)$max . '"';
    if ($step !== null) $html .= ' step="' . htmlspecialchars($step) . '"';
    $html .= ">\n";
    if ($error) {
        $html .= "  <div class=\"text-danger\">" . htmlspecialchars($error) . "</div>\n";
    }
    $html .= "</div>\n";
    return $html;
}

/**
 * CSRF protection field
 * Generates a hidden input with a secure token.
 * Call this once per form.
 */
function csrf_field(): string
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return hidden('csrf_token', $_SESSION['csrf_token']);
}

/**
 * Validate CSRF token on POST
 * @return bool
 */
function validate_csrf(): bool
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return true;
    }
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $token = $_POST['csrf_token'] ?? '';
    return hash_equals($_SESSION['csrf_token'] ?? '', $token);
}
