<?php
require_once __DIR__ . '/config/db.php';

// Create admin user
$username = 'admin';
$email = 'admin@example.com';
$password = password_hash('admin123', PASSWORD_DEFAULT);
$role = 'admin';
$status = 'approved';
$full_name = 'Administrator';

try {
    $stmt = db()->prepare("INSERT INTO users (username, email, password, role, status, full_name) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$username, $email, $password, $role, $status, $full_name]);
    echo "Admin user created successfully. Username: admin, Password: admin123";
} catch (Exception $e) {
    echo "Error creating admin user: " . $e->getMessage();
}
?>