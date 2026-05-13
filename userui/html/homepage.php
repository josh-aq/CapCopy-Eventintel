<?php require_once __DIR__ . '/../../config/db.php'; require_role('client'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EventIntel Homepage</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      width: 100vw;
      height: 100vh;
      overflow: hidden;
      background: #ffffff;
      color: #111;
      position: relative;
    }

    body::before,
    body::after {
      content: "";
      position: absolute;
      border-radius: 50%;
      filter: blur(120px);
      z-index: 0;
    }

    body::before {
      width: 450px;
      height: 450px;
      background: rgba(255, 196, 0, 0.10);
      top: -160px;
      left: -120px;
    }

    body::after {
      width: 520px;
      height: 520px;
      background: rgba(255, 215, 0, 0.07);
      bottom: -220px;
      right: -140px;
    }

    .container {
      width: 100%;
      height: 100%;
      position: relative;
      z-index: 1;
      display: flex;
      flex-direction: column;
      padding: 6px 48px 0;
    }

    .navbar {
      width: 100%;
      padding: 6px 0 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: relative;
      z-index: 3;
      backdrop-filter: blur(10px);
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
      border: 1px solid rgba(255,255,255,0.75);
      background: transparent;
      color: #444;
      font-size: 14px;
      cursor: pointer;
      transition: 0.3s ease;
      border: 1px solid rgba(212,160,23,0.35);
      background: rgba(255,255,255,0.55);
      color: #222;
    }

    .nav-links button:hover,
    .nav-links .active {
      background: linear-gradient(to right, #ffe17a, #d4a017);
      color: black;
      box-shadow: 0 0 14px rgba(255, 215, 0, 0.12);
    }

    .profile-btn {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      border: 1px solid rgba(255, 215, 0, 0.35);
      background: #f5f5f5;
      display: flex;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      transition: 0.3s ease;
      color: #f3c547;
    }

    .profile-btn:hover {
      background: rgba(255, 215, 0, 0.12);
      box-shadow: 0 0 14px rgba(255, 215, 0, 0.18);
    }

    .profile-btn i {
      font-size: 18px;
    }

    .hero {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 0 30px 10px;
      margin-top: -30px;
      position: relative;
      z-index: 2;
    }

    .subtitle {
      color: #d4a017;
      font-size: 12px;
      letter-spacing: 5px;
      text-transform: uppercase;
      margin-bottom: 14px;
    }

    .hero h1 {
      font-size: 52px;
      line-height: 1.1;
      font-weight: 900;
      max-width: 780px;
      color: #1a1a1a;
    }

    .hero h1 span {
      display: block;
      background: linear-gradient(to right, #ffe17a, #d4a017, #b8860b);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .hero p {
      margin-top: 18px;
      font-size: 16px;
      color: #444444;
      max-width: 680px;
      line-height: 1.5;
    }

    .button-group {
      margin-top: 40px;
      display: flex;
      gap: 18px;
    }

    .action-btn {
      width: 240px;
      height: 72px;
      border-radius: 18px;
      border: 2px solid #d4a017;
      background: rgba(255, 255, 255, 0.95);
      color: #b8860b;
      font-size: 18px;
      font-weight: 700;
      cursor: pointer;
      transition: 0.3s ease;
      box-shadow: 0 0 14px rgba(255, 215, 0, 0.10);
    }

    .action-btn.primary {
      background: linear-gradient(to right, #ffd54a, #b8860b);
      color: black;
      border: none;
      box-shadow: 0 0 28px rgba(255, 215, 0, 0.25);
    }

    .action-btn:hover {
      transform: translateY(-6px) scale(1.01);
      background: rgba(255, 215, 0, 0.08);
    }

    .action-btn.primary:hover {
      background: linear-gradient(to right, #ffe17a, #c99700);
    }

    .event-gallery {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      display: flex;
      overflow: hidden;
      z-index: 0;
      opacity: 0.38;
      filter: brightness(0.95) saturate(1);
    }

    .event-gallery::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(255,255,255,0.35);
      z-index: 2;
      pointer-events: none;
    }

    .event-card {
      flex: 1;
      height: 100%;
      overflow: hidden;
      position: relative;
    }

    .event-card::after {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(
          to top,
          rgba(255,255,255,0.30),
          rgba(255,255,255,0.05)
        );
      z-index: 1;
    }

    .event-card img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      filter: brightness(1) contrast(1.05) saturate(0.9);
      transform: scale(1.05);
    }

    .welcome-msg {
      position: side;
      top: 20px;
      right: 200px;
      color: #c99700;
      font-size: 14px;
      z-index: 10;
    }
  </style>
</head>
<body>
  <div class="container">

<nav class="navbar">
  <div class="logo">EventIntel</div>

  <div class="nav-links">
    <span class="welcome-msg">Welcome, <?= esc($_SESSION['full_name'] ?? 'User') ?>!</span>
    <button class="active" onclick="window.location.href='homepage.php'">Home</button>
    <button onclick="window.location.href='createevent.php'">Create Event</button>
    <button onclick="window.location.href='yourevents.php'">Your Events</button>

    <div class="profile-btn" onclick="window.location.href='profile.php'" title="Profile">
      <i class="fa-regular fa-user"></i>
    </div>
  </div>
</nav>

<section class="hero">
  <div class="subtitle">Smart Event Planning Platform</div>

  <h1>
    Plan Better Events with
    <span>EventIntel</span>
  </h1>

  <p>
    Organize memorable events, connect with professional coordinators,
    and receive intelligent recommendations tailored to your needs.
  </p>

  <div class="button-group">
    <button class="action-btn primary" onclick="window.location.href='createevent.php'">Create an Event</button>
    <button class="action-btn" onclick="window.location.href='eventcoor.php'">Find an Event Coordinator</button>
    <button class="action-btn" onclick="window.location.href='recommendation.php'">Ask for Recommendation</button>
  </div>
</section>

<section class="event-gallery">
  <div class="event-card">
    <img src="https://images.unsplash.com/photo-1527529482837-4698179dc6ce?auto=format&fit=crop&w=800&q=60">
  </div>

  <div class="event-card">
    <img src="https://images.unsplash.com/photo-1505236858219-8359eb29e329?auto=format&fit=crop&w=800&q=60">
  </div>

  <div class="event-card">
    <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=800&q=60">
  </div>

  <div class="event-card">
    <img src="https://images.unsplash.com/photo-1515169067868-5387ec356754?auto=format&fit=crop&w=800&q=60">
  </div>
</section>

  </div>
</body>
</html>
