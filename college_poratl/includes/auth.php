<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user']);
}

/**
 * Protect page (any logged-in user)
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: ../index.php");
        exit;
    }
}

/**
 * Protect page by role (student / faculty)
 */
function requireRole($role) {
    if (!isLoggedIn() || $_SESSION['user']['role'] !== $role) {
        header("Location: ../index.php");
        exit;
    }
}
?>
