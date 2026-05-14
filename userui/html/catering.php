<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EventIntel - Select Catering</title>
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
    color: #111;
    min-height: 100vh;
    overflow-x: hidden;
    position: relative;
  }

  /* GLOW EFFECTS */
  body::before,
  body::after {
    content: "";
    position: fixed;
    border-radius: 50%;
    filter: blur(140px);
    z-index: 0;
  }

  body::before {
    width: 430px;
    height: 430px;
    background: rgba(243,197,71,0.10);
    top: -140px;
    left: -120px;
  }

  body::after {
    width: 560px;
    height: 560px;
    background: rgba(243,197,71,0.07);
    bottom: -220px;
    right: -180px;
  }

  /* BACKGROUND STRIP */
  .background-strip {
    position: fixed;
    inset: 0;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    opacity: 0.22;
    z-index: 0;
    pointer-events: none;
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
      rgba(255,255,255,.90),
      rgba(255,255,255,.68),
      rgba(255,255,255,.94)
    );
  }

  /* MAIN CONTAINER */
  .container {
    position: relative;
    z-index: 2;
    max-width: 1600px;
    margin: 0 auto;
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
    border: 1px solid rgba(212,160,23,0.18);
    background: rgba(255,255,255,0.75);
    color: #222;
    font-size: 14px;
    cursor: pointer;
    transition: 0.3s ease;
  }

  .nav-links button:hover,
  .nav-links .active {
    background: linear-gradient(to right,#ffe17a,#d4a017);
    color: #111;
    box-shadow: 0 0 14px rgba(255,215,0,0.16);
  }

  .profile-btn {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    border: 1px solid rgba(212,160,23,0.22);
    background: rgba(255,255,255,0.82);
    display: flex;
    justify-content: center;
    align-items: center;
    color: #d4a017;
    cursor: pointer;
  }

  /* HERO */
  .hero {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 30px;
  }

  .hero h1 {
    font-size: 56px;
    font-weight: 900;
    margin-bottom: 12px;
    color: #111;
  }

  .hero p {
    max-width: 700px;
    color: #666;
    line-height: 1.7;
  }

  /* SEARCH */
  .search-box {
    position: relative;
    width: 340px;
  }

  .search-box input {
    width: 100%;
    padding: 16px 18px 16px 50px;
    border-radius: 18px;
    border: 1px solid rgba(212,160,23,0.14);
    background: rgba(255,255,255,0.82);
    color: #111;
    outline: none;
    font-size: 14px;
  }

  .search-box i {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: #d4a017;
  }

  /* GRID */
  .catering-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 26px;
  }

  /* CARD */
  .catering-card {
    background: rgba(255,255,255,.82);
    border: 1px solid rgba(212,160,23,.14);
    border-radius: 30px;
    overflow: hidden;
    transition: .35s ease;
    box-shadow: 0 18px 40px rgba(0,0,0,.08);
    backdrop-filter: blur(16px);
  }

  .catering-card:hover {
    transform: translateY(-8px);
    border-color: rgba(212,160,23,.3);
    box-shadow: 0 24px 50px rgba(243,197,71,.12);
  }

  /* IMAGE */
  .catering-image {
    position: relative;
    height: 250px;
    overflow: hidden;
  }

  .catering-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: brightness(.95);
    transition: .35s ease;
  }

  .catering-card:hover .catering-image img {
    transform: scale(1.05);
    filter: brightness(1);
  }

  .catering-image::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(255,255,255,.90), rgba(255,255,255,.08));
  }

  /* BADGE */
  .badge {
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

  /* CONTENT */
  .catering-content {
    padding: 24px;
  }

  .catering-content h3 {
    font-size: 24px;
    margin-bottom: 10px;
    color: #111;
  }

  .details {
    display: flex;
    gap: 18px;
    color: #666;
    font-size: 14px;
    margin-bottom: 16px;
  }

  .details span {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .catering-content p {
    color: #777;
    line-height: 1.6;
    margin-bottom: 20px;
    min-height: 72px;
  }

  /* FOOTER */
  .footer {
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
    background: linear-gradient(135deg,#fff1a8,#f3c547,#c99208);
    color: #111;
    font-weight: 800;
    cursor: pointer;
    transition: .3s ease;
  }

  .select-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 24px rgba(243,197,71,.25);
  }
  </style>
</head>
<body>
  <div class="background-strip">
    <img src="https://images.unsplash.com/photo-1555244162-803834f70033?auto=format&fit=crop&w=1200&q=80">
    <img src="https://images.unsplash.com/photo-1467003909585-2f8a72700288?auto=format&fit=crop&w=1200&q=80">
    <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1200&q=80">
    <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?auto=format&fit=crop&w=1200&q=80">
  </div>

  <div class="container">
    <div class="navbar">
      <div class="logo">EventIntel</div>

      <div class="nav-links">
        <button onclick="window.location.href='homepage.php'">Home</button>
        <button class="active" onclick="window.location.href='createevent.php'">Create Event</button>
        <button onclick="window.location.href='yourevents.php'">Your Events</button>

        </div>
      </div>
    </div>

    <div class="hero">
      <div>
        <h1>Select Catering</h1>
        <p>Choose the ideal catering service for your event. Explore different cuisines, guest capacities, and premium menu packages.</p>
      </div>

      <div class="search-box">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" placeholder="Search cuisine or catering service...">
      </div>
    </div>

    <div class="catering-grid">
      <div class="catering-card">
        <div class="catering-image">
          <span class="badge"></span>
          <img src="">
        </div>
        <div class="catering-content">
          <h3></h3>
          <div class="details">
            <span><i class="fa-solid fa-star"></i> </span>
            <span><i class="fa-solid fa-users"></i> </span>
          </div>
          <p></p>
          <div class="footer">
            <div class="price"></div>
            <button class="select-btn">Select</button>
          </div>
        </div>
      </div>

      <div class="catering-card">
        <div class="catering-image">
          <span class="badge"></span>
          <img src="">
        </div>
        <div class="catering-content">
          <h3></h3>
          <div class="details">
            <span><i class="fa-solid fa-star"></i> </span>
            <span><i class="fa-solid fa-users"></i> </span>
          </div>
          <p></p>
          <div class="footer">
            <div class="price"></div>
            <button class="select-btn">Select</button>
          </div>
        </div>
      </div>

      <div class="catering-card">
        <div class="catering-image">
          <span class="badge"></span>
          <img src="">
        </div>
        <div class="catering-content">
          <h3></h3>
          <div class="details">
            <span><i class="fa-solid fa-star"></i> </span>
            <span><i class="fa-solid fa-users"></i> </span>
          </div>
          <p></p>
          <div class="footer">
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
    const card = this.closest('.catering-card');
    const name = card.querySelector('h3')?.textContent || 'Catering';
    selectService(name, 'catering');
  });
});
</script>
</body>
</html>
