<?php
// Database configuration
define('DB_PATH', __DIR__ . '/jobs.db');

// Initialize SQLite database
try {
    $db = new PDO('sqlite:' . DB_PATH);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create tables if they don't exist
    $db->exec("
        CREATE TABLE IF NOT EXISTS jobs (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            customer_name TEXT NOT NULL,
            customer_info TEXT,
            job_date DATE NOT NULL,
            job_value DECIMAL(10, 2) NOT NULL,
            costs DECIMAL(10, 2) NOT NULL DEFAULT 0,
            amount_paid DECIMAL(10, 2) NOT NULL DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
