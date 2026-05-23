<?php require_once __DIR__ . '/../../config/db.php'; require_role('client'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EventIntel - Create Event</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Segoe UI", sans-serif;
    }

    :root {
      --bg: #f8f8f8;
      --panel: rgba(255,255,255,0.78);
      --panel-2: rgba(255,255,255,0.88);
      --gold: #d4a017;
      --gold-soft: rgba(212,160,23,0.12);
      --border: rgba(212,160,23,0.14);
      --text: #111111;
      --muted: #666666;
    }

    body {
      background:
        radial-gradient(circle at top left, rgba(243,197,71,0.12), transparent 28%),
        radial-gradient(circle at bottom right, rgba(243,197,71,0.08), transparent 32%),
        var(--bg);
      color: var(--text);
      min-height: 100vh;
      overflow-x: hidden;
      overflow-y: auto;
      position: relative;
    }

    body::before {
      content: "";
      position: fixed;
      inset: 0;
      background:
        linear-gradient(rgba(0,0,0,0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(0,0,0,0.03) 1px, transparent 1px);
      background-size: 60px 60px;
      mask-image: radial-gradient(circle at center, black 40%, transparent 100%);
      pointer-events: none;
      z-index: 0;
    }

    .event-bg {
      position: fixed;
      inset: 0;
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      opacity: 0.28;
      z-index: 0;
      overflow: hidden;
    }

    .event-bg img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      filter: blur(2px) brightness(1) saturate(0.9);
      transform: scale(1.08);
    }

    .event-bg::after {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(
        to bottom,
        rgba(255,255,255,0.82),
        rgba(255,255,255,0.55) 35%,
        rgba(255,255,255,0.88)
      );
    }

    .container {
      position: relative;
      z-index: 2;
      width: min(1600px, 100%);
      margin: 0 auto;
      min-height: 100vh;
      padding: 26px 42px 40px;
    }

    .navbar {
      width: 100%;
      padding: 6px 0 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: relative;
      z-index: 3;
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 26px;
      font-weight: 800;
      color: var(--gold);
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
      border: 1px solid rgba(212,160,23,0.18);
      background: rgba(255,255,255,0.65);
      color: #222;
      font-size: 14px;
      cursor: pointer;
      transition: 0.3s ease;
      font-weight: 500;
      backdrop-filter: blur(10px);
    }

    .nav-links button:hover,
    .nav-links .active {
      background: linear-gradient(to right, #ffe17a, #d4a017);
      color: #111;
      box-shadow: 0 0 14px rgba(255, 215, 0, 0.18);
    }

    .profile-btn {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      border: 1px solid rgba(212,160,23,0.25);
      background: rgba(255,255,255,0.75);
      display: flex;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      transition: 0.3s ease;
      color: var(--gold);
      font-size: 18px;
      backdrop-filter: blur(10px);
    }

    .profile-btn:hover {
      background: rgba(255,255,255,0.95);
      box-shadow: 0 0 14px rgba(255, 215, 0, 0.18);
    }

    .hero-bar {
      display: flex;
      justify-content: space-between;
      align-items: end;
      margin-bottom: 26px;
    }

    .hero-text small {
      color: var(--gold);
      letter-spacing: 4px;
      text-transform: uppercase;
      font-size: 12px;
    }

    .hero-text h1 {
      margin-top: 8px;
      font-size: 56px;
      line-height: 1;
      font-weight: 900;
      color: #111;
    }

    .hero-text p {
      margin-top: 14px;
      max-width: 620px;
      color: var(--muted);
      line-height: 1.6;
      font-size: 15px;
    }

    .progress {
      display: flex;
      gap: 14px;
    }

    .step {
      width: 54px;
      height: 54px;
      border-radius: 18px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: rgba(255,255,255,0.65);
      border: 1px solid var(--border);
      color: var(--muted);
      backdrop-filter: blur(14px);
    }

    .step.active {
      background: linear-gradient(135deg, #ffe27d, #c78f08);
      color: #111;
      box-shadow: 0 0 18px rgba(243,197,71,0.35);
    }

    .content {
      display: grid;
      grid-template-columns: 1.05fr 0.95fr;
      gap: 28px;
      padding-bottom: 50px;
    }

    .left-column,
    .right-column {
      display: flex;
      flex-direction: column;
      gap: 24px;
    }

    .card {
      position: relative;
      background: var(--panel);
      border: 1px solid rgba(212,160,23,0.12);
      border-radius: 30px;
      padding: 28px;
      backdrop-filter: blur(22px);
      box-shadow: 0 18px 40px rgba(0,0,0,0.08);
      overflow: hidden;
    }

    .card::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(243,197,71,0.45), transparent);
    }

    .card-title {
      display: flex;
      align-items: center;
      gap: 12px;
      color: var(--gold);
      font-size: 18px;
      font-weight: 700;
      margin-bottom: 22px;
      letter-spacing: 1px;
    }

    .event-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 16px;
    }

    .event-option {
      position: relative;
      display: flex;
      align-items: center;
      gap: 14px;
      padding: 18px;
      border-radius: 20px;
      background: rgba(255,255,255,0.68);
      border: 1px solid rgba(0,0,0,0.06);
      transition: .3s ease;
      cursor: pointer;
    }

    .event-option:hover {
      transform: translateY(-3px);
      border-color: rgba(243,197,71,0.35);
      background: rgba(243,197,71,0.08);
      box-shadow: 0 10px 24px rgba(243,197,71,0.08);
    }

    .event-option input {
      accent-color: var(--gold);
      width: 18px;
      height: 18px;
    }

    .event-option span {
      font-size: 15px;
      font-weight: 600;
      color: #111;
    }

    .other-input,
    .field input {
      width: 100%;
      padding: 16px 18px;
      border-radius: 18px;
      background: rgba(255,255,255,0.68);
      border: 1px solid rgba(0,0,0,0.06);
      color: #111;
      outline: none;
      transition: .3s ease;
    }

    .other-input {
      margin-top: 18px;
    }

    .other-input:focus,
    .field input:focus {
      border-color: rgba(243,197,71,0.45);
      box-shadow: 0 0 0 4px rgba(243,197,71,0.08);
      background: rgba(255,255,255,0.95);
    }

    .schedule-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 18px;
    }

    .field label {
      display: block;
      margin-bottom: 10px;
      font-size: 12px;
      text-transform: uppercase;
      letter-spacing: 2px;
      color: var(--muted);
    }

    .field.full {
      grid-column: span 2;
    }

    .services {
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .service-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 18px 20px;
      border-radius: 22px;
      background: var(--panel-2);
      border: 1px solid rgba(0,0,0,0.06);
      transition: .3s ease;
    }

    .service-row:hover {
      transform: translateX(6px);
      border-color: rgba(243,197,71,0.25);
      box-shadow: 0 12px 24px rgba(0,0,0,0.08);
    }

    .service-name {
      display: flex;
      align-items: center;
      gap: 14px;
      font-weight: 600;
      font-size: 16px;
      color: #111;
    }

    .service-name i {
      width: 42px;
      height: 42px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: rgba(243,197,71,0.1);
      color: var(--gold);
    }

    .service-actions {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .view-btn {
      border: none;
      padding: 12px 20px;
      border-radius: 999px;
      background: rgba(255,255,255,0.7);
      color: var(--gold);
      font-weight: 700;
      cursor: pointer;
      transition: .3s ease;
    }

    .view-btn:hover {
      background: linear-gradient(135deg, #ffe27d, #c88f09);
      color: #111;
    }

    .service-check {
      width: 42px;
      height: 42px;
      border-radius: 14px;
      accent-color: var(--gold);
      cursor: pointer;
    }

    .status {
      width: 42px;
      height: 42px;
      border-radius: 14px;
      background: rgba(40,140,70,0.12);
      color: #2fa45e;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 1px solid rgba(40,140,70,0.12);
    }

    .hidden-step {
      opacity: 0.4;
      pointer-events: none;
      transform: translateY(12px);
      transition: all 0.3s ease;
    }

    .step-indicator {
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      margin-bottom: 24px;
    }

    .step-pill {
      padding: 12px 18px;
      border-radius: 999px;
      background: rgba(255,255,255,0.80);
      color: #111;
      font-weight: 700;
      letter-spacing: .4px;
      transition: .3s ease;
    }

    .step-pill.active {
      background: linear-gradient(135deg, #ffe27d, #c78f08);
      color: #111;
      box-shadow: 0 0 16px rgba(243,197,71,.18);
    }

    .footer-actions {
      margin-top: auto;
      display: flex;
      justify-content: flex-end;
      gap: 14px;
      padding-top: 12px;
    }

    .footer-actions button {
      padding: 16px 32px;
      border-radius: 18px;
      font-size: 15px;
      font-weight: 700;
      border: none;
      cursor: pointer;
      transition: .3s ease;
    }

    .cancel-btn {
      background: rgba(0,0,0,0.05);
      color: #222;
      border: 1px solid rgba(0,0,0,0.08);
    }

    .create-btn {
      background: linear-gradient(135deg, #fff1a8, #f3c547 45%, #c98f08);
      color: #111;
      box-shadow: 0 18px 35px rgba(243,197,71,0.25);
    }

    .cancel-btn:hover,
    .create-btn:hover {
      transform: translateY(-3px);
    }

    ::-webkit-scrollbar {
      width: 10px;
    }

    ::-webkit-scrollbar-thumb {
      background: rgba(243,197,71,0.45);
      border-radius: 999px;
    }

    @media (max-width: 1200px) {
      .content {
        grid-template-columns: 1fr;
      }

      .hero-bar {
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
      }
    }
  </style>
</head>
<body>
  <div class="event-bg">
    <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&w=900&q=80">
    <img src="https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?auto=format&fit=crop&w=900&q=80">
    <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=900&q=80">
    <img src="https://images.unsplash.com/photo-1505236858219-8359eb29e329?auto=format&fit=crop&w=900&q=80">
  </div>

  <div class="container">
    <div class="navbar">
      <div class="logo">EventIntel</div>

      <div class="nav-links">
        <button type="button" onclick="window.location.href='homepage.php'">Home</button>
        <button type="button" class="active" onclick="window.location.href='createevent.php'">Create Event</button>
        <button type="button" onclick="window.location.href='yourevents.php'">Your Events</button>
        <div class="profile-btn" onclick="window.location.href='profile.php'" title="Profile">
          <i class="fa-regular fa-user"></i>
        </div>
      </div>
    </div>

    <h1>Create an Event</h1>
    <div class="step-indicator">
      <span class="step-pill active" data-step="1">1. Choose Event</span>
      <span class="step-pill" data-step="2">2. Schedule</span>
      <span class="step-pill" data-step="3">3. Services</span>
    </div>

    <form action="save_event.php" method="POST">
    <div class="content">
      <div class="left-column">
        <div class="card">
          <div class="card-title">Select Event Type</div>

          <div class="event-grid">
            <label class="event-option"><input type="radio" name="event_type" value="Birthday" required><span>Birthday</span></label>
            <label class="event-option"><input type="radio" name="event_type" value="Wedding" required><span>Wedding</span></label>
            <label class="event-option"><input type="radio" name="event_type" value="Anniversary" required><span>Anniversary</span></label>
            <label class="event-option"><input type="radio" name="event_type" value="Christening" required><span>Christening</span></label>
            <label class="event-option"><input type="radio" name="event_type" value="Gender Reveal" required><span>Gender Reveal</span></label>
            <label class="event-option"><input type="radio" name="event_type" value="Reunion" required><span>Reunion</span></label>
            <label class="event-option"><input type="radio" name="event_type" value="Others" required><span>Others</span></label>
          </div>

          <input class="other-input" type="text" name="other_event_type" placeholder="Other event type...">
        </div>

        <div class="card schedule-card hidden-step">
          <div class="card-title">Schedule & Attendees</div>

          <div class="schedule-grid">
            <div class="field">
              <label>Date</label>
              <input type="date" name="event_date" required>
            </div>

            <div class="field">
              <label>Time</label>
              <input type="time" name="event_time" required>
            </div>

            <div class="field" style="grid-column: span 2;">
              <label>Number of Attendees</label>
              <input type="number" name="guest_count" placeholder="120" min="1" required>
            </div>
          </div>
        </div>
      </div>

      <div class="right-column hidden-step" id="servicePanel">
        <div class="services">
          <div class="service-row" data-service="venue">
            <div class="service-name"><i class="fa-solid fa-location-dot"></i>Venue</div>
            <div class="service-actions">
              <button type="button" class="view-btn" onclick="openService('venue')">View</button>
              <input class="service-check" type="checkbox" name="services[]" value="venue" id="check-venue" readonly tabindex="-1" onclick="return false;">
            </div>
          </div>

          <div class="service-row" data-service="clothes">
            <div class="service-name"><i class="fa-solid fa-shirt"></i>Clothes</div>
            <div class="service-actions">
              <button type="button" class="view-btn" onclick="openService('clothing')">View</button>
              <input class="service-check" type="checkbox" name="services[]" value="clothes" id="check-clothes" readonly tabindex="-1" onclick="return false;">
            </div>
          </div>

          <div class="service-row" data-service="catering">
            <div class="service-name"><i class="fa-solid fa-utensils"></i>Food & Catering</div>
            <div class="service-actions">
              <button type="button" class="view-btn" onclick="openService('catering')">View</button>
              <input class="service-check" type="checkbox" name="services[]" value="catering" id="check-catering" readonly tabindex="-1" onclick="return false;">
            </div>
          </div>

          <div class="service-row" data-service="host">
            <div class="service-name"><i class="fa-solid fa-microphone"></i>Host</div>
            <div class="service-actions">
              <button type="button" class="view-btn" onclick="openService('host')">View</button>
              <input class="service-check" type="checkbox" name="services[]" value="host" id="check-host" readonly tabindex="-1" onclick="return false;">
            </div>
          </div>

          <div class="service-row" data-service="sounds_lights">
            <div class="service-name"><i class="fa-solid fa-lightbulb"></i>Sounds & Lights</div>
            <div class="service-actions">
              <button type="button" class="view-btn" onclick="openService('s&l')">View</button>
              <input class="service-check" type="checkbox" name="services[]" value="sounds_lights" id="check-sounds_lights" readonly tabindex="-1" onclick="return false;">
            </div>
          </div>

          <div class="service-row" data-service="photographer">
            <div class="service-name"><i class="fa-solid fa-camera"></i>Photographer</div>
            <div class="service-actions">
              <button type="button" class="view-btn" onclick="openService('photographers')">View</button>
              <input class="service-check" type="checkbox" name="services[]" value="photographer" id="check-photographer" readonly tabindex="-1" onclick="return false;">
            </div>
          </div>
        </div>

        <div class="footer-actions">
          <button type="button" class="cancel-btn" onclick="window.location.href='homepage.php'">Cancel</button>
          <button type="submit" class="create-btn">Create Event</button>
        </div>
      </div>
    </div>
    </form>
  </div>

<script>
function openService(service) {
  const url = service + '.php?from=createevent';
  const popup = window.open(url, 'SelectService', 'width=1000,height=700,scrollbars=yes,resizable=yes');
  if (!popup || popup.closed || typeof popup.closed === 'undefined') {
    window.location.href = url + '&return=' + encodeURIComponent(window.location.href);
  }
}

// Listen for messages from child windows (popups) that selected a service
window.addEventListener('message', function(e) {
  if (e.data && e.data.type === 'serviceSelected') {
    const service = e.data.service;
    const checkbox = document.getElementById('check-' + service);
    if (checkbox) {
      checkbox.checked = true;
      const row = checkbox.closest('.service-row');
      if (row) row.style.borderColor = 'rgba(243,197,71,0.45)';
    }
  }
});

function updateStep(step) {
  document.querySelectorAll('.step-pill').forEach(function(pill) {
    pill.classList.toggle('active', pill.dataset.step === String(step));
  });
}

function showScheduleIfReady() {
  const selectedEvent = document.querySelector('input[name="event_type"]:checked');
  const scheduleCard = document.querySelector('.schedule-card');
  const servicePanel = document.getElementById('servicePanel');
  if (selectedEvent) {
    scheduleCard.classList.remove('hidden-step');
    servicePanel.classList.remove('hidden-step');
    updateStep(2);
  } else {
    scheduleCard.classList.add('hidden-step');
    servicePanel.classList.add('hidden-step');
    updateStep(1);
  }
}

document.querySelectorAll('input[name="event_type"]').forEach(function(input) {
  input.addEventListener('change', function() {
    updateStep(2);
    showScheduleIfReady();
  });
});

const scheduleInputs = document.querySelectorAll('.schedule-grid input');
function checkScheduleComplete() {
  const filled = Array.from(scheduleInputs).every(function(input) {
    return input.value.trim() !== '';
  });
  if (filled) {
    updateStep(3);
  }
}
scheduleInputs.forEach(function(input) {
  input.addEventListener('input', checkScheduleComplete);
});

// Check URL params for returned selections from redirect flow
(function() {
  const params = new URLSearchParams(window.location.search);
  const selected = params.get('selected');
  if (selected) {
    selected.split(',').forEach(function(s) {
      const cb = document.getElementById('check-' + s.trim());
      if (cb) {
        cb.checked = true;
        const row = cb.closest('.service-row');
        if (row) row.style.borderColor = 'rgba(243,197,71,0.45)';
      }
    });
  }
  showScheduleIfReady();
})();
</script>
</body>
</html>
