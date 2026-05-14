<?php require_once __DIR__ . '/../../config/db.php'; require_role('client');
$stmt=db()->prepare("SELECT * FROM events WHERE user_id=? ORDER BY event_date DESC");
$stmt->execute([$_SESSION['user_id']]);
$events=$stmt->fetchAll();
?><!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EventIntel - Your Events</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
  }

  body {
    background: #ffffff;
    color: #222;
    min-height: 100vh;
  }

  .container {
    max-width: 1600px;
    margin: auto;
    padding: 6px 48px 40px;
  }

  /* NAVBAR */
  .navbar {
    width: 100%;
    padding: 6px 0 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .logo {
    font-size: 26px;
    font-weight: 800;
    color: #f3c547;
    letter-spacing: 1px;
  }

  .nav-links {
    display: flex;
    align-items: center;
    gap: 18px;
  }

  .nav-links button {
    padding: 8px 18px;
    border-radius: 12px;
    border: 1px solid rgba(255, 215, 0, 0.25);
    background: #fff;
    color: #444;
    font-size: 14px;
    cursor: pointer;
    transition: 0.3s ease;
  }

  .nav-links button:hover,
  .nav-links .active {
    background: rgba(255, 215, 0, 0.12);
    color: #f3c547;
    box-shadow: 0 0 14px rgba(255, 215, 0, 0.12);
  }

  .profile-btn {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    border: 1px solid rgba(255, 215, 0, 0.30);
    background: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #f3c547;
    cursor: pointer;
  }

  /* HEADER */
  .header {
    margin-bottom: 30px;
  }

  .header h1 {
    font-size: 48px;
    margin-bottom: 10px;
    color:#111;
  }

  .header p {
    color: #555;
  }

  /* GRID */
  .events-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
  }

  .event-card {
    background: #fff;
    border: 1px solid rgba(255,215,0,.12);
    border-radius: 26px;
    overflow: hidden;
    transition: 0.3s ease;
    box-shadow: 0 8px 20px rgba(0,0,0,.08);
  }

  .event-card:hover {
    transform: translateY(-6px);
    border-color: rgba(255,215,0,.3);
    box-shadow: 0 18px 40px rgba(243,197,71,.12);
  }

  .event-img {
    height: 200px;
    overflow: hidden;
  }

  .event-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: brightness(.95);
    transition: .3s;
  }

  .event-card:hover img {
    transform: scale(1.05);
    filter: brightness(1);
  }

  .event-content {
    padding: 20px;
  }

  .event-content h3 {
    margin-bottom: 10px;
    font-size: 20px;
    color:#111;
  }

  .event-info {
    display: flex;
    flex-direction: column;
    gap: 6px;
    font-size: 14px;
    color: #666;
    margin-bottom: 15px;
  }

  .event-info i {
    color: #f3c547;
    margin-right: 6px;
  }

  .status {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    margin-bottom: 14px;
  }

  .status.upcoming {
    background: rgba(255,215,0,.12);
    color: #f3c547;
  }

  .status.completed {
    background: rgba(100,255,150,.12);
    color: #2a9d6f;
  }

  .card-actions {
    display: flex;
    gap: 10px;
  }

  .btn {
    flex: 1;
    padding: 10px;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    font-size: 13px;
    font-weight: 700;
  }

  .btn-primary {
    background: linear-gradient(135deg, #fff2ab, #f3c547, #c99208);
    color: #111;
  }

  .btn-outline {
    background: transparent;
    border: 1px solid rgba(255,215,0,.3);
    color: #f3c547;
  }

  .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(243,197,71,.2);
  }
  </style>


</head>
<body>

  <div class="container">

<div class="navbar">
  <div class="logo">EventIntel</div>

  <div class="nav-links">
    <button onclick="window.location.href='homepage.php'">Home</button>
    <button onclick="window.location.href='createevent.php'">Create Event</button>
    <button class="active">Your Events</button>

    <div class="profile-btn" onclick="window.location.href='profile.php'">
      <i class="fa-regular fa-user"></i>
    </div>
  </div>
</div>

<div class="header">
  <h1>Your Events</h1>
  <p>Manage and track all your upcoming and completed events.</p>
</div>


<div class="events-grid">
<?php if(!$events): ?>
  <p style="color:#aaa;">No events yet. Create your first event.</p>
<?php endif; ?>
<?php foreach($events as $ev): ?>
  <div class="event-card">
    <div class="event-img"><img src="https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=800&q=80"></div>
    <div class="event-content">
      <span class="status upcoming"><?=esc($ev['status'])?></span>
      <h3><?=esc($ev['title'])?></h3>
      <div class="event-info">
        <div><i class="fa-solid fa-calendar"></i> <?=esc($ev['event_date'])?> <?=esc($ev['event_time'])?></div>
        <div><i class="fa-solid fa-users"></i> <?=esc($ev['guest_count'])?> guests</div>
      </div>
      <div class="card-actions">
        <button class="btn btn-primary" onclick="window.location.href='guests.php?id=<?=$ev['event_id']?>'">Guests / QR</button>
        <button class="btn btn-outline" onclick="window.location.href='invitation_builder.php?id=<?=$ev['event_id']?>'">Edit Invitation</button>
        <button class="btn btn-outline" onclick="window.location.href='map.php?id=<?=$ev['event_id']?>'">GPS</button>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div></div></body></html>