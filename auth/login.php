<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect_to('/html/index.php');
}

$login = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($login === '' || $password === '') {
    redirect_to('/html/index.php?error=empty');
}

try {
    $stmt = db()->prepare('SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1');
    $stmt->execute([$login, $login]);
    $user = $stmt->fetch();

    if (!$user) {
        redirect_to('/html/index.php?error=invalid');
    }

    $stored = (string)($user['password'] ?? '');
    $validPassword = password_verify($password, $stored);

    // Local-dev safety: allows older demo rows that still have plain text passwords.
    // After login, immediately upgrades the password to a secure hash.
    if (!$validPassword && hash_equals($stored, $password)) {
        $validPassword = true;
        $newHash = password_hash($password, PASSWORD_DEFAULT);
        db()->prepare('UPDATE users SET password = ? WHERE user_id = ?')->execute([$newHash, $user['user_id']]);
    }

    if (!$validPassword) {
        redirect_to('/html/index.php?error=invalid');
    }

    // Check approval status for supplier and coordinator
    if (in_array($user['role'], ['supplier', 'coordinator'], true) && $user['status'] !== 'approved') {
        redirect_to('/html/index.php?error=pending');
    }

    // Set session variables
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['full_name'] = $user['full_name'] ?: $user['username'];
    $_SESSION['role'] = $user['role'];

    // Ensure session data is written before redirect
    session_write_close();

    // Redirect based on role
    switch ($user['role']) {
        case 'admin':
            redirect_to('/admin/dashboard.php');
            break;
        case 'supplier':
            redirect_to('/Supplier/DASHBOARD.php');
            break;
        case 'coordinator':
            redirect_to('/userui/html/eventcoor.php');
            break;
        default:
            redirect_to('/userui/html/homepage.php');
    }

} catch (Exception $e) {
    error_log('Login error: ' . $e->getMessage());
    redirect_to('/html/index.php?error=system');
}
?>
