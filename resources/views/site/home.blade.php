<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $metaTitle ?? ($settings['app_name'] ?? 'AQ Digital & IT Services') }}</title>
  <meta name="description" content="{{ $metaDescription ?? ($settings['app_description'] ?? 'Your trusted partner for innovative digital solutions.') }}">
  @if(!empty($metaKeywords))
  <meta name="keywords" content="{{ $metaKeywords }}">@endif
  <link rel="canonical" href="{{ request()->url() }}">
  <meta property="og:title" content="{{ $metaTitle ?? ($settings['app_name'] ?? 'AQ Digital & IT Services') }}">
  <meta property="og:description" content="{{ $metaDescription ?? ($settings['app_description'] ?? 'Your trusted partner for innovative digital solutions.') }}">
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ request()->url() }}">
  <meta property="og:site_name" content="{{ $settings['app_name'] ?? 'AQ Digital & IT Services' }}">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="robots" content="index, follow">
  @if(!empty($settings['app_favicon']))
  <link rel="icon" href="{{ asset($settings['app_favicon']) }}" sizes="any">
  @else
  <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
  <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
  @endif

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body>

  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="#">
        @if(!empty($settings['app_logo']))
        <img src="{{ asset($settings['app_logo']) }}" alt="{{ $settings['app_name'] ?? 'AQ Digital' }}" style="height:38px;max-width:180px;object-fit:contain">
        @else
        <span class="brand-logo">AQ</span>
        <span class="brand-text">{{ $settings['app_name'] ?? 'AQ Digital' }}</span>
        @endif
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-center">
          <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
          <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
          <li class="nav-item"><a class="nav-link" href="#portfolio">Portfolio</a></li>
          <li class="nav-item"><a class="nav-link" href="#testimonials">Testimonials</a></li>
          <li class="nav-item"><a class="nav-link" href="#blogs">Blogs</a></li>
          <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
          <li class="nav-item ms-3"><a href="#contact" class="btn btn-primary-custom">Get Started</a></li>
        </ul>
      </div>
    </div>
  </nav>

  {{-- Legacy hero backup saved in: resources/views/site/partials/hero-legacy.blade.php --}}
  @include('site.partials.hero-carousel')

  <section class="about-section section-padding" id="about">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
        <h2>About {{ $settings['app_name'] ?? 'AQ Digital' }}</h2>
        <p>{{ $settings['app_description'] ?? 'Your trusted partner for innovative digital solutions' }}</p>
      </div>
      <div class="row align-items-center">
        <div class="col-lg-6" data-aos="fade-right">
          <div class="about-image">
            <img src="{{ asset('assets/about.svg') }}" alt="About Us" class="img-fluid">
            <div class="about-badge">
              <span class="badge-number">15+</span>
              <span class="badge-text">Years</span>
            </div>
          </div>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
          <div class="about-content">
            <h3>Building Digital Solutions That Matter</h3>
            <p class="lead">We transform ideas into powerful digital experiences through innovative technology and creative design.</p>

            <div class="about-features">
              <div class="feature-item">
                <i class="bi bi-check-circle-fill"></i>
                <span>Custom Web & Mobile Applications</span>
              </div>
              <div class="feature-item">
                <i class="bi bi-check-circle-fill"></i>
                <span>User-Centered Design & Branding</span>
              </div>
              <div class="feature-item">
                <i class="bi bi-check-circle-fill"></i>
                <span>Digital Marketing Strategies</span>
              </div>
              <div class="feature-item">
                <i class="bi bi-check-circle-fill"></i>
                <span>Cloud Solutions & DevOps</span>
              </div>
            </div>

            <div class="about-stats">
              <div class="stat-item">
                <h4>500+</h4>
                <p>Happy Clients</p>
              </div>
              <div class="stat-item">
                <h4>1200+</h4>
                <p>Projects Done</p>
              </div>
              <div class="stat-item">
                <h4>50+</h4>
                <p>Awards Won</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="services-section section-padding" id="services">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
        <h2>Our Services</h2>
        <p>Comprehensive IT solutions tailored to your business needs</p>
      </div>
      <div class="row g-4">
        @forelse($services as $service)
        <div class="col-lg-4 col-md-6" data-aos="fade-up">
          <div class="service-card h-100">
            @if($service->featured_image)
            <img src="{{ asset($service->featured_image) }}" alt="{{ $service->title }}" class="img-fluid rounded mb-3">
            @endif
            <div class="service-icon">
              <i class="{{ $service->icon_class ?: 'bi bi-stars' }}"></i>
            </div>
            <h4>{{ $service->title }}</h4>
            <p>{{ \Illuminate\Support\Str::limit(strip_tags($service->content), 140) }}</p>
          </div>
        </div>
        @empty
        <div class="col-12 text-center">
          <p>No services added yet. Please add from admin panel.</p>
        </div>
        @endforelse
      </div>
    </div>
  </section>

  <section class="why-choose-section section-padding">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
        <h2>Why Choose Us</h2>
        <p>What makes us different from others</p>
      </div>
      <div class="row g-4">
        <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
          <div class="feature-box">
            <i class="bi bi-lightning-charge"></i>
            <h5>Fast Delivery</h5>
            <p>Quick turnaround times without compromising on quality</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
          <div class="feature-box">
            <i class="bi bi-shield-check"></i>
            <h5>Reliable & Secure</h5>
            <p>Top-notch security practices and reliable solutions</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="300">
          <div class="feature-box">
            <i class="bi bi-cash-coin"></i>
            <h5>Cost Effective</h5>
            <p>Competitive pricing with excellent value for money</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="400">
          <div class="feature-box">
            <i class="bi bi-headset"></i>
            <h5>24/7 Support</h5>
            <p>Round-the-clock support for all your needs</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="stats-section">
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-md-6 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="100">
          <div class="stat-item">
            <i class="bi bi-people"></i>
            <h3>500+</h3>
            <p>Happy Clients</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="200">
          <div class="stat-item">
            <i class="bi bi-folder"></i>
            <h3>1200+</h3>
            <p>Projects Completed</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="300">
          <div class="stat-item">
            <i class="bi bi-award"></i>
            <h3>15+</h3>
            <p>Years Experience</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="400">
          <div class="stat-item">
            <i class="bi bi-trophy"></i>
            <h3>50+</h3>
            <p>Awards Won</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="portfolio-section section-padding" id="portfolio">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
        <h2>Our Portfolio</h2>
        <p>Selected work that helped businesses launch, scale, and grow online.</p>
      </div>
      <div class="row g-4">
        @forelse($portfolios as $portfolio)
        <div class="col-lg-4 col-md-6" data-aos="fade-up">
          <article class="portfolio-card h-100">
            <div class="portfolio-card-image-wrap">
              <img src="{{ asset($portfolio->featured_image ?: 'assets/portfolio-1.svg') }}" alt="{{ $portfolio->title }}" class="portfolio-card-image">
              <div class="portfolio-card-chip">
                <i class="bi bi-layers"></i>
                <span>{{ $portfolio->category ?: 'Project' }}</span>
              </div>
            </div>
            <div class="portfolio-card-body">
              <h5>{{ $portfolio->title }}</h5>
              <p>{{ \Illuminate\Support\Str::limit(strip_tags($portfolio->description), 120) }}</p>
              <div class="portfolio-card-meta">
                <span><i class="bi bi-images"></i> {{ count($portfolio->gallery ?? []) + ($portfolio->featured_image ? 1 : 0) }} Images</span>
                @if($portfolio->project_url)
                <a href="{{ $portfolio->project_url }}" target="_blank" rel="noopener">
                  View Project <i class="bi bi-arrow-up-right"></i>
                </a>
                @endif
              </div>
            </div>
          </article>
        </div>
        @empty
        <div class="col-lg-4 col-md-6" data-aos="fade-up">
          <article class="portfolio-card h-100">
            <div class="portfolio-card-image-wrap">
              <img src="{{ asset('assets/portfolio-1.svg') }}" alt="E-commerce Platform" class="portfolio-card-image">
              <div class="portfolio-card-chip"><i class="bi bi-layers"></i><span>Web Development</span></div>
            </div>
            <div class="portfolio-card-body">
              <h5>E-commerce Platform</h5>
              <p>High-converting storefront with modern UX and scalable architecture.</p>
            </div>
          </article>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <article class="portfolio-card h-100">
            <div class="portfolio-card-image-wrap">
              <img src="{{ asset('assets/portfolio-2.svg') }}" alt="Mobile App" class="portfolio-card-image">
              <div class="portfolio-card-chip"><i class="bi bi-layers"></i><span>Mobile Development</span></div>
            </div>
            <div class="portfolio-card-body">
              <h5>Mobile Application</h5>
              <p>Fast, user-friendly cross-platform app with robust backend integration.</p>
            </div>
          </article>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <article class="portfolio-card h-100">
            <div class="portfolio-card-image-wrap">
              <img src="{{ asset('assets/portfolio-4.svg') }}" alt="Analytics Dashboard" class="portfolio-card-image">
              <div class="portfolio-card-chip"><i class="bi bi-layers"></i><span>UI/UX Design</span></div>
            </div>
            <div class="portfolio-card-body">
              <h5>Analytics Dashboard</h5>
              <p>Decision-first dashboard with clean data visuals for business teams.</p>
            </div>
          </article>
        </div>
        @endforelse
      </div>
    </div>
  </section>

  <section class="testimonial-section section-padding" id="testimonials">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
        <h2>What Our Clients Say</h2>
        <p>Don't just take our word for it - hear from our satisfied clients</p>
      </div>
      <div class="row g-4">
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="testimonial-card">
            <div class="testimonial-content">
              <div class="stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              </div>
              <p class="testimonial-text">AQ Digital transformed our online presence completely. Their team is professional, responsive, and delivers exceptional results. Highly recommended!</p>
              <div class="testimonial-author">
                <img src="https://ui-avatars.com/api/?name=John+Smith&background=6366f1&color=fff" alt="John Smith" class="author-image">
                <div class="author-info">
                  <h6>John Smith</h6>
                  <p>CEO, TechStart Inc.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="testimonial-card">
            <div class="testimonial-content">
              <div class="stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              </div>
              <p class="testimonial-text">Outstanding work on our mobile app! The team understood our vision perfectly and delivered beyond expectations. The app is fast, beautiful, and user-friendly.</p>
              <div class="testimonial-author">
                <img src="https://ui-avatars.com/api/?name=Sarah+Johnson&background=8b5cf6&color=fff" alt="Sarah Johnson" class="author-image">
                <div class="author-info">
                  <h6>Sarah Johnson</h6>
                  <p>Founder, HealthPlus</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="testimonial-card">
            <div class="testimonial-content">
              <div class="stars">
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
              </div>
              <p class="testimonial-text">Best decision we made was partnering with AQ Digital. Their expertise in digital marketing helped us triple our online revenue in just 6 months!</p>
              <div class="testimonial-author">
                <img src="https://ui-avatars.com/api/?name=Michael+Chen&background=6366f1&color=fff" alt="Michael Chen" class="author-image">
                <div class="author-info">
                  <h6>Michael Chen</h6>
                  <p>Marketing Director, ShopEase</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="services-section section-padding" id="blogs">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
        <h2>Latest Blogs</h2>
        <p>Read our latest insights, guides, and updates.</p>
      </div>
      <div class="row g-4">
        @forelse($blogs as $blog)
        <div class="col-lg-4 col-md-6" data-aos="fade-up">
          <div class="service-card h-100">
            @if($blog->featured_image)
            <img src="{{ asset($blog->featured_image) }}" alt="{{ $blog->title }}" class="img-fluid rounded mb-3">
            @endif
            <h4>{{ $blog->title }}</h4>
            <p>{{ \Illuminate\Support\Str::limit(strip_tags($blog->content), 140) }}</p>
            <a href="{{ route('blogs.show', $blog) }}" class="btn btn-primary-custom">Read Blog</a>
          </div>
        </div>
        @empty
        <div class="col-12 text-center">
          <p>No blogs published yet.</p>
        </div>
        @endforelse
      </div>
      <div class="text-center mt-4">
        <a href="{{ route('blogs.index') }}" class="btn btn-outline-light-custom">View All Blogs</a>
      </div>
    </div>
  </section>

  <section class="contact-section section-padding" id="contact">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
        <h2>Get In Touch</h2>
        <p>Let's discuss how we can help your business grow</p>
      </div>

      @if(session('success'))
      {{-- fallback for non-JS browsers --}}
      <div class="alert alert-success" id="contactFallbackAlert">{{ session('success') }}</div>
      @endif

      <div class="row">
        <div class="col-lg-5" data-aos="fade-right">
          <div class="contact-info">
            <h4>Contact Information</h4>
            <div class="contact-item">
              <i class="bi bi-geo-alt"></i>
              <div>
                <h6>Address</h6>
                <p>{{ $settings['contact_address'] ?? 'Please update address from admin settings.' }}</p>
              </div>
            </div>
            <div class="contact-item">
              <i class="bi bi-telephone"></i>
              <div>
                <h6>Phone</h6>
                <p>{{ $settings['contact_phone'] ?? 'N/A' }}</p>
              </div>
            </div>
            <div class="contact-item">
              <i class="bi bi-envelope"></i>
              <div>
                <h6>Email</h6>
                <p>{{ $settings['contact_email'] ?? 'N/A' }}</p>
              </div>
            </div>
            <div class="contact-item">
              <i class="bi bi-clock"></i>
              <div>
                <h6>Working Hours</h6>
                <p>Mon - Fri: 9:00 AM - 6:00 PM</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-7" data-aos="fade-left">
          <div class="contact-form">
            <h4>Send Us a Message</h4>
            <form id="contactForm" novalidate>
              @csrf
              <div class="row">
                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                </div>
                <div class="col-md-6">
                  <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                </div>
              </div>
              <input type="text" name="subject" class="form-control" placeholder="Subject" required>
              <textarea name="message" class="form-control" placeholder="Your Message" required></textarea>
              <button type="submit" class="btn btn-primary-custom w-100" id="contactSubmitBtn">
                <span id="contactBtnText">Send Message</span>
                <span id="contactBtnSpinner" class="d-none">
                  <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                  Sending&hellip;
                </span>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
          <h5>{{ $settings['app_name'] ?? 'AQ Digital & IT Services' }}</h5>
          <p class="text-secondary">{{ $settings['app_description'] ?? 'Your trusted partner in digital transformation. We deliver innovative IT solutions that drive business growth.' }}</p>
          <div class="social-links mt-3">
            <a href="#"><i class="bi bi-facebook"></i></a>
            <a href="#"><i class="bi bi-twitter"></i></a>
            <a href="#"><i class="bi bi-instagram"></i></a>
            <a href="#"><i class="bi bi-linkedin"></i></a>
            <a href="#"><i class="bi bi-youtube"></i></a>
          </div>
        </div>
        <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
          <h5>Quick Links</h5>
          <ul class="footer-links">
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About Us</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#portfolio">Portfolio</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
          <h5>Services</h5>
          <ul class="footer-links">
            @foreach($services->take(5) as $service)
            <li><a href="#services">{{ $service->title }}</a></li>
            @endforeach
          </ul>
        </div>
        <div class="col-lg-3 col-md-6">
          <h5>Newsletter</h5>
          <p class="text-secondary">Subscribe to get the latest news and updates.</p>
          <form class="mt-3" id="newsletterForm">
            <div class="input-group mb-3">
              <input type="email" class="form-control" placeholder="Your email" style="border-radius: 10px 0 0 10px; border: none; padding: 0.8rem;">
              <button class="btn btn-primary-custom" type="submit" style="border-radius: 0 10px 10px 0;">
                <i class="bi bi-send"></i>
              </button>
            </div>
          </form>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; {{ now()->year }} {{ $settings['app_name'] ?? 'AQ Digital & IT Services' }}. All rights reserved. | Designed with <i class="bi bi-heart-fill text-danger"></i> by AQ Digital</p>
      </div>
    </div>
  </footer>

  <div class="scroll-top" id="scrollTop"><i class="bi bi-arrow-up"></i></div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init({
      duration: 1000,
      once: true,
      offset: 100
    });

    window.addEventListener('scroll', function() {
      const navbar = document.querySelector('.navbar');
      const scrollTop = document.getElementById('scrollTop');

      if (window.scrollY > 50) navbar.classList.add('scrolled');
      else navbar.classList.remove('scrolled');

      if (window.scrollY > 300) scrollTop.classList.add('active');
      else scrollTop.classList.remove('active');
    });

    document.getElementById('scrollTop').addEventListener('click', function() {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (!target) return;
        const offset = 80;
        window.scrollTo({
          top: target.offsetTop - offset,
          behavior: 'smooth'
        });

        const navbarCollapse = document.querySelector('.navbar-collapse');
        if (navbarCollapse && navbarCollapse.classList.contains('show')) {
          navbarCollapse.classList.remove('show');
        }
      });
    });

    const newsletterForm = document.getElementById('newsletterForm');
    if (newsletterForm) {
      newsletterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Thank you for subscribing to our newsletter!');
        this.reset();
      });
    }

    const sections = document.querySelectorAll('section[id]');
    window.addEventListener('scroll', () => {
      let current = '';
      sections.forEach(section => {
        const sectionTop = section.offsetTop;
        if (scrollY >= (sectionTop - 120)) {
          current = section.getAttribute('id');
        }
      });

      document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === `#${current}`) {
          link.classList.add('active');
        }
      });
    });
  </script>

  {{-- Contact form AJAX --}}
  <script>
    (function() {
      // Hide fallback alert instantly if JS is available
      var fallback = document.getElementById('contactFallbackAlert');
      if (fallback) fallback.style.display = 'none';

      var form = document.getElementById('contactForm');
      var btnText = document.getElementById('contactBtnText');
      var btnSpinner = document.getElementById('contactBtnSpinner');
      var submitBtn = document.getElementById('contactSubmitBtn');

      // ---------- Toast helper ----------
      function showToast(type, message) {
        var existing = document.getElementById('contactToast');
        if (existing) existing.remove();

        var icons = {
          success: '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><circle cx="10" cy="10" r="10" fill="#22c55e"/><path d="M5.5 10.5l3 3 6-6" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
          error: '<svg width="20" height="20" viewBox="0 0 20 20" fill="none"><circle cx="10" cy="10" r="10" fill="#ef4444"/><path d="M7 7l6 6M13 7l-6 6" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>'
        };

        var toast = document.createElement('div');
        toast.id = 'contactToast';
        toast.className = 'contact-toast contact-toast--' + type;
        toast.innerHTML =
          '<span class="contact-toast__icon">' + icons[type] + '</span>' +
          '<span class="contact-toast__msg">' + message + '</span>' +
          '<button class="contact-toast__close" aria-label="Close">&times;</button>';

        document.body.appendChild(toast);

        // Trigger entrance
        requestAnimationFrame(function() {
          requestAnimationFrame(function() {
            toast.classList.add('contact-toast--in');
          });
        });

        function dismiss() {
          toast.classList.remove('contact-toast--in');
          toast.addEventListener('transitionend', function() {
            toast.remove();
          }, {
            once: true
          });
        }

        toast.querySelector('.contact-toast__close').addEventListener('click', dismiss);
        setTimeout(dismiss, 6000);
      }

      // ---------- Submit ----------
      form.addEventListener('submit', function(e) {
        e.preventDefault();

        if (!form.checkValidity()) {
          form.classList.add('was-validated');
          return;
        }

        // Loading state
        submitBtn.disabled = true;
        btnText.classList.add('d-none');
        btnSpinner.classList.remove('d-none');

        var formData = new FormData(form);

        fetch('{{ route("contact.store") }}', {
            method: 'POST',
            headers: {
              'Accept': 'application/json',
              'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
          })
          .then(function(res) {
            return res.json();
          })
          .then(function(data) {
            if (data.success) {
              showToast('success', data.message);
              form.reset();
              form.classList.remove('was-validated');
            } else {
              var msg = data.message || 'Something went wrong. Please try again.';
              if (data.errors) {
                msg = Object.values(data.errors).flat().join(' ');
              }
              showToast('error', msg);
            }
          })
          .catch(function() {
            showToast('error', 'Network error. Please check your connection and try again.');
          })
          .finally(function() {
            submitBtn.disabled = false;
            btnText.classList.remove('d-none');
            btnSpinner.classList.add('d-none');
          });
      });
    }());
  </script>
</body>

</html>