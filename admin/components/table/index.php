<?php
if (!defined('CMS_LOADED')) {
    exit('Direct access not allowed.');
}

// Global flag to print styles only once
if (!isset($GLOBALS['admin_table_printed'])) {
    $GLOBALS['admin_table_printed'] = false;
}

function admin_table(
    string $table,
    array $columns,
    array $labels = [],
    array $actions = []
): void {
    if (!$GLOBALS['admin_table_printed']) {
        echo '
            <link rel="stylesheet" href="/admin/components/table/style.css">
        ';
        $GLOBALS['admin_table_printed'] = true;
    }

    if (empty($labels)) {
        $labels = $columns;
    }

    // Fetch data
    $cols = implode(', ', array_map(fn($c) => "`$c`", $columns));
    $rows = DB::query("SELECT $cols, id FROM `{$table}` ORDER BY id DESC");

    echo '
    <div class="admin-table-wrapper">
        <div class="admin-table-card">
            <div class="table-responsive">
                <table class="table mb-0 admin-table">
                    <thead><tr>';

    foreach ($labels as $label) {
        echo '<th>' . htmlspecialchars($label) . '</th>';
    }

    if (!empty($actions)) {
        echo '<th>Actions</th>';
    }

    echo '</tr></thead><tbody>';

    foreach ($rows as $row) {
        echo '<tr>';
        foreach ($columns as $col) {
            echo '<td>' . htmlspecialchars($row[$col] ?? '') . '</td>';
        }

        if (!empty($actions)) {
            echo '<td><div class="d-flex gap-2">';
            foreach ($actions as $action) {
                $jsCode = $action['action']($row);
                $class = $action['class'] ?? 'btn-outline-secondary';
                $label = htmlspecialchars($action['label']);
                $icon = $action['icon'] ?? '';

                echo "<button type=\"button\" class=\"btn btn-sm $class\" 
                onclick=\"{$jsCode}\"
                style=\"transition: transform 0.2s; transform-origin: center;\"
                onmouseover=\"this.style.transform='translateX(4px)'\" 
                onmouseout=\"this.style.transform='translateX(0)'\">
                $icon $label
                </button>";
            }
            echo '</div></td>';
        }
        echo '</tr>';
    }

    echo '
                    </tbody>
                </table>
            </div>
        </div>
    </div>';
}
