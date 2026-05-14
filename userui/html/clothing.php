<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EventIntel - Select Clothing</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background: #f8f8f8;
      color: #111111;
      min-height: 100vh;
      overflow-x: hidden;
      position: relative;
    }

    body::before,
    body::after {
      content: "";
      position: fixed;
      border-radius: 50%;
      filter: blur(140px);
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
      width: 550px;
      height: 550px;
      background: rgba(255, 215, 0, 0.07);
      bottom: -220px;
      right: -180px;
    }

    .background-strip {
      position: fixed;
      inset: 0;
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      opacity: 0.24;
      z-index: 0;
    }

    .background-strip img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      filter: brightness(1) blur(2px);
    }

    .background-strip::after {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(
        to bottom,
        rgba(255,255,255,.88),
        rgba(255,255,255,.60),
        rgba(255,255,255,.92)
      );
    }

    .container {
      position: relative;
      z-index: 2;
      width: 100%;
      min-height: 100vh;
      padding-bottom: 40px;
    }

    .navbar {
      width: 100%;
      padding: 18px 50px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: relative;
      z-index: 3;
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 0;
    }

    .logo-text {
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
      border: 1px solid rgba(212,160,23,0.18);
      background: rgba(255,255,255,0.72);
      color: #222;
      font-size: 14px;
      cursor: pointer;
      transition: 0.3s ease;
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
      border: 1px solid rgba(212,160,23,0.22);
      background: rgba(255,255,255,0.75);
      display: flex;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      transition: 0.3s ease;
    }

    .profile-btn:hover {
      background: rgba(255,255,255,0.95);
      box-shadow: 0 0 14px rgba(255, 215, 0, 0.18);
    }

    .profile-btn i {
      color: #d4a017;
      font-size: 18px;
    }

    .hero {
      padding: 10px 50px 30px;
    }

    .hero h1 {
      font-size: 56px;
      font-weight: 900;
      margin-bottom: 12px;
      color: #111;
    }

    .hero p {
      max-width: 700px;
      color: #666666;
      line-height: 1.7;
      font-size: 15px;
    }

    .clothing-grid {
      padding: 0 50px 40px;
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 26px;
    }

    .clothing-card {
      background: rgba(255,255,255,0.78);
      border: 1px solid rgba(212,160,23,0.14);
      border-radius: 28px;
      overflow: hidden;
      backdrop-filter: blur(16px);
      box-shadow: 0 18px 40px rgba(0,0,0,0.08);
      transition: 0.35s ease;
      position: relative;
    }

    .clothing-card:hover {
      transform: translateY(-8px);
      border-color: rgba(212,160,23,0.3);
      box-shadow: 0 24px 50px rgba(243,197,71,0.12);
    }

    .clothing-image {
      position: relative;
      height: 330px;
      overflow: hidden;
    }

    .clothing-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      filter: brightness(0.95);
      transition: 0.35s ease;
    }

    .clothing-card:hover .clothing-image img {
      transform: scale(1.05);
      filter: brightness(1);
    }

    .clothing-image::after {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(
        to top,
        rgba(255,255,255,.92),
        rgba(255,255,255,.08)
      );
    }

    .tag {
      position: absolute;
      top: 16px;
      right: 16px;
      z-index: 2;
      padding: 8px 14px;
      border-radius: 999px;
      background: rgba(243,197,71,.14);
      border: 1px solid rgba(243,197,71,.25);
      color: #d4a017;
      font-size: 12px;
      font-weight: 700;
    }

    .clothing-content {
      padding: 24px;
    }

    .clothing-content h3 {
      font-size: 24px;
      margin-bottom: 12px;
      color: #111;
    }

    .clothing-content p {
      color: #666666;
      line-height: 1.6;
      margin-bottom: 18px;
      min-height: 70px;
    }

    .clothing-meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .price {
      color: #d4a017;
      font-size: 22px;
      font-weight: 800;
    }

    .select-btn {
      padding: 14px 24px;
      border-radius: 16px;
      border: none;
      background: linear-gradient(135deg, #fff1a8, #f3c547, #c99208);
      color: #111;
      font-weight: 800;
      cursor: pointer;
      transition: 0.3s ease;
    }

    .select-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 24px rgba(243,197,71,0.25);
    }

    ::-webkit-scrollbar {
      width: 10px;
    }

    ::-webkit-scrollbar-thumb {
      background: rgba(243,197,71,0.45);
      border-radius: 999px;
    }
  </style>
</head>
<body>
  <div class="background-strip">
    <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=1200&q=80">
    <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=1200&q=80">
    <img src="https://images.unsplash.com/photo-1521572267360-ee0c2909d518?auto=format&fit=crop&w=1200&q=80">
    <img src="https://images.unsplash.com/photo-1529139574466-a303027c1d8b?auto=format&fit=crop&w=1200&q=80">
  </div>

  <div class="container">
    <div class="navbar">
      <div class="logo">
        <div class="logo-text">EventIntel</div>
      </div>

      <div class="nav-links">
        <button onclick="window.location.href='homepage.php'">Home</button>
        <button class="active" onclick="window.location.href='createevent.php'">Create Event</button>
        <button onclick="window.location.href='yourevents.php'">Your Events</button>
        <div class="profile-btn" onclick="window.location.href='profile.php'">
          <i class="fa-regular fa-user"></i>
        </div>
      </div>
    </div>

    <div class="hero">
      <h1>Select Clothing</h1>
      <p>Choose elegant outfits and styles that fit the theme of your event. Browse formal wear, casual attire, and matching sets for your celebration.</p>
    </div>

    <div class="clothing-grid">
      <div class="clothing-card">
        <div class="clothing-image">
          <span class="tag"></span>
          <img src="">
        </div>
        <div class="clothing-content">
          <h3></h3>
          <p></p>
          <div class="clothing-meta">
            <div class="price"></div>
            <button class="select-btn">Select</button>
          </div>
        </div>
      </div>

      <div class="clothing-card">
        <div class="clothing-image">
          <span class="tag"></span>
          <img src="">
        </div>
        <div class="clothing-content">
          <h3></h3>
          <p></p>
          <div class="clothing-meta">
            <div class="price"></div>
            <button class="select-btn">Select</button>
          </div>
        </div>
      </div>

      <div class="clothing-card">
        <div class="clothing-image">
          <span class="tag"></span>
          <img src="">
        </div>
        <div class="clothing-content">
          <h3></h3>
          <p></p>
          <div class="clothing-meta">
            <div class="price"></div>
            <button class="select-btn">Select</button>
          </div>
        </div>
      </div>
    </div>
  </div>

<script>
function selectService(serviceName, serviceType) {
  const params = new URLSearchParams(window.location.search);
  const from = params.get('from');
  if (from === 'createevent') {
    if (window.opener && !window.opener.closed) {
      window.opener.postMessage({ type: 'serviceSelected', service: serviceType }, '*');
      alert(serviceName + ' selected!');
      window.close();
    } else {
      const returnUrl = params.get('return') || 'createevent.php';
      window.location.href = returnUrl + '?selected=' + serviceType;
    }
  } else {
    alert(serviceName + ' selected!');
  }
}
document.querySelectorAll('.select-btn').forEach(function(btn) {
  btn.addEventListener('click', function() {
    const card = this.closest('.clothing-card');
    const name = card.querySelector('h3')?.textContent || 'Clothing';
    selectService(name, 'clothes');
  });
});
</script>
</body>
</html>
