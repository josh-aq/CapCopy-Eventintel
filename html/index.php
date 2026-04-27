<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventIntel - Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <!-- Left Side - Branding -->
        <div class="left-section">
            <div class="branding-content">
                <h1 class="brand-title">EventIntel</h1>
                <p class="brand-tagline">EventIntel guides every decision with smart recommendations and Ai Generated Event Flow</p>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="right-section">
            <div class="login-form-container">
                <h2 class="welcome-title">Welcome!</h2>
<?php
$error = $_GET['error'] ?? '';
$message = '';
$color = '#ff8080';
if ($error === 'invalid') {
    $message = 'Invalid username/email or password.';
} elseif ($error === 'pending') {
    $message = 'Account pending approval. Please wait for admin verification.';
    $color = '#f3c547';
} elseif ($error === 'empty') {
    $message = 'Please enter both username and password.';
} elseif ($error === 'system') {
    $message = 'System error. Please try again later.';
} elseif (isset($_GET['registered'])) {
    $message = 'Account created. You can now login.';
    $color = '#7dffb0';
} elseif (isset($_GET['pending'])) {
    $message = 'Submitted for admin verification.';
    $color = '#f3c547';
}
?>
<?php if ($message): ?>
    <p style="color:<?= htmlspecialchars($color) ?>;text-align:center;margin:8px 0;"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

                <form class="login-form" action="../auth/login.php" method="POST">
                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="icon fas fa-user"></i>
                            <input type="text" name="username" placeholder="Username or Email" class="input-field" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-wrapper">
                            <i class="icon fas fa-lock"></i>
                            <input type="password" name="password" placeholder="Password" class="input-field" required>
                            <span class="toggle-password"><i class="fas fa-eye"></i></span>
                        </div>
                    </div>

                    <button type="submit" class="login-button">Login</button>
                </form>

                <div class="signup-section">
                    <p class="signup-text">Don't have an account? <a href="signup.php" class="signup-link">Sign Up</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

