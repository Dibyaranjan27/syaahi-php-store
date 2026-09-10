<?php
/**
 * Syaahi - Database Connection
 * Single connection to the unified 'syaahi' database
 */

require_once __DIR__ . '/config.php';

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    error_log('Database connection failed: ' . mysqli_connect_error());
    die('<div style="text-align:center;padding:50px;font-family:sans-serif;">'
        . '<h1>Service Unavailable</h1>'
        . '<p>Could not connect to the database. Please try again later.</p>'
        . '</div>');
}

// Set charset to utf8mb4
mysqli_set_charset($conn, 'utf8mb4');
