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
  <meta property="og:type" content="article">
  <meta property="og:url" content="{{ request()->url() }}">
  @if($blog->featured_image)
  <meta property="og:image" content="{{ asset($blog->featured_image) }}">@endif
  <meta property="article:published_time" content="{{ optional($blog->published_at)->toIso8601String() }}">
  <meta name="twitter:card" content="summary_large_image">

  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BlogPosting",
      "headline": "{{ addslashes($blog->title) }}",
      "description": "{{ addslashes($metaDescription) }}",
      "datePublished": "{{ optional($blog->published_at)->toIso8601String() }}",
      "dateModified": "{{ optional($blog->updated_at)->toIso8601String() }}",
      "author": {
        "@type": "Organization",
        "name": "{{ addslashes($settings['app_name'] ?? 'AQ Digital') }}"
      },
      "publisher": {
        "@type": "Organization",
        "name": "{{ addslashes($settings['app_name'] ?? 'AQ Digital') }}"
      },
      "mainEntityOfPage": "{{ request()->url() }}"
    }
  </script>

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
          <li class="nav-item"><a class="nav-link" href="{{ route('blogs.index') }}">Blogs</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="section-padding" style="padding-top: 130px;">
    <div class="container">
      <a href="{{ route('blogs.index') }}" class="btn btn-outline-secondary btn-sm mb-3">&larr; Back to Blogs</a>

      <article class="card border-0 shadow-sm">
        <div class="card-body p-4 p-lg-5">
          <h1 class="mb-2">{{ $blog->title }}</h1>
          <p class="text-muted">{{ optional($blog->published_at)->format('d M Y') }}</p>

          @if($blog->featured_image)
          <img src="{{ asset($blog->featured_image) }}" alt="{{ $blog->title }}" class="img-fluid rounded mb-4">
          @endif

          <div>{!! $blog->content !!}</div>

          @if($blog->tagList())
          <div class="mt-4">
            <strong>Tags:</strong>
            @foreach($blog->tagList() as $tag)
            <span class="badge bg-secondary">{{ $tag }}</span>
            @endforeach
          </div>
          @endif

          @if(!empty($blog->gallery))
          <div class="row g-3 mt-4">
            @foreach($blog->gallery as $image)
            <div class="col-md-4">
              <img src="{{ asset($image) }}" alt="{{ $blog->title }} gallery image" class="img-fluid rounded">
            </div>
            @endforeach
          </div>
          @endif
        </div>
      </article>
    </div>
  </section>
</body>

</html>