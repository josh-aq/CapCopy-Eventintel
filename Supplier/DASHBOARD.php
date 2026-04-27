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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>DASHBOARD</title>
    <link rel="stylesheet" href="../css/supplier.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <?php require_once __DIR__ . '/sidebar.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <div id="header"></div>

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
