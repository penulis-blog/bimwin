<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">

    <!-- Homepage -->
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ now()->toDateString() }}</lastmod>
        <priority>1.0</priority>
    </url>

    <!-- Artikel / Berita -->
    @foreach($posts as $post)
        <url>
            <loc>{{ url($post->pranala) }}</loc>
            <lastmod>{{ \Carbon\Carbon::parse($post->created_date)->toIso8601String() }}</lastmod>
            <priority>0.80</priority>
        </url>
    @endforeach

</urlset>