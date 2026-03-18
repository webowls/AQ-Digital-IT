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
        <span class="brand-logo">AQ</span>
        <span class="brand-text">{{ $settings['app_name'] ?? 'AQ Digital' }}</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-center">
          <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
          <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
          <li class="nav-item"><a class="nav-link" href="#blogs">Blogs</a></li>
          <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
          <li class="nav-item ms-3"><a href="#contact" class="btn btn-primary-custom">Get Started</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="hero-section" id="home">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6" data-aos="fade-right">
          <div class="hero-content">
            <h1>{{ $settings['landing_heading'] ?? 'Your Digital Partner' }}</h1>
            <p>{{ $settings['landing_subheading'] ?? 'Transform your vision into reality with expert IT services and innovative design.' }}</p>
            <div class="d-flex gap-3 flex-wrap">
              <a href="#contact" class="btn btn-light-custom"><i class="bi bi-rocket-takeoff"></i> Get Started</a>
              <a href="#contact" class="btn btn-outline-light-custom"><i class="bi bi-envelope"></i> Contact</a>
            </div>
          </div>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
          <div class="hero-image text-center">
            <img src="{{ asset('assets/hero.svg') }}" alt="Developer Illustration" class="img-fluid" style="max-width: 100%; height: auto;">
          </div>
        </div>
      </div>
    </div>
  </section>

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
          </div>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
          <div class="about-content">
            <h3>Building Digital Solutions That Matter</h3>
            <p class="lead">We transform ideas into powerful digital experiences through innovative technology and creative design.</p>
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
      <div class="alert alert-success">{{ session('success') }}</div>
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
          </div>
        </div>
        <div class="col-lg-7" data-aos="fade-left">
          <div class="contact-form">
            <h4>Send Us a Message</h4>
            <form method="POST" action="{{ route('contact.store') }}">
              @csrf
              <div class="row">
                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Your Name" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-6">
                  <input type="email" name="email" class="form-control" placeholder="Your Email" value="{{ old('email') }}" required>
                </div>
              </div>
              <input type="text" name="subject" class="form-control" placeholder="Subject" value="{{ old('subject') }}" required>
              <textarea name="message" class="form-control" placeholder="Your Message" required>{{ old('message') }}</textarea>
              <button type="submit" class="btn btn-primary-custom w-100">Send Message</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="footer">
    <div class="container">
      <div class="footer-bottom">
        <p>&copy; {{ now()->year }} {{ $settings['app_name'] ?? 'AQ Digital & IT Services' }}. All rights reserved.</p>
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
      });
    });
  </script>
</body>

</html>