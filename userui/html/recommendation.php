<?php require_once __DIR__ . '/../../config/db.php'; require_role('client'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>EventIntel - Recommendation</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:'Segoe UI',sans-serif;
}

/* BACKGROUND GLOW EFFECT */
body::before,
body::after {
  content: "";
  position: absolute;
  border-radius: 50%;
  filter: blur(120px);
  z-index: 0;
  pointer-events: none;
}

/* TOP LEFT GOLD GLOW */
body::before {
  width: 420px;
  height: 420px;
  background: rgba(255, 196, 0, 0.10);
  top: -140px;
  left: -120px;
}

/* BOTTOM RIGHT GOLD GLOW */
body::after {
  width: 520px;
  height: 520px;
  background: rgba(255, 215, 0, 0.08);
  bottom: -200px;
  right: -140px;
}

body{
  background:#ffffff;
  color:#222;
  height:100vh;
  overflow:hidden;
}

/* NAVBAR */
.navbar { 
  width: 100%;
  padding: 18px 50px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.logo-text {
  font-size: 26px;
  font-weight: 800;
  color: #f3c547;
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
  cursor: pointer;
  transition:.3s;
}

.nav-links button:hover,
.nav-links .active {
  background: rgba(255, 215, 0, 0.12);
  color: #f3c547;
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
}

.profile-btn i {
  color: #f3c547;
}

/* LAYOUT */
.container{
  display:grid;
  grid-template-columns: 52% 48%;
  height: calc(100vh - 80px);
  overflow:hidden;
  position: relative;
  z-index: 1;
}

/* LEFT IMAGE */
.left{
  position: relative;
  height: 100%;
  overflow: hidden;
  display: flex;
  border-top-right-radius: 30px;
  border-bottom-right-radius: 30px;
}

.left::before{
  content: "";
  position: absolute;
  inset: 0;
  background: url('https://images.unsplash.com/photo-1519167758481-83f550bb49b3?auto=format&fit=crop&w=1200&q=80') center center / cover no-repeat;
  transform: scale(1.05);
}

.left::after{
  content:'';
  position:absolute;
  inset:0;
  background: linear-gradient(
    to right,
    rgba(255,255,255,0.92) 0%,
    rgba(255,255,255,0.60) 50%,
    rgba(255,255,255,0.20) 100%
  );
}

/* RIGHT PANEL */
.right{
  padding:40px 60px;
  overflow-y:auto;
  height:100%;
}

.right::-webkit-scrollbar{
  width:6px;
}

.right::-webkit-scrollbar-thumb{
  background:rgba(255,215,0,0.35);
  border-radius:10px;
}

h1{
  font-size:42px;
  margin-bottom:20px;
  color:#111;
}

/* INPUTS */
.input-group{
  display:flex;
  gap:20px;
  margin-bottom:20px;
}

.input{
  flex:1;
}

.input label{
  font-size:12px;
  color:#777;
}

.input input{
  width:100%;
  padding:12px;
  margin-top:6px;
  border-radius:10px;
  border:1px solid rgba(255,215,0,.15);
  background:#fff;
  color:#222;
}

/* SERVICES */
.services{
  margin-top:20px;
  display:flex;
  flex-direction:column;
  gap:12px;
}

.service{
  display:flex;
  justify-content:space-between;
  align-items:center;
  padding:14px 18px;
  border-radius:14px;
  background:#fff;
  border:1px solid rgba(255,215,0,.12);
  cursor:pointer;
  transition:.3s;
  color:#222;
  box-shadow:0 4px 12px rgba(0,0,0,.04);
}

.service:hover{
  border-color:rgba(255,215,0,.35);
}

.service.active{
  background:linear-gradient(135deg,#fff7dc,#ffffff);
  border-color:#f3c547;
}

.checkbox{
  width:20px;
  height:20px;
  border:2px solid #f3c547;
  border-radius:6px;
  display:flex;
  align-items:center;
  justify-content:center;
}

.checkbox i{
  display:none;
  font-size:12px;
}

.service.active .checkbox i{
  display:block;
}

/* BUTTON */
.generate{
  margin-top:30px;
  width:100%;
  padding:14px;
  border:none;
  border-radius:14px;
  font-weight:bold;
  font-size:16px;
  cursor:pointer;
  background:linear-gradient(135deg,#fff2ab,#f3c547,#c99208);
  color:#111;
}

.generate:hover{
  transform:translateY(-2px);
  box-shadow:0 10px 20px rgba(243,197,71,.25);
}

/* RESULT BOX */
.result{
  margin-top:25px;
  padding:20px;
  border-radius:16px;
  background:#fff;
  border:1px solid rgba(255,215,0,.18);
  display:none;
  color:#222;
  box-shadow:0 6px 18px rgba(0,0,0,.05);
}

.result h3{
  margin-bottom:10px;
  color:#f3c547;
}
</style>
</head>
<body>

<div class="navbar">
  <div class="logo-text">EventIntel</div>

  <div class="nav-links">
    <button onclick="window.location.href='homepage.php'">Home</button>
        <button class="active" onclick="window.location.href='createevent.php'">Create Event</button>
        <button onclick="window.location.href='yourevents.php'">Your Events</button>
    <div class="profile-btn" onclick="window.location.href='profile.php'">
      <i class="fa-regular fa-user"></i>
    </div>
  </div>
</div>

<div class="container">

  <!-- LEFT IMAGE -->
  <div class="left"></div>

  <!-- RIGHT PANEL -->
  <div class="right">

    <h1>Recommendation</h1>

    <div class="input-group">
      <div class="input">
        <label>ENTER BUDGET</label>
        <input type="number" id="budget" placeholder="35000">
      </div>

      <div class="input">
        <label>ENTER PAX</label>
        <input type="number" id="pax" placeholder="50">
      </div>
    </div>

    <div class="input">
      <label>ENTER YOUR EVENT</label>
      <input type="text" id="event" placeholder="Birthday">
    </div>

    <!-- SERVICES -->
    <div class="services" id="services">
      <div class="service">Clothes <div class="checkbox"><i class="fa-solid fa-check"></i></div></div>
      <div class="service">Foods/Catering <div class="checkbox"><i class="fa-solid fa-check"></i></div></div>
      <div class="service">Host <div class="checkbox"><i class="fa-solid fa-check"></i></div></div>
      <div class="service">Sounds & Lights <div class="checkbox"><i class="fa-solid fa-check"></i></div></div>
      <div class="service">Photographer <div class="checkbox"><i class="fa-solid fa-check"></i></div></div>
      <div class="service">Venue <div class="checkbox"><i class="fa-solid fa-check"></i></div></div>
      <div class="service">By Package <div class="checkbox"><i class="fa-solid fa-check"></i></div></div>
    </div>

    <button class="generate" onclick="generateRecommendation()">Generate Recommendation</button>

    <div class="result" id="result">
      <h3>Recommended Plan</h3>
      <p id="resultText"></p>
    </div>

  </div>

</div>

<script>
// toggle services
document.querySelectorAll('.service').forEach(item=>{
  item.addEventListener('click',()=>{
    item.classList.toggle('active');
  });
});

// generate logic
async function generateRecommendation(){
  const budget = document.getElementById('budget').value;
  const pax = document.getElementById('pax').value;
  const event = document.getElementById('event').value;
  const selected = [];
  document.querySelectorAll('.service.active').forEach(s=> selected.push(s.innerText.trim()));
  const resultBox = document.getElementById('result');
  const text = document.getElementById('resultText');
  text.innerHTML = 'Generating smart recommendation...';
  resultBox.style.display = 'block';
  const res = await fetch('../../api/ai_recommend.php', {
    method:'POST',
    headers:{'Content-Type':'application/json'},
    body: JSON.stringify({budget, pax, event, services:selected})
  });
  const data = await res.json();
  text.innerHTML = data.html;
}
</script>

</body>
</html>