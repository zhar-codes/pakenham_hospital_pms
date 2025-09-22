<?php
// lib/AuthDb.php
declare(strict_types=1);

/**
 * DB-backed login using users.password_hash (bcrypt) and status='Active'.
 * Returns a user array (without the hash) on success, or null on failure.
 */
function authdb_login(string $username, string $password): ?array {
    // Expect config/db.php to set $pdo (PDO MySQL connection)
    require_once __DIR__ . '/../config/db.php';

    // Fetch by username (case-sensitive as stored)
    $sql = "SELECT id, username, password_hash, role, email, status
            FROM users
            WHERE username = :u AND status = 'Active'
            LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['u' => $username]);
    $row = $stmt->fetch();

    if (!$row) {
        return null; // no such active user
    }

    // Verify bcrypt hash
    if (!password_verify($password, (string)$row['password_hash'])) {
        return null; // wrong password
    }

    // Strip sensitive fields before returning
    unset($row['password_hash']);
    return $row;
}

/**
 * Optional helper: get user by ID (without hash), useful for middleware.
 */
function authdb_get_user(int $userId): ?array {
    require_once __DIR__ . '/../config/db.php';
    $stmt = $pdo->prepare("SELECT id, username, role, email, status
                           FROM users WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $userId]);
    $row = $stmt->fetch();
    return $row ?: null;
}
