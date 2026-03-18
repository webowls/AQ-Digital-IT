<section class="hero-section" id="home">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6" data-aos="fade-right">
        <div class="hero-content">
          <span class="hero-eyebrow"><i class="bi bi-stars"></i> Digital Growth Partner</span>
          <h1>{{ $settings['landing_heading'] ?? 'Build Faster. Scale Smarter.' }}</h1>
          <p>{{ $settings['landing_subheading'] ?? 'Transform your vision into reality with expert IT services and innovative design.' }}</p>

          <div class="hero-trust d-flex flex-wrap gap-2 mb-4">
            <span><i class="bi bi-shield-check"></i> Trusted Delivery</span>
            <span><i class="bi bi-lightning-charge"></i> Rapid Execution</span>
            <span><i class="bi bi-graph-up-arrow"></i> ROI Focused</span>
          </div>

          <div class="d-flex gap-3 flex-wrap hero-cta-row">
            <a href="#contact" class="btn btn-light-custom"><i class="bi bi-rocket-takeoff"></i> Get Started</a>
            <a href="#services" class="btn btn-outline-light-custom"><i class="bi bi-grid"></i> Explore Services</a>
          </div>

          <div class="hero-stats">
            <div class="stat-item-hero">
              <h3>500+</h3>
              <p>Clients</p>
            </div>
            <div class="stat-item-hero">
              <h3>1.2K+</h3>
              <p>Projects</p>
            </div>
            <div class="stat-item-hero">
              <h3>15+</h3>
              <p>Years</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6" data-aos="fade-left">
        <div class="hero-image">
          <div class="hero-visual-card">
            <img src="{{ asset('assets/hero.svg') }}" alt="Developer Illustration" class="img-fluid" style="max-width: 100%; height: auto;">

            <div class="floating-badge badge-1">
              <i class="bi bi-code-slash"></i>
              <span>Web Dev</span>
            </div>
            <div class="floating-badge badge-2">
              <i class="bi bi-palette-fill"></i>
              <span>Design</span>
            </div>
            <div class="floating-badge badge-3">
              <i class="bi bi-phone"></i>
              <span>Mobile</span>
            </div>
            <div class="floating-badge badge-4">
              <i class="bi bi-lightning-charge-fill"></i>
              <span>Fast</span>
            </div>

            <div class="hero-metric-card metric-1">
              <small>Project Success</small>
              <strong>98%</strong>
            </div>
            <div class="hero-metric-card metric-2">
              <small>Avg. Delivery</small>
              <strong>14 Days</strong>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>