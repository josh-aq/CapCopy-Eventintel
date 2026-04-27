const toggle = document.querySelector('.menu-toggle');
const mobileMenu = document.querySelector('.mobile-menu');

if (toggle && mobileMenu) {
  toggle.addEventListener('click', () => {
    mobileMenu.classList.toggle('open');
  });
}

const slides = Array.from(document.querySelectorAll('.testimonial-card'));
const nextBtn = document.querySelector('[data-next]');
const prevBtn = document.querySelector('[data-prev]');
let current = 0;

function showSlide(index) {
  if (!slides.length) return;
  slides.forEach((slide, i) => {
    slide.classList.toggle('active', i === index);
  });
}

if (slides.length) {
  nextBtn?.addEventListener('click', () => {
    current = (current + 1) % slides.length;
    showSlide(current);
  });

  prevBtn?.addEventListener('click', () => {
    current = (current - 1 + slides.length) % slides.length;
    showSlide(current);
  });

  setInterval(() => {
    current = (current + 1) % slides.length;
    showSlide(current);
  }, 5000);
}
