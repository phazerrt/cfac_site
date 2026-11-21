<?php

namespace Database\Seeders;

use App\Models\AddOn;
use App\Models\Package;
use App\Models\Service;
use Illuminate\Database\Seeder;

/**
 * Public-site content from the Creative Factory 2026 catalogue
 * (CF_CATALOGUE_2026-ogos.pdf). Prices and inclusions are copied as
 * published; the wording is tidied into English and Malay.
 * Safe to re-run: rows are upserted by slug.
 */
class SiteContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->packages();
        $this->addOns();
        $this->services();
    }

    /**
     * Build a feature list from [en, ms] pairs (stored one item per line).
     *
     * @param  list<array{string, string}>  $items
     * @return array{en: string, ms: string}
     */
    private function features(array $items): array
    {
        return [
            'en' => implode("\n", array_column($items, 0)),
            'ms' => implode("\n", array_column($items, 1)),
        ];
    }

    private function packages(): void
    {
        // Shared inclusions, as [English, Malay].
        $led = ['LED bulb lighting', 'Lampu bulb LED'];
        $fan = ['Ceiling fan', 'Kipas siling'];
        $scallop = ['2-layer scallop', 'Scalop 2 lapis'];
        $pillar = ['Pillar wrap', 'Lapis tiang'];
        $buffet = ['Free 1 buffet table', 'Percuma 1 meja bufet'];
        $buffetCover = ['Free 1 buffet table with cover', 'Percuma 1 meja bufet berlapis'];
        $buffet2 = ['Free 2 buffet tables', 'Percuma 2 meja bufet'];
        $fans2 = ['2 stand fans / wall fans', '2 unit kipas berdiri / kipas dinding'];
        $highbay = ['Highbay lighting', 'Lampu highbay'];
        $noTables = ['Tables & chairs not included', 'Meja & kerusi tidak termasuk'];

        $arabian = "20' × 20'";
        $block = "20' × 40'";

        $packages = [
            // ---- Arabian white: basic (catalogue p.2) ----
            [
                'slug' => 'arabian-white-a', 'category' => 'arabian', 'finish' => 'white', 'tier' => 'basic', 'code' => 'A',
                'size' => $arabian, 'price' => 350, 'image' => 'media/pkg/arabian-white-a.webp',
                'name' => ['en' => 'Tent with lights & fan', 'ms' => 'Khemah dengan lampu & kipas'],
                'features' => [['1 Arabian white tent', '1 khemah Arabian putih'], $led, $fan],
                'note' => $noTables,
            ],
            [
                'slug' => 'arabian-white-b', 'category' => 'arabian', 'finish' => 'white', 'tier' => 'basic', 'code' => 'B',
                'size' => $arabian, 'price' => 450, 'image' => 'media/pkg/arabian-white-b.webp',
                'name' => ['en' => 'Tent + 70 chairs', 'ms' => 'Khemah + 70 kerusi'],
                'features' => [$led, $fan, ['70 plastic chairs (no cover)', '70 unit kerusi plastik (kosong)'], $buffet],
            ],
            [
                'slug' => 'arabian-white-c', 'category' => 'arabian', 'finish' => 'white', 'tier' => 'basic', 'code' => 'C',
                'size' => $arabian, 'price' => 650, 'image' => 'media/pkg/arabian-white-c.webp',
                'name' => ['en' => 'Tent + 4 tables & 40 covered chairs', 'ms' => 'Khemah + 4 meja & 40 kerusi bersarung'],
                'features' => [$led, $fan, ['4 round tables with cover', '4 unit meja bulat berlapis'], ['40 plastic chairs with cover', '40 unit kerusi plastik bersarung'], $buffet],
            ],

            // ---- Arabian white: deco (p.3) ----
            [
                'slug' => 'arabian-white-d', 'category' => 'arabian', 'finish' => 'white', 'tier' => 'deco', 'code' => 'D',
                'size' => $arabian, 'price' => 450, 'image' => 'media/pkg/arabian-white-d.webp',
                'name' => ['en' => 'Decorated tent', 'ms' => 'Khemah berhias'],
                'features' => [$scallop, $pillar, $led, $fan],
                'note' => $noTables,
            ],
            [
                'slug' => 'arabian-white-e', 'category' => 'arabian', 'finish' => 'white', 'tier' => 'deco', 'code' => 'E',
                'size' => $arabian, 'price' => 700, 'image' => 'media/pkg/arabian-white-e.webp',
                'name' => ['en' => 'Decorated tent + 4 tables & 40 chairs', 'ms' => 'Khemah berhias + 4 meja & 40 kerusi'],
                'features' => [$scallop, $pillar, $led, $fan, ['4 round / oblong tables with cover + topping', '4 unit meja bulat / panjang berlapis + lapik atas'], ['40 plastic chairs (no cover)', '40 unit kerusi plastik (kosong)'], $buffetCover],
            ],
            [
                'slug' => 'arabian-white-f', 'category' => 'arabian', 'finish' => 'white', 'tier' => 'deco', 'code' => 'F',
                'size' => $arabian, 'price' => 750, 'image' => 'media/pkg/arabian-white-f.webp',
                'name' => ['en' => 'Decorated tent + 4 tables & 40 covered chairs', 'ms' => 'Khemah berhias + 4 meja & 40 kerusi bersarung'],
                'features' => [$scallop, $pillar, $led, $fan, ['4 round / oblong tables with cover + topping', '4 unit meja bulat / panjang berlapis + lapik atas'], ['40 plastic chairs with cover', '40 unit kerusi plastik bersarung'], $buffetCover],
            ],

            // ---- Arabian white: premium (p.4) ----
            [
                'slug' => 'arabian-white-premium', 'category' => 'arabian', 'finish' => 'white', 'tier' => 'premium', 'code' => null,
                'size' => $arabian, 'price' => 900, 'image' => 'media/pkg/arabian-white-premium.webp', 'is_featured' => true,
                'gallery' => ['media/pkg/underlayer-chandelier.webp', 'media/pkg/arabian-white-premium-2.webp', 'media/pkg/arabian-white-premium-3.webp'],
                'name' => ['en' => 'Premium Arabian White', 'ms' => 'Arabian Putih Premium'],
                'features' => [
                    ['1 Arabian white tent', '1 unit khemah Arabian putih'],
                    ['Ceiling underlayer & chandelier', 'Hiasan siling & chandelier'],
                    ['2-layer scallop, pillar wrap & curtain deco', 'Scalop 2 lapis, lapis tiang & tirai hiasan'],
                    ['LED bulb lighting & ceiling fan', 'Lampu bulb LED & kipas siling'],
                    ['4 round / oblong tables with cover + topping', '4 unit meja bulat / panjang berlapis + lapik atas'],
                    ['40 plastic chairs with cover & ribbon', '40 unit kerusi plastik bersarung + reben'],
                    ['1 stand fan / wall fan', '1 kipas berdiri / kipas dinding'],
                    $buffetCover,
                ],
                'note' => ['Add-ons per tent: patio curtain RM100 · fairy & patio light RM200', 'Tambahan setiap khemah: tirai patio RM100 · lampu fairy & patio RM200'],
            ],

            // ---- Arabian transparent: basic (p.5) ----
            [
                'slug' => 'arabian-clear-g', 'category' => 'arabian', 'finish' => 'clear', 'tier' => 'basic', 'code' => 'G',
                'size' => $arabian, 'price' => 599, 'image' => 'media/pkg/arabian-clear-g.webp',
                'name' => ['en' => 'Transparent tent with lights & fan', 'ms' => 'Khemah transparan dengan lampu & kipas'],
                'features' => [['1 Arabian transparent tent', '1 khemah Arabian transparan'], $led, $fan],
                'note' => ['No scallop or deco. Tables & chairs not included', 'Tanpa scalop atau hiasan. Meja & kerusi tidak termasuk'],
            ],
            [
                'slug' => 'arabian-clear-h', 'category' => 'arabian', 'finish' => 'clear', 'tier' => 'basic', 'code' => 'H',
                'size' => $arabian, 'price' => 899, 'image' => 'media/pkg/arabian-clear-h.webp',
                'name' => ['en' => 'Transparent tent + 4 tables & 40 chairs', 'ms' => 'Khemah transparan + 4 meja & 40 kerusi'],
                'features' => [$led, $fan, ['4 round tables with cover', '4 unit meja bulat berlapis'], ['40 plastic chairs (no cover)', '40 unit kerusi plastik (kosong)'], $buffet],
            ],
            [
                'slug' => 'arabian-clear-i', 'category' => 'arabian', 'finish' => 'clear', 'tier' => 'basic', 'code' => 'I',
                'size' => $arabian, 'price' => 999, 'image' => 'media/pkg/arabian-clear-i.webp',
                'name' => ['en' => 'Transparent tent + 4 tables & 40 covered chairs', 'ms' => 'Khemah transparan + 4 meja & 40 kerusi bersarung'],
                'features' => [$led, $fan, ['4 round tables with cover', '4 unit meja bulat berlapis'], ['40 plastic chairs with cover', '40 unit kerusi plastik bersarung'], $buffet],
            ],

            // ---- Arabian transparent: deco (p.6) ----
            [
                'slug' => 'arabian-clear-j', 'category' => 'arabian', 'finish' => 'clear', 'tier' => 'deco', 'code' => 'J',
                'size' => $arabian, 'price' => 699, 'image' => 'media/pkg/arabian-clear-j.webp',
                'name' => ['en' => 'Decorated transparent tent', 'ms' => 'Khemah transparan berhias'],
                'features' => [$scallop, $pillar, $led, $fan],
                'note' => $noTables,
            ],
            [
                'slug' => 'arabian-clear-k', 'category' => 'arabian', 'finish' => 'clear', 'tier' => 'deco', 'code' => 'K',
                'size' => $arabian, 'price' => 1099, 'image' => 'media/pkg/arabian-clear-k.webp',
                'name' => ['en' => 'Decorated transparent + 4 tables & 40 chairs', 'ms' => 'Transparan berhias + 4 meja & 40 kerusi'],
                'features' => [$scallop, $pillar, $led, $fan, ['4 round tables with cover', '4 unit meja bulat berlapis'], ['40 plastic chairs (no cover)', '40 unit kerusi plastik (kosong)'], $buffet],
            ],
            [
                'slug' => 'arabian-clear-l', 'category' => 'arabian', 'finish' => 'clear', 'tier' => 'deco', 'code' => 'L',
                'size' => $arabian, 'price' => 1250, 'image' => 'media/pkg/arabian-clear-l.webp',
                'name' => ['en' => 'Decorated transparent + 4 tables & 40 covered chairs', 'ms' => 'Transparan berhias + 4 meja & 40 kerusi bersarung'],
                'features' => [$scallop, $pillar, $led, $fan, ['4 round tables with cover', '4 unit meja bulat berlapis'], ['40 plastic chairs with cover', '40 unit kerusi plastik bersarung'], $buffet],
            ],

            // ---- Arabian transparent: premium (p.7) ----
            [
                'slug' => 'arabian-clear-premium', 'category' => 'arabian', 'finish' => 'clear', 'tier' => 'premium', 'code' => null,
                'size' => $arabian, 'price' => 1499, 'image' => 'media/pkg/arabian-clear-premium.webp', 'is_featured' => true,
                'gallery' => ['media/pkg/arabian-clear-premium-3.webp', 'media/pkg/arabian-clear-premium-2.webp'],
                'name' => ['en' => 'Premium Arabian Transparent', 'ms' => 'Arabian Transparan Premium'],
                'features' => [
                    ['1 Arabian transparent tent', '1 unit khemah Arabian transparan'],
                    ['Fairy light & patio light', 'Lampu fairy & lampu patio'],
                    ['2-layer scallop, pillar wrap & curtain deco', 'Scalop 2 lapis, lapis tiang & tirai hiasan'],
                    ['4 round / long tables with cover', '4 unit meja bulat / panjang berlapis'],
                    ['40 plastic chairs with cover + ribbon', '40 unit kerusi plastik bersarung + reben'],
                    ['Chandelier', 'Chandelier'],
                    ['1 stand fan / wall fan', '1 kipas berdiri / kipas dinding'],
                    $buffetCover,
                ],
                'note' => ['Add-on: air cooler RM200', 'Tambahan: air cooler RM200'],
            ],

            // ---- Marquee block white (p.9–10) ----
            [
                'slug' => 'block-white-a', 'category' => 'block', 'finish' => 'white', 'tier' => 'basic', 'code' => 'A',
                'size' => $block, 'price' => 999, 'image' => 'media/pkg/block-white-a.webp',
                'name' => ['en' => 'Block tent with fans & highbay lights', 'ms' => 'Khemah blok dengan kipas & lampu highbay'],
                'features' => [['1 Marquee block white tent', '1 khemah marquee blok putih'], $fans2, $highbay],
            ],
            [
                'slug' => 'block-white-b', 'category' => 'block', 'finish' => 'white', 'tier' => 'deco', 'code' => 'B',
                'size' => $block, 'price' => 1099, 'image' => 'media/pkg/block-white-b.webp',
                'name' => ['en' => 'Decorated block tent', 'ms' => 'Khemah blok berhias'],
                'features' => [$fans2, $highbay, $scallop, $pillar, ['Ceiling underlayer', 'Lapis siling']],
            ],
            [
                'slug' => 'block-white-c', 'category' => 'block', 'finish' => 'white', 'tier' => 'deco', 'code' => 'C',
                'size' => $block, 'price' => 1399, 'image' => 'media/pkg/block-white-c.webp',
                'name' => ['en' => 'Decorated block + 8 tables & 80 chairs', 'ms' => 'Blok berhias + 8 meja & 80 kerusi'],
                'features' => [$fans2, $highbay, $scallop, $pillar, ['8 round / oblong tables (no cover)', '8 unit meja bulat / panjang (kosong)'], ['80 plastic chairs (no cover)', '80 kerusi plastik (kosong)'], $buffet2],
            ],
            [
                'slug' => 'block-white-d', 'category' => 'block', 'finish' => 'white', 'tier' => 'deco', 'code' => 'D',
                'size' => $block, 'price' => 1699, 'image' => 'media/pkg/block-white-d.webp',
                'name' => ['en' => 'Decorated block + 8 tables & 80 covered chairs', 'ms' => 'Blok berhias + 8 meja & 80 kerusi bersarung'],
                'features' => [$fans2, $highbay, $scallop, $pillar, ['8 round / oblong tables with cover + topping', '8 unit meja bulat / panjang berlapis'], ['80 plastic chairs with cover', '80 kerusi plastik bersarung'], $buffet2],
                'note' => ['Special combo: add underlay & chandelier for RM300', 'Kombo istimewa: tambah underlay & chandelier dengan RM300'],
            ],

            // ---- Premium block with stage (p.11) ----
            [
                'slug' => 'block-white-stage', 'category' => 'block', 'finish' => 'white', 'tier' => 'premium', 'code' => null,
                'size' => $block, 'price' => 2799, 'image' => 'media/pkg/block-white-stage.webp', 'is_featured' => true,
                'gallery' => ['media/pkg/block-white-stage-2.webp', 'media/pkg/block-white-stage-3.webp'],
                'name' => ['en' => 'Premium Block with Stage', 'ms' => 'Blok Premium dengan Pentas'],
                'features' => [
                    ['1 Marquee block white tent', '1 khemah blok putih'],
                    $highbay,
                    ['2-layer scallop, pillar wrap + curtain deco', 'Scalop 2 lapis, lapis tiang + tirai hiasan'],
                    ['Ceiling underlay', 'Hiasan siling (underlay)'],
                    ['1 cooler fan', '1 unit kipas penyejuk'],
                    ["Stage 24' × 12' × 2' (H)", "Pentas 24' × 12' × 2' (T)"],
                    ['Stage carpet', 'Karpet pentas'],
                    ['Stage skirting + stairs', 'Skirting pentas + tangga'],
                ],
                'note' => ['Add-on: air cooler RM200', 'Tambahan: air cooler RM200'],
            ],

            // ---- Marquee block transparent (p.12–13) ----
            [
                'slug' => 'block-clear-e', 'category' => 'block', 'finish' => 'clear', 'tier' => 'basic', 'code' => 'E',
                'size' => $block, 'price' => 1299, 'image' => 'media/pkg/block-clear-e.webp',
                'name' => ['en' => 'Transparent block with fans & highbay lights', 'ms' => 'Blok transparan dengan kipas & lampu highbay'],
                'features' => [['1 Transparent block tent', '1 khemah blok transparan'], $fans2, $highbay],
            ],
            [
                'slug' => 'block-clear-f', 'category' => 'block', 'finish' => 'clear', 'tier' => 'deco', 'code' => 'F',
                'size' => $block, 'price' => 1599, 'image' => 'media/pkg/block-clear-f.webp',
                'name' => ['en' => 'Decorated transparent block', 'ms' => 'Blok transparan berhias'],
                'features' => [$fans2, $highbay, $scallop, $pillar],
            ],
            [
                'slug' => 'block-clear-g', 'category' => 'block', 'finish' => 'clear', 'tier' => 'deco', 'code' => 'G',
                'size' => $block, 'price' => 1999, 'image' => 'media/pkg/block-clear-g.webp',
                'name' => ['en' => 'Decorated transparent + 8 tables & 80 chairs', 'ms' => 'Transparan berhias + 8 meja & 80 kerusi'],
                'features' => [$fans2, $highbay, $scallop, $pillar, ['8 round / oblong tables with cover', '8 unit meja bulat / panjang berlapis'], ['80 plastic chairs (no cover)', '80 kerusi plastik (kosong)'], $buffet2],
            ],
            [
                'slug' => 'block-clear-h', 'category' => 'block', 'finish' => 'clear', 'tier' => 'deco', 'code' => 'H',
                'size' => $block, 'price' => 2499, 'image' => 'media/pkg/block-clear-h.webp',
                'name' => ['en' => 'Decorated transparent + 8 tables & 80 covered chairs', 'ms' => 'Transparan berhias + 8 meja & 80 kerusi bersarung'],
                'features' => [$fans2, $highbay, $scallop, $pillar, ['8 round / oblong tables with cover', '8 unit meja bulat / panjang berlapis'], ['80 plastic chairs with cover + ribbon', '80 kerusi plastik bersarung + reben']],
                'note' => ['Limited time: free add-on of 1 chandelier', 'Masa terhad: percuma 1 chandelier'],
            ],

            // ---- Premium fairy block (p.14) ----
            [
                'slug' => 'block-clear-premium', 'category' => 'block', 'finish' => 'clear', 'tier' => 'premium', 'code' => null,
                'size' => $block, 'price' => 3500, 'image' => 'media/pkg/block-clear-premium.webp', 'is_featured' => true,
                'gallery' => ['media/pkg/block-clear-premium-2.webp', 'media/pkg/block-clear-premium-3.webp'],
                'name' => ['en' => 'Premium Fairy Block Transparent', 'ms' => 'Blok Transparan Fairy Premium'],
                'features' => [
                    ['1 Transparent block tent', '1 khemah blok transparan'],
                    $fans2,
                    ['2-layer scallop, pillar wrap & curtain deco', 'Scalop 2 lapis, lapis tiang & tirai hiasan'],
                    ['Fairy light & patio light', 'Lampu fairy & lampu patio'],
                    ['8 round / oblong tables with cover', '8 unit meja bulat / panjang berlapis'],
                    ['80 plastic chairs with cover', '80 kerusi plastik bersarung'],
                    ['Ceiling underlay & 1 chandelier', 'Hiasan siling & 1 unit chandelier'],
                ],
            ],

            // ---- LED screen, lighting & sound (p.17–19): quote on request ----
            [
                'slug' => 'av-package-1', 'category' => 'av', 'finish' => null, 'tier' => 'basic', 'code' => '1',
                'size' => '2 × 4 m', 'price' => null, 'image' => 'media/av/p1-led-screen.webp',
                'gallery' => ['media/av/p1-led-tent.webp'],
                'name' => ['en' => 'LED Package 1', 'ms' => 'Pakej LED 1'],
                'features' => [
                    ['Indoor LED screen P3, 2 m × 4 m (RM350 per m²)', 'Skrin LED dalaman P3, 2 m × 4 m (RM350 setiap m²)'],
                    ['Basic sound system: 2 speakers + karaoke', 'Sistem bunyi asas: 2 speaker + karaoke'],
                    ['Or sound + backline (band instruments)', 'Atau sistem bunyi + backline (alat muzik band)'],
                    ['Lighting: 4 beam, 4 wash, 2 face lights, 1 haze machine', 'Lampu: 4 beam, 4 wash, 2 face light, 1 mesin haze'],
                ],
            ],
            [
                'slug' => 'av-package-2', 'category' => 'av', 'finish' => null, 'tier' => 'basic', 'code' => '2',
                'size' => '4 × 8 m', 'price' => null, 'image' => 'media/av/p2-ballroom.webp',
                'gallery' => ['media/av/p2-hotel-stage.webp'],
                'name' => ['en' => 'LED Package 2', 'ms' => 'Pakej LED 2'],
                'features' => [
                    ['Indoor LED screen P3, 4 m × 8 m (RM350 per m²)', 'Skrin LED dalaman P3, 4 m × 8 m (RM350 setiap m²)'],
                    ['Lighting: 12 beam, 12 wash', 'Lampu: 12 beam, 12 wash'],
                    ['LED par / LED bar', 'LED par / LED bar'],
                    ['4–8 face lights / profiles', '4–8 unit face light / profile'],
                    ['1–2 haze machines', '1–2 mesin haze'],
                    ['Add-on: 2 × 40 ft mobile tech units', 'Tambahan: 2 unit mobile tech 40 kaki'],
                ],
            ],
            [
                'slug' => 'av-package-3', 'category' => 'av', 'finish' => null, 'tier' => 'basic', 'code' => '3',
                'size' => '3 × 6 m', 'price' => null, 'image' => 'media/av/p3-led-hall.webp',
                'gallery' => ['media/av/p3-stage.webp'],
                'name' => ['en' => 'LED Package 3', 'ms' => 'Pakej LED 3'],
                'features' => [
                    ['Indoor LED screen P3, 3 m × 6 m (RM350 per m²)', 'Skrin LED dalaman P3, 3 m × 6 m (RM350 setiap m²)'],
                    ['Sound system: 4 speakers, 2 subs, 2 monitors', 'Sistem bunyi: 4 speaker, 2 sub, 2 monitor'],
                    ['Or sound + backline (band instruments)', 'Atau sistem bunyi + backline (alat muzik band)'],
                    ['Lighting: 6 beam, 6 wash, 4 face lights, 6–8 LED par, haze machine', 'Lampu: 6 beam, 6 wash, 4 face light, 6–8 LED par, mesin haze'],
                ],
            ],
        ];

        foreach ($packages as $i => $row) {
            $note = $row['note'] ?? null;

            Package::query()->updateOrCreate(['slug' => $row['slug']], [
                ...$row,
                'features' => $this->features($row['features']),
                'note' => $note ? ['en' => $note[0], 'ms' => $note[1]] : null,
                'gallery' => $row['gallery'] ?? null,
                'is_featured' => $row['is_featured'] ?? false,
                'sort_order' => $i + 1,
            ]);
        }
    }

    private function addOns(): void
    {
        // [slug, en, ms, Arabian price in sen, Block price in sen (null = same)] — catalogue p.15
        $rows = [
            ['plastic-chair', 'Plastic chair', 'Kerusi plastik', 250, null],
            ['banquet-chair', 'Banquet chair (no cover)', 'Kerusi bankuet (tanpa sarung)', 600, null],
            ['chiavari-chair', 'Chiavari chair', 'Kerusi chiavari', 1300, null],
            ['chair-cover', 'Chair cover (plastic or banquet chair)', 'Sarung kerusi (plastik atau bankuet)', 300, null],
            ['chair-ribbon', 'Chair ribbon', 'Reben kerusi', 200, null],
            ['round-table', 'Round table (no cover)', 'Meja bulat (tanpa alas)', 2500, null],
            ['banquet-table', 'Banquet table (no cover)', 'Meja bankuet (tanpa alas)', 2500, null],
            ['bar-table', 'Bar table with cover', 'Meja bar berlapis', 6000, null],
            ['table-cover', 'Table cover (round or banquet)', 'Alas meja (bulat atau bankuet)', 1500, null],
            ['table-topping', 'Table topping', 'Lapik atas meja', 800, null],
            ['fairy-patio-light', 'Fairy & patio light (1 lot)', 'Lampu fairy & patio (1 lot)', 20000, 30000],
            ['plug-point', 'Plug point', 'Plug point', 6000, null],
            ['curtain-deco', 'White curtain deco (1 lot)', 'Tirai hiasan putih (1 lot)', 10000, 15000],
            ['chandelier', 'Chandelier', 'Chandelier', 8000, null],
            ['air-cooler', 'Air cooler', 'Air cooler', 25000, null],
            ['barricade', 'Barricade', 'Penghadang (barricade)', 5000, null],
            ['stand-fan', 'Stand fan', 'Kipas berdiri', 8000, null],
            ['side-cover', 'Side cover', 'Penutup sisi khemah', 5000, null],
            ['underlayer-deco', 'Ceiling underlayer deco', 'Hiasan siling (underlayer)', 15000, 20000],
        ];

        foreach ($rows as $i => [$slug, $en, $ms, $arabian, $block]) {
            AddOn::query()->updateOrCreate(['slug' => $slug], [
                'name' => ['en' => $en, 'ms' => $ms],
                'price_arabian' => $arabian,
                'price_block' => $block,
                'sort_order' => $i + 1,
            ]);
        }
    }

    private function services(): void
    {
        $services = [
            // Events we plan for (catalogue p.1 "Our services")
            [
                'slug' => 'personal', 'kind' => 'event', 'icon' => 'party', 'image' => 'media/gallery/garden-festoon.webp',
                'title' => ['en' => 'Personal Celebrations', 'ms' => 'Majlis Peribadi'],
                'summary' => [
                    'en' => 'Birthdays, engagements, parties and graduations, with tents, tables and lighting styled for the people who matter.',
                    'ms' => 'Hari jadi, pertunangan, parti dan konvokesyen, dengan khemah, meja dan lampu yang dihias untuk insan tersayang.',
                ],
            ],
            [
                'slug' => 'wedding', 'kind' => 'event', 'icon' => 'rings', 'image' => 'media/gallery/poolside-marquee.webp',
                'title' => ['en' => 'Weddings', 'ms' => 'Perkahwinan'],
                'summary' => [
                    'en' => 'From nikah to bersanding: decorated tents, mini pelamin, fairy lights and banquet seating for your big day.',
                    'ms' => 'Dari nikah hingga bersanding: khemah berhias, mini pelamin, lampu fairy dan susunan bankuet untuk hari bahagia anda.',
                ],
            ],
            [
                'slug' => 'corporate', 'kind' => 'event', 'icon' => 'briefcase', 'image' => 'media/gallery/mou-stage.webp',
                'title' => ['en' => 'Corporate & Conferences', 'ms' => 'Korporat & Persidangan'],
                'summary' => [
                    'en' => 'Launches, dinners, signing ceremonies and conferences, with stage, LED screen, sound and lighting taken care of.',
                    'ms' => 'Pelancaran, makan malam, majlis menandatangani perjanjian dan persidangan, lengkap dengan pentas, skrin LED, bunyi dan lampu.',
                ],
            ],
            [
                'slug' => 'festival', 'kind' => 'event', 'icon' => 'festival', 'image' => 'media/gallery/festive-arch.webp',
                'title' => ['en' => 'Festivals & Fairs', 'ms' => 'Festival & Karnival'],
                'summary' => [
                    'en' => 'Rows of Arabian tents, entrance arches and festive décor for fairs, open houses and seasonal celebrations.',
                    'ms' => 'Barisan khemah Arabian, gerbang pintu masuk dan hiasan perayaan untuk karnival, rumah terbuka dan sambutan musim perayaan.',
                ],
            ],
            [
                'slug' => 'fundraising', 'kind' => 'event', 'icon' => 'charity', 'image' => 'media/gallery/community-tent.webp',
                'title' => ['en' => 'Fundraising & Charity', 'ms' => 'Kutipan Dana & Amal'],
                'summary' => [
                    'en' => 'Covered space, seating and PA for community drives, charity dinners and fundraisers of every size.',
                    'ms' => 'Ruang berbumbung, tempat duduk dan sistem PA untuk program komuniti, makan malam amal dan kutipan dana.',
                ],
            ],

            // Other services (catalogue p.20)
            [
                'slug' => 'backdrop-printing', 'kind' => 'extra', 'icon' => 'printer', 'image' => 'media/svc/backdrop.webp',
                'gallery' => ['media/svc/event-arch.webp'],
                'title' => ['en' => 'Backdrop & Banner Printing', 'ms' => 'Cetakan Latar & Banner'],
                'summary' => [
                    'en' => 'Printed backdrops, banners and entrance arches, made for your event and your brand.',
                    'ms' => 'Latar belakang, banner dan gerbang pintu masuk bercetak, direka untuk acara dan jenama anda.',
                ],
            ],
            [
                'slug' => 'photobooth', 'kind' => 'extra', 'icon' => 'camera', 'image' => 'media/svc/photobooth.webp',
                'gallery' => ['media/svc/photobooth-christmas.webp'],
                'title' => ['en' => 'Photobooth', 'ms' => 'Photobooth'],
                'summary' => [
                    'en' => 'Themed photobooth sets your guests will queue for, from festive scenes to fully custom builds.',
                    'ms' => 'Set photobooth bertema yang menjadi tumpuan tetamu, dari tema perayaan hingga rekaan khas.',
                ],
            ],
            [
                'slug' => 'mini-pelamin', 'kind' => 'extra', 'icon' => 'flower', 'image' => 'media/svc/pelamin-floral.webp',
                'gallery' => ['media/svc/pelamin-rattan.webp'],
                'title' => ['en' => 'Mini Pelamin', 'ms' => 'Mini Pelamin'],
                'summary' => [
                    'en' => 'Floral and rattan mini pelamin for aqiqah, engagements, nikah, bersanding and welcome entrances.',
                    'ms' => 'Mini pelamin bunga dan rotan untuk aqiqah, bertunang, nikah, bersanding dan pintu masuk.',
                ],
            ],
        ];

        foreach ($services as $i => $row) {
            Service::query()->updateOrCreate(['slug' => $row['slug']], [
                ...$row,
                'gallery' => $row['gallery'] ?? null,
                'sort_order' => $i + 1,
            ]);
        }
    }
}
