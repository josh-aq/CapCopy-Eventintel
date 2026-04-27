<?php
// Supplier sidebar - included by all supplier pages
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<aside class="sidebar">
    <div class="brand">
        <h1><span class="blue-text">Event</span><span class="pink-text">Intel</span></h1>
        <div class="user-info">
            <strong><?= esc($_SESSION['full_name'] ?? $_SESSION['username'] ?? 'Supplier') ?></strong>
            <span class="supplier"><i class="fas fa-circle"></i> Supplier</span>
        </div>
    <nav class="nav-menu">
        <ul>
            <li class="<?= $currentPage==='DASHBOARD.php'?'active':'' ?>"><button onclick="location.href='DASHBOARD.php'">DASHBOARD</button></li>
            <li class="<?= $currentPage==='BOOKINGS.php'?'active':'' ?>"><button onclick="location.href='BOOKINGS.php'">BOOKINGS</button></li>
            <li class="<?= $currentPage==='SERVICES.php'?'active':'' ?>"><button onclick="location.href='SERVICES.php'">SERVICES</button></li>
            <li class="<?= $currentPage==='MESSAGES.php'?'active':'' ?>"><button onclick="location.href='MESSAGES.php'">MESSAGES</button></li>
            <li class="<?= $currentPage==='REVIEWS.php'?'active':'' ?>"><button onclick="location.href='REVIEWS.php'">REVIEWS</button></li>
            <li class="<?= $currentPage==='SETTINGS.php'?'active':'' ?>"><button onclick="location.href='SETTINGS.php'">SETTINGS</button></li>
            <li><button onclick="if(confirm('Are you sure you want to logout?')) location.href='../auth/logout.php'" style="background:rgba(255,80,80,.1);color:#ff8b8b;">LOGOUT</button></li>
        </ul>
    </nav>
</aside>
