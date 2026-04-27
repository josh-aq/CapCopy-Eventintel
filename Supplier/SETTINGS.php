<?php
require_once __DIR__ . '/../config/db.php';
require_role('supplier');

$pdo = db();
$message = '';

// Fetch current user data
$user = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$user->execute([$_SESSION['user_id']]);
$userData = $user->fetch();

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    try {
        $pdo->prepare("UPDATE users SET full_name = ?, email = ?, phone = ?, business_name = ?, business_address = ? WHERE user_id = ?")
            ->execute([
                $_POST['full_name'],
                $_POST['email'],
                $_POST['phone'],
                $_POST['business_name'],
                $_POST['business_address'],
                $_SESSION['user_id']
            ]);
        $_SESSION['full_name'] = $_POST['full_name'];
        $message = 'Profile updated successfully!';
        // Refresh data
        $user->execute([$_SESSION['user_id']]);
        $userData = $user->fetch();
    } catch (Exception $e) {
        $message = 'Error updating profile: ' . $e->getMessage();
    }
}

// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    
    if ($new !== $confirm) {
        $message = 'New passwords do not match!';
    } elseif (!password_verify($current, $userData['password'])) {
        $message = 'Current password is incorrect!';
    } else {
        $pdo->prepare("UPDATE users SET password = ? WHERE user_id = ?")
            ->execute([password_hash($new, PASSWORD_DEFAULT), $_SESSION['user_id']]);
        $message = 'Password changed successfully!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SETTINGS</title>
    <link rel="stylesheet" href="../css/supplier.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <?php require_once __DIR__ . '/sidebar.php'; ?>

        <main class="main-content">
            <div id="header"></div>

            <section class="settings-page">
                <h2>Settings</h2>

                <?php if ($message): ?>
                <div style="padding:16px 20px;border-radius:14px;margin-bottom:24px;background:<?= strpos($message, 'Error') !== false || strpos($message, 'incorrect') !== false || strpos($message, 'not match') !== false ? 'rgba(255,80,80,.12)' : 'rgba(100,255,150,.12)' ?>;border:1px solid <?= strpos($message, 'Error') !== false || strpos($message, 'incorrect') !== false || strpos($message, 'not match') !== false ? 'rgba(255,80,80,.3)' : 'rgba(100,255,150,.3)' ?>;color:<?= strpos($message, 'Error') !== false || strpos($message, 'incorrect') !== false || strpos($message, 'not match') !== false ? '#ff8b8b' : '#64ff96' ?>;">
                    <?= esc($message) ?>
                </div>
                <?php endif; ?>

                <div class="settings-grid">
                    <div class="setting-card">
                        <h3><i class="fas fa-user" style="color:var(--gold);margin-right:8px;"></i>Profile Information</h3>
                        <form method="POST">
                            <input type="text" name="full_name" placeholder="Full Name" value="<?= esc($userData['full_name'] ?? '') ?>" style="width:100%;padding:13px 15px;margin-bottom:12px;border-radius:14px;border:1px solid var(--border);background:rgba(18,18,18,.88);color:var(--text);outline:none;">
                            <input type="email" name="email" placeholder="Email Address" value="<?= esc($userData['email'] ?? '') ?>" style="width:100%;padding:13px 15px;margin-bottom:12px;border-radius:14px;border:1px solid var(--border);background:rgba(18,18,18,.88);color:var(--text);outline:none;">
                            <input type="text" name="phone" placeholder="Phone Number" value="<?= esc($userData['phone'] ?? '') ?>" style="width:100%;padding:13px 15px;margin-bottom:12px;border-radius:14px;border:1px solid var(--border);background:rgba(18,18,18,.88);color:var(--text);outline:none;">
                            <input type="text" name="business_name" placeholder="Business Name" value="<?= esc($userData['business_name'] ?? '') ?>" style="width:100%;padding:13px 15px;margin-bottom:12px;border-radius:14px;border:1px solid var(--border);background:rgba(18,18,18,.88);color:var(--text);outline:none;">
                            <textarea name="business_address" placeholder="Business Address" style="width:100%;padding:13px 15px;margin-bottom:16px;border-radius:14px;border:1px solid var(--border);background:rgba(18,18,18,.88);color:var(--text);outline:none;min-height:80px;resize:vertical;"><?= esc($userData['business_address'] ?? '') ?></textarea>
                            <button type="submit" name="update_profile" class="setting-card button" style="width:100%;">Save Changes</button>
                        </form>
                    </div>

                    <div class="setting-card">
                        <h3><i class="fas fa-lock" style="color:var(--gold);margin-right:8px;"></i>Change Password</h3>
                        <form method="POST">
                            <input type="password" name="current_password" placeholder="Current Password" style="width:100%;padding:13px 15px;margin-bottom:12px;border-radius:14px;border:1px solid var(--border);background:rgba(18,18,18,.88);color:var(--text);outline:none;">
                            <input type="password" name="new_password" placeholder="New Password" style="width:100%;padding:13px 15px;margin-bottom:12px;border-radius:14px;border:1px solid var(--border);background:rgba(18,18,18,.88);color:var(--text);outline:none;">
                            <input type="password" name="confirm_password" placeholder="Confirm Password" style="width:100%;padding:13px 15px;margin-bottom:16px;border-radius:14px;border:1px solid var(--border);background:rgba(18,18,18,.88);color:var(--text);outline:none;">
                            <button type="submit" name="change_password" class="setting-card button" style="width:100%;">Update Password</button>
                        </form>
                    </div>

                    <div class="setting-card">
                        <h3><i class="fas fa-bell" style="color:var(--gold);margin-right:8px;"></i>Notification Settings</h3>
                        <form method="POST">
                            <label style="display:flex;align-items:center;gap:10px;margin-bottom:12px;color:var(--text);">
                                <input type="checkbox" checked style="width:16px;height:16px;accent-color:var(--gold);">
                                Booking Alerts
                            </label>
                            <label style="display:flex;align-items:center;gap:10px;margin-bottom:12px;color:var(--text);">
                                <input type="checkbox" checked style="width:16px;height:16px;accent-color:var(--gold);">
                                Messages
                            </label>
                            <label style="display:flex;align-items:center;gap:10px;margin-bottom:16px;color:var(--text);">
                                <input type="checkbox" style="width:16px;height:16px;accent-color:var(--gold);">
                                Promotions
                            </label>
                            <button type="button" class="setting-card button" style="width:100%;" onclick="alert('Settings saved!')">Save Preferences</button>
                        </form>
                    </div>
            </section>
        </main>
    </div>
    <script src="../js/header.js"></script>
</body>
</html>
