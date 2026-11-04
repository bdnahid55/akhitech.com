{!! '<'.'?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ($staticUrls as $url)
    <url>
        <loc>{{ $url }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>{{ $url === route('home') ? '1.0' : '0.8' }}</priority>
    </url>
@endforeach
@foreach ($pages as $p)
    <url>
        <loc>{{ route('page.show', $p->slug) }}</loc>
        <lastmod>{{ $p->updated_at ? $p->updated_at->format('Y-m-d') : date('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
@endforeach
@if (isset($portfolios))
@foreach ($portfolios as $port)
    <url>
        <loc>{{ route('portfolio.show', $port->slug) }}</loc>
        <lastmod>{{ $port->updated_at ? $port->updated_at->format('Y-m-d') : date('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
@endforeach
@endif
@if (isset($posts))
@foreach ($posts as $postItem)
    <url>
        <loc>{{ route('blog.show', $postItem->slug) }}</loc>
        <lastmod>{{ $postItem->updated_at ? $postItem->updated_at->format('Y-m-d') : date('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
@endforeach
@endif
</urlset>
