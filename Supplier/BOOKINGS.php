<?php
require_once __DIR__ . '/../config/db.php';
require_role('supplier');

$pdo = db();

// Handle accept/reject actions
if (isset($_GET['action'], $_GET['id'])) {
    $action = in_array($_GET['action'], ['accepted', 'rejected', 'pending']) ? $_GET['action'] : 'pending';
    $pdo->prepare("UPDATE bookings SET status = ? WHERE booking_id = ?")->execute([$action, intval($_GET['id'])]);
    header('Location: BOOKINGS.php');
    exit;
}

// Fetch all bookings for this supplier
$rows = $pdo->prepare("
    SELECT b.*, e.title, e.event_date, e.budget, e.venue_address, s.name as service_name, u.full_name as client_name 
    FROM bookings b 
    JOIN events e ON b.event_id = e.event_id 
    JOIN supplier_services s ON b.service_id = s.service_id 
    JOIN users u ON e.user_id = u.user_id
    WHERE s.user_id = ? 
    ORDER BY b.created_at DESC
");
$rows->execute([$_SESSION['user_id']]);
$bookingRows = $rows->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings</title>
    <link rel="stylesheet" href="../css/supplier.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php require_once __DIR__ . '/sidebar.php'; ?>

        <main class="main-content">
            <div id="header"></div>

            <section class="booking-request">
                <h2>All Bookings</h2>
                <div style="overflow-x:auto;">
                    <table class="booking-table">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Service</th>
                                <th>Client</th>
                                <th>Date</th>
                                <th>Budget</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($bookingRows)): ?>
                            <tr>
                                <td colspan="7" style="text-align:center;padding:40px;color:var(--muted);">No bookings yet</td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($bookingRows as $r): ?>
                            <tr>
                                <td><?= esc($r['title'] ?? 'N/A') ?></td>
                                <td><?= esc($r['service_name'] ?? 'N/A') ?></td>
                                <td><?= esc($r['client_name'] ?? 'N/A') ?></td>
                                <td><span class="date"><?= esc($r['event_date'] ?? 'TBD') ?></span></td>
                                <td>₱<?= number_format($r['budget'] ?? 0) ?></td>
                                <td>
                                    <span style="
                                        display:inline-block;
                                        padding:6px 14px;
                                        border-radius:999px;
                                        font-size:12px;
                                        font-weight:700;
                                        <?= $r['status']==='accepted' ? 'background:rgba(100,255,150,.15);color:#64ff96;' : ($r['status']==='rejected' ? 'background:rgba(255,100,100,.15);color:#ff6464;' : 'background:rgba(243,197,71,.15);color:var(--gold);') ?>
                                    ">
                                        <?= esc(ucfirst($r['status'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($r['status'] === 'pending'): ?>
                                    <a href="?action=accepted&id=<?= $r['booking_id'] ?>" class="accept-btn" style="text-decoration:none;display:inline-block;margin-right:6px;">Accept</a>
                                    <a href="?action=rejected&id=<?= $r['booking_id'] ?>" class="decline-btn" style="text-decoration:none;display:inline-block;">Decline</a>
                                    <?php else: ?>
                                    <a href="?action=pending&id=<?= $r['booking_id'] ?>" style="color:var(--muted);font-size:13px;text-decoration:underline;">Reset</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
    <script src="../js/header.js"></script>
</body>
</html>
