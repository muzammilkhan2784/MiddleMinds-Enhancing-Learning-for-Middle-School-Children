<?php
// Shared MySQL connection. Override any value with an environment variable.
function db(): mysqli
{
    static $conn = null;
    if ($conn === null) {
        $conn = new mysqli(
            getenv('DB_HOST') ?: 'localhost',
            getenv('DB_USER') ?: 'root',
            getenv('DB_PASS') ?: '',
            getenv('DB_NAME') ?: 'middleminds'
        );
        if ($conn->connect_error) {
            http_response_code(500);
            exit('Database connection failed. Check includes/db.php and import db/schema.sql.');
        }
        $conn->set_charset('utf8mb4');
    }
    return $conn;
}
