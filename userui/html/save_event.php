<?php
require_once __DIR__ . '/../../config/db.php';
require_role('client');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: createevent.php'); exit; }

$event_type = trim($_POST['event_type'] ?? '');
if ($event_type === 'Others' && trim($_POST['other_event_type'] ?? '') !== '') $event_type = trim($_POST['other_event_type']);
$date = $_POST['event_date'] ?? '';
$time = $_POST['event_time'] ?? '';
$guest_count = intval($_POST['guest_count'] ?? 0);
$services = $_POST['services'] ?? [];
$title = $event_type . ' Event';

$stmt = db()->prepare("INSERT INTO events (user_id,title,event_type,event_date,event_time,guest_count,status) VALUES (?,?,?,?,?,?,?)");
$stmt->execute([$_SESSION['user_id'],$title,$event_type,$date,$time,$guest_count,'planning']);
$event_id = db()->lastInsertId();

$stmt = db()->prepare("INSERT INTO event_services (event_id,service_name) VALUES (?,?)");
foreach ($services as $s) $stmt->execute([$event_id, preg_replace('/[^a-zA-Z0-9_ -]/','',$s)]);

/* Generate default editable invitation template */
$inv = db()->prepare("INSERT INTO invitations (event_id,title,message,theme_color,button_text) VALUES (?,?,?,?,?)");
$inv->execute([$event_id, "You're Invited to $title", "Please confirm your attendance.", "#f3c547", "Confirm RSVP"]);

header("Location: confirmation.php");
exit;
?>