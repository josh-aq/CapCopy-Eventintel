<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EventIntel - Organizer Profile</title>
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
      max-width: 1400px;
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
      color: #d4a017;
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
      border: 1px solid rgba(212,160,23,0.25);
      background: #fff;
      color: #444;
      font-size: 14px;
      cursor: pointer;
      transition: 0.3s ease;
    }

    .nav-links button:hover,
    .nav-links .active {
      background: rgba(255, 215, 0, 0.10);
      color: #d4a017;
      box-shadow: 0 0 14px rgba(255, 215, 0, 0.10);
    }

    .profile-btn {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      border: 1px solid rgba(212,160,23,0.25);
      background: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #d4a017;
      cursor: pointer;
    }

    /* PROFILE SECTION */
    .profile {
      display: grid;
      grid-template-columns: 1fr 2fr;
      gap: 40px;
      margin-top: 20px;
    }

    .profile-card {
      background: rgba(255,255,255,.95);
      border: 1px solid rgba(212,160,23,.12);
      border-radius: 28px;
      padding: 30px;
      text-align: center;
      box-shadow: 0 12px 30px rgba(0,0,0,.08);
    }

    .profile-img {
      width: 140px;
      height: 140px;
      border-radius: 50%;
      overflow: hidden;
      margin: auto;
      margin-bottom: 18px;
      border: 2px solid rgba(212,160,23,.25);
    }

    .profile-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .profile-card h2 {
      margin-bottom: 8px;
      color: #111;
    }

    .role {
      color: #d4a017;
      font-size: 14px;
      margin-bottom: 14px;
    }

    .rating {
      color: #d4a017;
      margin-bottom: 20px;
    }

    .action-buttons {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .msg,
    .btn {
      padding: 12px;
      border-radius: 12px;
      cursor: pointer;
      font-weight: 700;
      transition: .3s ease;
      text-align: center;
    }

    .btn-primary {
      background: linear-gradient(135deg, #ffe27a, #d4a017, #b8860b);
      color: white;
      border: none;
      text-decoration: none;
    }

    .btn-outline,
    .msg {
      background: #fff;
      border: 1px solid rgba(212,160,23,.25);
      color: #d4a017;
      text-decoration: none;
    }

    .btn:hover,
    .msg:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 18px rgba(243,197,71,.18);
    }

    /* DETAILS */
    .details {
      display: flex;
      flex-direction: column;
      gap: 24px;
    }

    .section {
      background: rgba(255,255,255,.95);
      border: 1px solid rgba(212,160,23,.12);
      border-radius: 28px;
      padding: 26px;
      box-shadow: 0 12px 30px rgba(0,0,0,.08);
    }

    .section h3 {
      margin-bottom: 12px;
      font-size: 20px;
      color: #111;
    }

    .section p {
      color: #666;
      line-height: 1.6;
    }

    .services {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
    }

    .service {
      padding: 8px 14px;
      border-radius: 999px;
      background: rgba(243,197,71,.12);
      color: #d4a017;
      font-size: 13px;
      border: 1px solid rgba(212,160,23,.15);
    }

  </style>

</head>
<body>

  <div class="container">

<div class="navbar">
  <div class="logo">EventIntel</div>

  <div class="nav-links">
    <button>Home</button>
    <button>Create Event</button>
    <button>Your Events</button>

    <div class="profile-btn">
      <i class="fa-regular fa-user"></i>
    </div>
  </div>
</div>

<div class="profile">

  <!-- LEFT CARD -->
  <div class="profile-card">
    <div class="profile-img">
      <img src="../images/vince.jpg">
    </div>

    <h2>Vincent Tolentino</h2>
    <div class="role">Professional Event Coordinator</div>
    <div class="rating">★★★★★ (4.9)</div>

    <div class="action-buttons">
      <button class="btn btn-primary">Book Now</button>
       <a class = "msg" href="message.php" class="select-btn">Message</a>
    </div>
  </div>

  <!-- RIGHT DETAILS -->
  <div class="details">

    <div class="section">
      <h3>About</h3>
      <p>
        Vincent Tolentino is a highly experienced event organizer with over 8 years of
        experience in planning weddings, corporate events, and large-scale celebrations.
        Known for attention to detail and creative execution, Vincent ensures every event
        is memorable and stress-free.
      </p>
    </div>

    <div class="section">
      <h3>Services Offered</h3>
      <div class="services">
        <div class="service">Wedding Planning</div>
        <div class="service">Corporate Events</div>
        <div class="service">Birthday Parties</div>
        <div class="service">Full Coordination</div>
        <div class="service">On-the-day Coordination</div>
      </div>
    </div>

    <div class="section">
      <h3>Experience & Highlights</h3>
      <p>
        • Organized 300+ successful events<br>
        • Partnered with top venues and suppliers<br>
        • Awarded "Best Event Coordinator 2025"<br>
        • Specialized in luxury and themed events
      </p>
    </div>

  </div>

</div>
  </div>

</body>
</html>
