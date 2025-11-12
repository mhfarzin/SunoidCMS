<?php
/**
 * Database Access Layer
 *
 * A cms singleton-like PDO wrapper for database operations.
 * Provides basic methods for SELECT, INSERT, UPDATE, and DELETE.
 * Must be included only after CMS initialization (via `CMS_LOADED` check).
 */

// Prevent direct access to this file
if (!defined('CMS_LOADED')) {
    exit('Direct access not allowed.');
}

if (class_exists('DB')) {
    return;
}

class DB
{
    private static ?PDO $pdo = null;

    private static function connectIfNeeded(): void
    {
        if (self::$pdo) {
            return;
        }

        require_once __DIR__ . '/../config/database.php';

        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        self::$pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false, // Optional: for stricter security
        ]);
    }

    /**
     * Execute a SELECT query and return all results.
     *
     * @param string $sql      SQL query with placeholders
     * @param array  $params   Parameters to bind
     * @return array           Associative array of results
     */
    public static function query(string $sql, array $params = []): array
    {
        self::connectIfNeeded();
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Insert a new record into a table.
     *
     * @param string $table    Table name
     * @param array  $data     Associative array of column => value
     * @return int             Last inserted ID
     */
    public static function insert(string $table, array $data): int
    {
        self::connectIfNeeded();
        $fields = array_keys($data);
        $placeholders = implode(', ', array_fill(0, count($fields), '?'));
        $sql = "INSERT INTO {$table} (" . implode(', ', $fields) . ") VALUES ({$placeholders})";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute(array_values($data));
        return (int) self::$pdo->lastInsertId();
    }

    /**
     * Update records in a table.
     *
     * @param string $table    Table name
     * @param array  $data     Associative array of column => value to update
     * @param string $where    WHERE clause (without 'WHERE')
     * @param array  $params   Parameters for the WHERE clause
     * @return int             Number of affected rows
     */
    public static function update(string $table, array $data, string $where, array $params = []): int
    {
        self::connectIfNeeded();
        $set = implode(', ', array_map(fn($field) => "{$field} = ?", array_keys($data)));
        $sql = "UPDATE {$table} SET {$set} WHERE {$where}";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute(array_merge(array_values($data), $params));
        return $stmt->rowCount();
    }

    /**
     * Delete records from a table.
     *
     * @param string $table    Table name
     * @param string $where    WHERE clause (without 'WHERE')
     * @param array  $params   Parameters for the WHERE clause
     * @return int             Number of affected rows
     */
    public static function delete(string $table, string $where, array $params = []): int
    {
        self::connectIfNeeded();
        $sql = "DELETE FROM {$table} WHERE {$where}";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }
}