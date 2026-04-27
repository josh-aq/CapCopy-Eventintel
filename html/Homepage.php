<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Symposium PHP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/homestyle.css">
</head>
<body>
    <header class="site-header">
        <div class="container header-inner">
            <a class="logo" href="#home">EVENTINTEL</a>
            <nav class="desktop-nav">
                                    <a href="#home">Homepage</a>
                                    <a href="#schedule">Suppliers</a>
                                    <a href="#speakers">Host</a>
                                    <a href="#highlights">Highlights</a>
                                    <a href="#contact">Contact</a>
                            </nav>
            <div class="header-actions">
                <a class="text-link" href="#">Sign In</a>
                <a class="btn btn-sm" href="#contact">Sign Up</a>
                <button class="menu-toggle" aria-label="Toggle menu">☰</button>
            </div>
        </div>
        <div class="mobile-menu">
                            <a href="#home">Homepage</a>
                            <a href="#schedule">Suppliers</a>
                            <a href="#speakers">Host</a>
                            <a href="#highlights">Highlights</a>
                            <a href="#contact">Contact</a>
                    </div>
    </header>

    <main>
        <section class="hero" id="home">
            <div class="container hero-grid">
                <div class="hero-copy">
                    <span class="eyebrow">First Event Planning Website</span>
                    <h1>EventIntel guides every decision</h1>
                    <p>We offer you a new generation of task and project management system. Plan, manage and track your next digital event with a premium Event experience.</p>
                    <div class="hero-actions">
                        <a class="btn" href="#pricing">Buy access pass</a>
                        <a class="btn btn-secondary" href="#schedule">Add to calendar</a>
                    </div>
                    <div class="rating-row">
                        <div class="mini-card">
                            <img src="https://images.unsplash.com/photo-1502685104226-ee32379fefbe?auto=format&fit=crop&w=200&q=80" alt="John Karter">
                            <div>
                                <strong>John Karter</strong>
                                <span>4.8 rating</span>
                            </div>
                        </div>
                        <div class="mini-card">
                            <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=200&q=80" alt="Mariya John">
                            <div>
                                <strong>Mariya John</strong>
                                <span>4.9 rating</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero-visual">
                    <div class="hero-photo main-photo"></div>
                    <div class="floating-gallery">
                        <div class="hero-photo small-photo one"></div>
                        <div class="hero-photo small-photo two"></div>
                        <div class="hero-photo small-photo three"></div>
                        <div class="hero-photo small-photo four"></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="intro section-pad">
            <div class="container split-section">
                <div>
                    <h2>Best Online and Offline Conferences</h2>
                    <p>Sometimes by accident, sometimes chunks as necessary making this the first true generator on the Internet. Recently with desktop publishing software like Aldus PageMaker, event design reached a whole new level.</p>
                    <a class="btn btn-secondary" href="#schedule">Upcoming conferences</a>
                </div>
                <div class="info-panel">
                    <div class="chip">Hybrid event</div>
                    <div class="chip">Live Q&amp;A</div>
                    <div class="chip">Networking</div>
                    <div class="chip">Workshops</div>
                </div>
            </div>
        </section>

        <section class="section-pad" id="speakers">
            <div class="container">
                <div class="section-heading">
                    <span class="eyebrow">Featured talent</span>
                    <h2>World Class Speakers</h2>
                </div>
                <div class="speakers-grid">
                                            <article class="speaker-card">
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&amp;fit=crop&amp;w=600&amp;q=80" alt="Darrell Steward">
                            <h3>Darrell Steward</h3>
                            <p>Product Design Lead</p>
                        </article>
                                            <article class="speaker-card">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&amp;fit=crop&amp;w=600&amp;q=80" alt="Mariya John">
                            <h3>Mariya John</h3>
                            <p>Experience Strategist</p>
                        </article>
                                            <article class="speaker-card">
                            <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&amp;fit=crop&amp;w=600&amp;q=80" alt="Jordan Miles">
                            <h3>Jordan Miles</h3>
                            <p>Growth Consultant</p>
                        </article>
                                            <article class="speaker-card">
                            <img src="https://images.unsplash.com/photo-1488426862026-3ee34a7d66df?auto=format&amp;fit=crop&amp;w=600&amp;q=80" alt="Ava Leon">
                            <h3>Ava Leon</h3>
                            <p>Creative Director</p>
                        </article>
                                            <article class="speaker-card">
                            <img src="https://images.unsplash.com/photo-1506277886164-e25aa3f4ef7f?auto=format&amp;fit=crop&amp;w=600&amp;q=80" alt="Chris Parker">
                            <h3>Chris Parker</h3>
                            <p>AI Product Architect</p>
                        </article>
                                    </div>
            </div>
        </section>

        <section class="ticket-banner section-pad" id="pricing">
            <div class="container ticket-grid">
                <div>
                    <span class="eyebrow">Premium access</span>
                    <h2>The Biggest Digital Event in 2024</h2>
                    <p>Sometimes by accident, sometimes chunks as necessary making this the first true generator on the Internet. Including versions of Lorem Ipsum made this style of event copy famous.</p>
                </div>
                <div class="price-card">
                    <h3>Ticket Prices</h3>
                    <div class="price-row">
                        <strong>$100</strong>
                        <span>Early birds</span>
                        <small>Until May 20, 2024</small>
                    </div>
                    <div class="price-row">
                        <strong>$150</strong>
                        <span>Late birds</span>
                        <small>After May 20, 2024</small>
                    </div>
                    <a class="btn" href="#contact">Book ticket</a>
                </div>
            </div>
        </section>

        <section class="highlights section-pad" id="highlights">
            <div class="container">
                <div class="section-heading center">
                    <span class="eyebrow">Previous year highlights</span>
                    <h2>Moments that moved the community</h2>
                    <p>Many variations of passages of Lorem Ipsum available but the majority have suffered alteration in some form injected humour, or randomised words.</p>
                </div>
                <div class="stats-grid">
                                            <div class="stat-card">
                            <strong>10k+</strong>
                            <span>Ticket confirmed</span>
                        </div>
                                            <div class="stat-card">
                            <strong>16</strong>
                            <span>Partners</span>
                        </div>
                                            <div class="stat-card">
                            <strong>150k+</strong>
                            <span>Participants</span>
                        </div>
                                    </div>
                <div class="gallery-grid">
                    <div class="gallery-item tall"></div>
                    <div class="gallery-item"></div>
                    <div class="gallery-item"></div>
                    <div class="gallery-item wide"></div>
                    <div class="gallery-item"></div>
                </div>
            </div>
        </section>

        <section class="section-pad" id="schedule">
            <div class="container">
                <div class="section-heading">
                    <span class="eyebrow">Agenda</span>
                    <h2>Upcoming Conference</h2>
                </div>
                <div class="schedule-list">
                                            <article class="schedule-card">
                            <div class="schedule-date">
                                <strong>16</strong>
                                <span>JUN 2024</span>
                            </div>
                            <div class="schedule-copy">
                                <h3>The Conference Construct Millennial</h3>
                                <p>Speech by Reena John &amp; Lorance</p>
                            </div>
                            <a class="btn btn-secondary" href="#contact">Book Ticket</a>
                        </article>
                                            <article class="schedule-card">
                            <div class="schedule-date">
                                <strong>18</strong>
                                <span>FEB 2024</span>
                            </div>
                            <div class="schedule-copy">
                                <h3>Local Business Global Event</h3>
                                <p>Speech by Martin Luthar</p>
                            </div>
                            <a class="btn btn-secondary" href="#contact">Book Ticket</a>
                        </article>
                                            <article class="schedule-card">
                            <div class="schedule-date">
                                <strong>19</strong>
                                <span>APR 2024</span>
                            </div>
                            <div class="schedule-copy">
                                <h3>Design Systems for Human Teams</h3>
                                <p>Speech by Ava Leon</p>
                            </div>
                            <a class="btn btn-secondary" href="#contact">Book Ticket</a>
                        </article>
                                            <article class="schedule-card">
                            <div class="schedule-date">
                                <strong>20</strong>
                                <span>MAY 2024</span>
                            </div>
                            <div class="schedule-copy">
                                <h3>The Future of Collaborative UX</h3>
                                <p>Speech by Mariya John</p>
                            </div>
                            <a class="btn btn-secondary" href="#contact">Book Ticket</a>
                        </article>
                                    </div>
            </div>
        </section>

        <section class="testimonials section-pad">
            <div class="container">
                <div class="section-heading center">
                    <span class="eyebrow">Reviews</span>
                    <h2>What Our Attendees Say</h2>
                </div>
                <div class="testimonial-slider" data-slider>
                                            <article class="testimonial-card active">
                            <p>“My busy schedule leaves little time for content and community building. This event helped me reconnect with both in a practical way.”</p>
                            <strong>Jordhan Daniyel</strong>
                        </article>
                                            <article class="testimonial-card">
                            <p>“The sessions were sharp, useful, and full of real examples. It felt modern without being overproduced.”</p>
                            <strong>Nadia Pearson</strong>
                        </article>
                                            <article class="testimonial-card">
                            <p>“From speakers to production quality, every part of the conference felt thoughtful and premium.”</p>
                            <strong>Martin Cook</strong>
                        </article>
                                    </div>
                <div class="slider-controls">
                    <button type="button" data-prev>Previous</button>
                    <button type="button" data-next>Next</button>
                </div>
            </div>
        </section>

        <section class="cta section-pad" id="contact">
            <div class="container cta-box">
                <div>
                    <h2>Become a Part of the Digital Evolution!</h2>
                    <p>Join thousands of attendees, creators, and operators in one modern event experience.</p>
                </div>
                <a class="btn" href="mailto:hello@example.com">Book ticket</a>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div class="container footer-grid">
            <div>
                <a class="logo" href="#home">Symposium</a>
                <p>Modern conference landing page rebuilt in PHP, HTML, CSS, and JavaScript.</p>
            </div>
            <div class="footer-links">
                <a href="#home">Home</a>
                <a href="#speakers">Speakers</a>
                <a href="#schedule">Schedule</a>
                <a href="#highlights">About</a>
                <a href="#contact">Sponsors</a>
            </div>
            <form class="newsletter">
                <label for="newsletter-email">Subscribe Newsletter</label>
                <div>
                    <input id="newsletter-email" type="email" placeholder="Email address">
                    <button type="submit">Subscribe</button>
                </div>
            </form>
        </div>
    </footer>

    <script src="js/script.js"></script>
</body>
</html>
