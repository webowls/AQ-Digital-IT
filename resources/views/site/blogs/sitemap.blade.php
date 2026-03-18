<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ route('home') }}</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>{{ route('blogs.index') }}</loc>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>
    @foreach($blogs as $blog)
    <url>
        <loc>{{ route('blogs.show', $blog) }}</loc>
        <lastmod>{{ optional($blog->updated_at)->toDateString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach
</urlset>
