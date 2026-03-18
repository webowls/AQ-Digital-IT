<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $metaTitle }}</title>
  <meta name="description" content="{{ $metaDescription }}">
  @if(!empty($metaKeywords))
  <meta name="keywords" content="{{ $metaKeywords }}">@endif
  <link rel="canonical" href="{{ request()->url() }}">
  <meta property="og:title" content="{{ $metaTitle }}">
  <meta property="og:description" content="{{ $metaDescription }}">
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ request()->url() }}">
  <meta property="og:site_name" content="{{ $settings['app_name'] ?? 'AQ Digital' }}">
  <meta name="twitter:card" content="summary_large_image">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body>
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
        <span class="brand-logo">AQ</span>
        <span class="brand-text">{{ $settings['app_name'] ?? 'AQ Digital' }}</span>
      </a>
      <div class="collapse navbar-collapse justify-content-end show">
        <ul class="navbar-nav align-items-center">
          <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
          <li class="nav-item"><a class="nav-link active" href="{{ route('blogs.index') }}">Blogs</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="section-padding" style="padding-top: 130px;">
    <div class="container">
      <div class="section-title mb-4">
        <h2>Latest Blogs</h2>
        <p>Insights, updates and useful resources from our team.</p>
      </div>

      <div class="row g-4">
        @forelse($blogs as $blog)
        <div class="col-lg-4 col-md-6">
          <div class="service-card h-100">
            @if($blog->featured_image)
            <img src="{{ asset($blog->featured_image) }}" class="img-fluid rounded mb-3" alt="{{ $blog->title }}">
            @endif
            <h5 class="mb-2">{{ $blog->title }}</h5>
            <p class="mb-3">{{ \Illuminate\Support\Str::limit(strip_tags($blog->content), 130) }}</p>
            <a href="{{ route('blogs.show', $blog) }}" class="btn btn-primary-custom">Read More</a>
          </div>
        </div>
        @empty
        <div class="col-12 text-center">
          <p>No blogs available right now.</p>
        </div>
        @endforelse
      </div>

      <div class="mt-4">{{ $blogs->links() }}</div>
    </div>
  </section>
</body>

</html>