<?php

namespace Tests\Feature;

use Database\Seeders\SiteContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PublicSiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(SiteContentSeeder::class);
    }

    /**
     * @return array<string, array{string, string, string}>
     */
    public static function pages(): array
    {
        return [
            'en home' => ['/', 'site/Home', 'en'],
            'en tents' => ['/tent-packages', 'site/Tents', 'en'],
            'en equipment' => ['/equipment', 'site/Equipment', 'en'],
            'en gallery' => ['/gallery', 'site/Gallery', 'en'],
            'en contact' => ['/contact', 'site/Contact', 'en'],
            'ms home' => ['/ms', 'site/Home', 'ms'],
            'ms tents' => ['/ms/pakej-khemah', 'site/Tents', 'ms'],
            'ms equipment' => ['/ms/peralatan', 'site/Equipment', 'ms'],
            'ms gallery' => ['/ms/galeri', 'site/Gallery', 'ms'],
            'ms contact' => ['/ms/hubungi', 'site/Contact', 'ms'],
        ];
    }

    #[DataProvider('pages')]
    public function test_public_pages_render_in_their_locale(string $url, string $component, string $locale): void
    {
        $this->get($url)
            ->assertOk()
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow')
            ->assertInertia(fn (Assert $page) => $page
                ->component($component)
                ->where('locale', $locale)
                ->where('translations', fn ($t) => ($t['nav.home'] ?? null) === ($locale === 'en' ? 'Home' : 'Utama'))
                ->has('site.alternates.en')
                ->has('site.alternates.ms')
                ->where('site.business.phone', '+60149576683')
                ->where('site.business.whatsapp', '60149576683')
                ->where('site.business.email', 'creativefactoryevents@gmail.com')
            );
    }

    public function test_language_alternates_point_at_the_same_page(): void
    {
        $this->get('/tent-packages')->assertInertia(fn (Assert $page) => $page
            ->where('site.key', 'tents')
            ->where('site.alternates.en.href', url('/tent-packages'))
            ->where('site.alternates.ms.href', url('/ms/pakej-khemah'))
        );
    }

    public function test_tent_packages_match_the_catalogue(): void
    {
        $this->get('/tent-packages')->assertInertia(fn (Assert $page) => $page
            ->has('packages', 24)
            ->where('packages.0.code', 'A')
            ->where('packages.0.price', 350)
            ->where('packages.0.category', 'arabian')
            ->where('packages.23.slug', 'block-clear-premium')
            ->where('packages.23.price', 3500)
            ->has('addOns', 19)
            ->where('addOns.0.arabian', 2.5)
            ->where('addOns.10.slug', 'fairy-patio-light')
            ->where('addOns.10.block', 300)
        );
    }

    public function test_content_is_translated(): void
    {
        $this->get('/equipment')->assertInertia(fn (Assert $page) => $page
            ->has('packages', 3)
            ->where('packages.0.price', null)
            ->where('packages.0.name', 'LED Package 1')
            ->has('extras', 3)
            ->where('extras.2.title', 'Mini Pelamin')
        );

        $this->get('/ms/pakej-khemah')->assertInertia(fn (Assert $page) => $page
            ->where('packages.0.name', 'Khemah dengan lampu & kipas')
            ->where('packages.0.features.1', 'Lampu bulb LED')
        );
    }

    public function test_home_shows_featured_packages_and_gallery(): void
    {
        $this->get('/')->assertInertia(fn (Assert $page) => $page
            ->has('events', 5)
            ->has('featured', 4)
            ->where('fromPrices.arabian', 350)
            ->where('fromPrices.block', 999)
            ->where('tentCount', 24)
            ->has('gallery', 8)
        );
    }

    public function test_gallery_is_localized(): void
    {
        $this->get('/ms/galeri')->assertInertia(fn (Assert $page) => $page
            ->has('items', count(config('gallery')))
            ->where('items.0.alt', config('gallery.0.alt.ms'))
            ->has('tags', 4)
        );
    }

    public function test_sitemap_lists_every_page_in_both_languages(): void
    {
        $response = $this->get('/sitemap.xml')->assertOk();

        $this->assertStringContainsString('application/xml', $response->headers->get('Content-Type'));

        foreach (['/', '/tent-packages', '/equipment', '/gallery', '/contact', '/ms', '/ms/pakej-khemah', '/ms/peralatan', '/ms/galeri', '/ms/hubungi'] as $path) {
            $this->assertStringContainsString('<loc>'.url($path).'</loc>', $response->getContent());
        }
    }

    public function test_robots_blocks_crawlers_on_staging(): void
    {
        $this->get('/robots.txt')->assertOk()->assertSee('Disallow: /');
    }

    public function test_registration_is_closed(): void
    {
        config(['site.registration' => false]);

        $this->get('/register')->assertNotFound();
        $this->post('/register', [])->assertNotFound();
    }
}
