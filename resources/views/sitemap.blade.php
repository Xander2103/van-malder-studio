<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml">
    @foreach($routes as $route)
    <url>
        <loc>{{ $route['url'] }}</loc>
        <changefreq>{{ $route['freq'] }}</changefreq>
        <priority>{{ $route['priority'] }}</priority>
        @if(!empty($route['alternates']))
        @foreach($route['alternates'] as $lang => $altUrl)
        <xhtml:link rel="alternate" hreflang="{{ $lang }}" href="{{ $altUrl }}"/>
        @endforeach
        @endif
    </url>
    @endforeach
</urlset>
