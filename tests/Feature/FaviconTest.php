<?php

namespace Tests\Feature;

use Tests\TestCase;

class FaviconTest extends TestCase
{
    public function test_head_declares_favicons_in_a_browser_friendly_order_without_duplicates(): void
    {
        $html = $this->get('/nl')->getContent();
        $head = substr($html, 0, strpos($html, '</head>'));

        $expected = [
            '<link rel="icon" type="image/x-icon" href="http://localhost/favicon.ico">',
            '<link rel="shortcut icon" href="http://localhost/favicon.ico">',
            '<link rel="icon" type="image/png" sizes="32x32" href="http://localhost/favicon-32x32.png">',
            '<link rel="icon" type="image/png" sizes="16x16" href="http://localhost/favicon-16x16.png">',
            '<link rel="apple-touch-icon" sizes="180x180" href="http://localhost/apple-touch-icon.png">',
            '<link rel="manifest" href="http://localhost/site.webmanifest">',
        ];

        $last = -1;
        foreach ($expected as $tag) {
            $pos = strpos($head, $tag);
            $this->assertNotFalse($pos, "Missing favicon tag: $tag");
            $this->assertSame(1, substr_count($head, $tag), "Duplicated favicon tag: $tag");
            $this->assertGreaterThan($last, $pos, "Favicon tag out of order: $tag");
            $last = $pos;
        }

        $this->assertSame(1, substr_count($head, 'rel="apple-touch-icon"'));
        $this->assertSame(1, substr_count($head, 'rel="manifest"'));
        $this->assertStringNotContainsString('favicon.ico?', $head, 'No cache-busting query strings on favicons');
    }

    public function test_favicon_assets_exist_and_ico_is_a_real_multi_size_icon(): void
    {
        foreach (['favicon.ico', 'favicon-16x16.png', 'favicon-32x32.png', 'favicon-192x192.png', 'favicon-512x512.png', 'apple-touch-icon.png', 'site.webmanifest'] as $file) {
            $this->assertFileExists(public_path($file));
        }

        $ico = file_get_contents(public_path('favicon.ico'));
        $this->assertSame("\x00\x00\x01\x00", substr($ico, 0, 4), 'favicon.ico must be a real ICO, not a renamed PNG');

        $count = unpack('v', substr($ico, 4, 2))[1];
        $sizes = [];
        for ($i = 0; $i < $count; $i++) {
            $entry = substr($ico, 6 + $i * 16, 16);
            $sizes[] = (ord($entry[0]) ?: 256) . 'x' . (ord($entry[1]) ?: 256);
        }
        foreach (['16x16', '32x32', '48x48'] as $size) {
            $this->assertContains($size, $sizes, "favicon.ico should embed a $size image");
        }

        [$w, $h] = getimagesize(public_path('apple-touch-icon.png'));
        $this->assertSame([180, 180], [$w, $h]);
    }

    public function test_manifest_points_to_existing_square_icons(): void
    {
        $manifest = json_decode(file_get_contents(public_path('site.webmanifest')), true);

        $this->assertSame('Van Malder Studio', $manifest['name']);
        $this->assertNotEmpty($manifest['short_name']);
        $this->assertNotEmpty($manifest['theme_color']);
        $this->assertNotEmpty($manifest['background_color']);
        $this->assertSame('standalone', $manifest['display']);

        $sizes = [];
        foreach ($manifest['icons'] as $icon) {
            $path = public_path(ltrim($icon['src'], '/'));
            $this->assertFileExists($path, "Manifest icon {$icon['src']} is missing");
            [$w, $h] = getimagesize($path);
            $this->assertSame($w, $h, "Manifest icon {$icon['src']} must be square");
            $this->assertSame("{$w}x{$h}", $icon['sizes']);
            $sizes[] = $icon['sizes'];
        }
        $this->assertContains('192x192', $sizes);
        $this->assertContains('512x512', $sizes);
    }

    public function test_robots_do_not_block_favicon_or_manifest(): void
    {
        $robots = $this->get('/robots.txt')->getContent();

        $this->assertStringNotContainsString('favicon', $robots);
        $this->assertStringNotContainsString('.png', $robots);
        $this->assertStringNotContainsString('webmanifest', $robots);
    }
}
