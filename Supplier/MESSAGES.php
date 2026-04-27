<?php
require_once __DIR__ . '/../config/db.php';
require_role('supplier');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>MESSAGES</title>
    <link rel="stylesheet" href="../css/supplier.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <?php require_once __DIR__ . '/sidebar.php'; ?>

        <main class="main-content">
            <div id="header"></div>

            <section class="messages">
                <h3>Messages</h3>
                <div style="text-align:center;padding:60px 40px;background:var(--panel);border:1px solid var(--border);border-radius:30px;box-shadow:var(--shadow);">
                    <i class="fas fa-envelope" style="font-size:48px;color:var(--gold);margin-bottom:16px;"></i>
                    <h4 style="color:var(--text);margin-bottom:10px;">Messages Coming Soon</h4>
                    <p style="color:var(--muted);">This feature will be available in the next update.</p>
                </div>
            </section>
        </main>
    </div>
    <script src="../js/header.js"></script>
</body>
</html>
