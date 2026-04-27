// EventIntel shared supplier header
(function () {
  const mount = document.getElementById("header");
  if (!mount) return;

  mount.innerHTML = `
    <header class="main-header">
      <button class="header-menu-btn" type="button" aria-label="Toggle sidebar">
        <i class="fas fa-bars"></i>
      </button>

      <nav class="top-nav" aria-label="Main navigation">
        <button class="top-nav-btn" type="button" onclick="location.href='../html/Homepage.php'">Home</button>
        <button class="top-nav-btn" type="button" onclick="location.href='../html/createevent.php'">Create Event</button>
        <button class="top-nav-btn" type="button" onclick="location.href='../html/yourevents.php'">Your Events</button>
        <button class="top-profile-btn" type="button" aria-label="Profile" onclick="location.href='../html/profile.php'">
          <i class="fas fa-user"></i>
        </button>
      </nav>
    </header>
  `;

  const menuBtn = mount.querySelector(".header-menu-btn");
  menuBtn.addEventListener("click", function () {
    document.body.classList.toggle("sidebar-collapsed");
  });
})();
