<section class="hero-carousel-fullwidth" id="home">
  @php
  $fallbackSvgs = [
  0 => asset('assets/hero.svg'),
  1 => asset('assets/portfolio-2.svg'),
  2 => asset('assets/portfolio-4.svg'),
  ];
  @endphp

  <div id="heroTechCarousel" class="carousel slide carousel-fade hero-tech-carousel-full" data-bs-ride="carousel" data-bs-interval="5000">

    <div class="carousel-inner">
      @forelse($heroSlides as $index => $slide)
      @php
      $illustrationSrc = $slide->illustration
      ? asset($slide->illustration)
      : ($fallbackSvgs[$index] ?? asset('assets/hero.svg'));
      @endphp
      <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
        <article class="hero-full-slide" style="background: {{ $slide->bg_gradient }}">

          {{-- Full-bleed background image --}}
          <img src="{{ $illustrationSrc }}" class="hero-slide-bg-image" alt="{{ $slide->tag }}">

          {{-- Dark overlay for text readability --}}
          <div class="hero-slide-overlay"></div>

          {{-- Text content --}}
          <div class="hero-slide-body container">
            <div class="row">
              <div class="col-lg-7 col-xl-6">
                <div class="hero-slide-tag">{{ $slide->tag }}</div>
                <div class="hero-slide-divider"></div>
                <h1 class="hero-slide-heading">{{ $slide->heading }}</h1>
                <p class="hero-slide-subtitle">{{ $slide->subtitle }}</p>
                <div class="hero-slide-actions">
                  <a href="#contact" class="btn btn-hero-primary">Start Your Project <i class="bi bi-arrow-right"></i></a>
                  <a href="#portfolio" class="btn btn-hero-ghost">View Our Work <i class="bi bi-arrow-right"></i></a>
                </div>
              </div>
            </div>
          </div>

        </article>
      </div>
      @empty
      <div class="carousel-item active">
        <article class="hero-full-slide" style="background: linear-gradient(135deg, #06091a 0%, #0d1130 50%, #151845 100%)">
          <img src="{{ asset('assets/hero.svg') }}" class="hero-slide-bg-image" alt="Hero">
          <div class="hero-slide-overlay"></div>
          <div class="hero-slide-body container">
            <div class="row">
              <div class="col-lg-7 col-xl-6">
                <div class="hero-slide-tag">Technology</div>
                <div class="hero-slide-divider"></div>
                <h1 class="hero-slide-heading">{{ $settings['landing_heading'] ?? 'Engineering Ideas Into Scalable Digital Products' }}</h1>
                <p class="hero-slide-subtitle">Your trusted partner for innovative digital solutions.</p>
                <div class="hero-slide-actions">
                  <a href="#contact" class="btn btn-hero-primary">Start Your Project <i class="bi bi-arrow-right"></i></a>
                  <a href="#portfolio" class="btn btn-hero-ghost">View Our Work <i class="bi bi-arrow-right"></i></a>
                </div>
              </div>
            </div>
          </div>
        </article>
      </div>
      @endforelse
    </div>

    @if($heroSlides->count() > 1)
    <div class="carousel-indicators hero-slide-dots">
      @foreach($heroSlides as $index => $slide)
      <button type="button" data-bs-target="#heroTechCarousel" data-bs-slide-to="{{ $index }}"
        class="{{ $index === 0 ? 'active' : '' }}" {{ $index === 0 ? 'aria-current=true' : '' }}
        aria-label="Slide {{ $index + 1 }}"></button>
      @endforeach
    </div>
    @endif

  </div>
</section>