<?php
require_once __DIR__ . '/../config/db.php';
require_role('supplier');

$pdo = db();

// Fetch real booking requests for this supplier
$bookings = $pdo->prepare("
    SELECT b.*, e.title, e.event_date, e.budget, s.name as service_name
    FROM bookings b
    JOIN events e ON b.event_id = e.event_id
    JOIN supplier_services s ON b.service_id = s.service_id
    WHERE s.user_id = ?
    ORDER BY b.created_at DESC
    LIMIT 10
");
$bookings->execute([$_SESSION['user_id']]);
$bookingRows = $bookings->fetchAll();

// Fetch supplier services
$services = $pdo->prepare("SELECT * FROM supplier_services WHERE user_id = ? LIMIT 6");
$services->execute([$_SESSION['user_id']]);
$serviceRows = $services->fetchAll();

// Fetch recent reviews
$reviews = $pdo->prepare("
    SELECT r.*, e.title as event_title
    FROM reviews r
    JOIN events e ON r.event_id = e.event_id
    WHERE r.service_id IN (SELECT service_id FROM supplier_services WHERE user_id = ?)
    ORDER BY r.created_at DESC
    LIMIT 3
");
$reviews->execute([$_SESSION['user_id']]);
$reviewRows = $reviews->fetchAll();

// Dashboard summary counts
$stats = $pdo->prepare("SELECT COUNT(*) as total, SUM(status='pending') as pending, SUM(status='accepted') as accepted, SUM(status='rejected') as rejected FROM bookings b JOIN supplier_services s ON b.service_id = s.service_id WHERE s.user_id = ?");
$stats->execute([$_SESSION['user_id']]);
$stats = $stats->fetch();

$serviceCount = $pdo->prepare("SELECT COUNT(*) as count FROM supplier_services WHERE user_id = ?");
$serviceCount->execute([$_SESSION['user_id']]);
$serviceCount = $serviceCount->fetchColumn();

$newsFeed = [
    ['title' => 'New supplier marketplace update', 'time' => '2 hours ago'],
    ['title' => 'Booking trends are rising this week', 'time' => 'Today'],
    ['title' => 'Remember to keep service profiles up to date', 'time' => 'Yesterday'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>DASHBOARD</title>
    <link rel="stylesheet" href="../css/supplier.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <style>
        .dashboard-summary{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;margin-bottom:28px}
        .summary-card{background:rgba(255,255,255,.06);border:1px solid rgba(243,197,71,.16);border-radius:24px;padding:24px;box-shadow:0 18px 40px rgba(0,0,0,.18);}
        .summary-card h4{font-size:16px;color:var(--gold);letter-spacing:1px;text-transform:uppercase;margin-bottom:14px}
        .summary-card p{font-size:34px;font-weight:900;color:var(--text);margin:0}
        .dashboard-grid{display:grid;grid-template-columns:2fr 1fr;gap:24px;margin-bottom:34px}
        .chart-card,.news-card{background:rgba(255,255,255,.06);border:1px solid rgba(243,197,71,.16);border-radius:28px;padding:28px;box-shadow:0 18px 40px rgba(0,0,0,.18);}
        .chart-card h3,.news-card h3{margin-bottom:22px;color:var(--text)}
        .chart-bar{display:grid;gap:18px}
        .chart-row{display:flex;align-items:center;gap:12px}
        .chart-label{width:110px;color:var(--muted);font-size:14px;white-space:nowrap}
        .chart-bar-track{flex:1;height:16px;border-radius:999px;background:rgba(255,255,255,.08);overflow:hidden}
        .chart-bar-fill{height:100%;border-radius:999px;background:linear-gradient(135deg,#ffe27d,#f3c547);}
        .feed-list{list-style:none;padding:0;margin:0;display:grid;gap:16px}
        .feed-item{padding:18px 20px;border-radius:20px;background:rgba(255,255,255,.05);border:1px solid rgba(243,197,71,.12);}
        .feed-item h4{font-size:16px;margin:0 0 8px;color:#fff}
        .feed-item time{color:var(--muted);font-size:13px}
        @media(max-width:900px){.dashboard-grid{grid-template-columns:1fr}}
    </style>
</head>
<body>
    <div class="container">
        <?php require_once __DIR__ . '/sidebar.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <div id="header"></div>

            <section class="dashboard-summary">
                <div class="summary-card">
                    <h4>Total Requests</h4>
                    <p><?= number_format($stats['total'] ?? 0) ?></p>
                </div>
                <div class="summary-card">
                    <h4>Pending</h4>
                    <p><?= number_format($stats['pending'] ?? 0) ?></p>
                </div>
                <div class="summary-card">
                    <h4>Accepted</h4>
                    <p><?= number_format($stats['accepted'] ?? 0) ?></p>
                </div>
                <div class="summary-card">
                    <h4>Your Services</h4>
                    <p><?= number_format($serviceCount ?? 0) ?></p>
                </div>
            </section>

            <section class="dashboard-grid">
                <div class="chart-card">
                    <h3>Booking Status Overview</h3>
                    <div class="chart-bar">
                        <div class="chart-row"><span class="chart-label">Accepted</span><div class="chart-bar-track"><div class="chart-bar-fill" style="width: <?= min(100, ($stats['accepted'] ?? 0) * 10) ?>%;"></div></div></div>
                        <div class="chart-row"><span class="chart-label">Pending</span><div class="chart-bar-track"><div class="chart-bar-fill" style="width: <?= min(100, ($stats['pending'] ?? 0) * 10) ?>%;background:linear-gradient(135deg,#f3c547,#f39f12);"></div></div></div>
                        <div class="chart-row"><span class="chart-label">Rejected</span><div class="chart-bar-track"><div class="chart-bar-fill" style="width: <?= min(100, ($stats['rejected'] ?? 0) * 10) ?>%;background:linear-gradient(135deg,#ff6b6b,#ff3d3d);"></div></div></div>
                    </div>
                </div>
                <div class="news-card">
                    <h3>News Feed</h3>
                    <ul class="feed-list">
                        <?php foreach ($newsFeed as $item): ?>
                        <li class="feed-item">
                            <h4><?= esc($item['title']) ?></h4>
                            <time><?= esc($item['time']) ?></time>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </section>

            <section class="booking-request">
                <h2>Booking Requests</h2>
                <div style="overflow-x:auto;">
                    <table class="booking-table">
                        <thead>
                            <tr>
                                <th>EVENT</th>
                                <th>SERVICE</th>
                                <th>DATE</th>
                                <th>BUDGET</th>
                                <th>STATUS</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($bookingRows)): ?>
                            <tr>
                                <td colspan="6" style="text-align:center;padding:40px;color:var(--muted);">No booking requests yet</td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($bookingRows as $r): ?>
                            <tr>
                                <td><?= esc($r['title'] ?? 'N/A') ?></td>
                                <td><?= esc($r['service_name'] ?? 'N/A') ?></td>
                                <td><span class="date"><?= esc($r['event_date'] ?? 'TBD') ?></span></td>
                                <td>₱<?= number_format($r['budget'] ?? 0) ?></td>
                                <td><?= esc($r['status']) ?></td>
                                <td>
                                    <?php if ($r['status'] === 'pending'): ?>
                                    <a href="BOOKINGS.php?action=accepted&id=<?= $r['booking_id'] ?>" class="accept-btn" style="text-decoration:none;display:inline-block;">Accept</a>
                                    <a href="BOOKINGS.php?action=rejected&id=<?= $r['booking_id'] ?>" class="decline-btn" style="text-decoration:none;display:inline-block;">Decline</a>
                                    <?php else: ?>
                                    <span style="color:var(--muted);">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="services-messages">
                <div class="services" style="width:100%;">
                    <h3>Your Services</h3>
                    <div class="services-grid">
                        <?php if (empty($serviceRows)): ?>
                        <div class="service-card" style="grid-column:1/-1;text-align:center;padding:40px;">
                            <p style="color:var(--muted);">No services yet. <a href="SERVICES.php" style="color:var(--gold);">Add your first service</a></p>
                        </div>
                        <?php else: ?>
                        <?php foreach ($serviceRows as $s): ?>
                        <div class="service-card">
                            <img src="../userui/images/logo.png" alt="<?= esc($s['name']) ?>" />
                            <h4><?= esc($s['name']) ?></h4>
                            <p><?= esc($s['category']) ?></p>
                            <p class="rating"><i class="fas fa-star"></i> <?= esc($s['rating'] ?? '5.0') ?></p>
                            <p style="color:var(--gold);font-weight:800;">₱<?= number_format($s['price'] ?? 0) ?></p>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
            </section>

            <?php if (!empty($reviewRows)): ?>
            <section class="reviews-page" style="margin-top:34px;">
                <h2>Recent Reviews</h2>
                <?php foreach ($reviewRows as $rev): ?>
                <div class="review-card">
                    <h3><?= esc($rev['event_title'] ?? 'Event') ?></h3>
                    <p class="stars"><?= str_repeat('⭐', $rev['rating'] ?? 5) ?></p>
                    <p><?= esc($rev['comment'] ?? 'No comment') ?></p>
                </div>
                <?php endforeach; ?>
            </section>
            <?php endif; ?>
        </main>
    </div>
    <script src="../js/header.js"></script>
</body>
</html>
