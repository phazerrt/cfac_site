# Creative Factory — website

Bilingual (English / Malay) site for Creative Factory, an event management and equipment
supplier (tents, décor, LED screens, sound and lighting). Content comes from the
`CF_CATALOGUE_2026-ogos.pdf` catalogue.

Laravel 13 · Inertia 3 (SSR) · Vue 3 + TypeScript · Tailwind 4 · MySQL 8.4 · Sail. Same stack as `zuv_site`.

## Development (Sail)

```bash
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail npm run dev        # Vite + HMR + dev SSR
```

| What    | URL                                   |
| ------- | ------------------------------------- |
| App     | http://100.127.63.63:8084 (Tailscale) |
| Vite    | :5177                                 |
| MySQL   | 127.0.0.1:3310 (db `cfac`)            |
| Mailpit | http://100.127.63.63:8029             |

`VITE_DEV_HOST` is the address the browser uses to reach Vite. `INERTIA_SSR_HOT_URL=http://localhost:5177`
is how PHP inside the container reaches Vite's SSR endpoint. After changing `.env`, restart the app
container (`docker restart cfac-laravel.test-1`).

Tests: `./vendor/bin/sail artisan test` · Lint/format: `./vendor/bin/sail npm run check` ·
Types: `./vendor/bin/sail npm run types:check`.

## Where things live

- **Business facts** (phone, email, socials, area, page paths): `config/site.php`
- **UI strings**: `lang/en.json`, `lang/ms.json`
- **Content**: tent and AV packages (`packages`), add-on price list (`add_ons`), event types and other
  services (`services`). DB tables with JSON translations (`spatie/laravel-translatable`), seeded by
  `database/seeders/SiteContentSeeder.php`. Prices are copied from the catalogue.
- **Gallery**: `config/gallery.php` (path, real pixel size, tag, alt text in both languages)
- **Routes**: English at `/`, `/tent-packages`, `/equipment`, `/gallery`, `/contact`; Malay under `/ms/...`
  (`routes/web.php`, `app/Support/SitePages.php`)
- **Pages / components**: `resources/js/pages/site/*`, `resources/js/components/site/*`
- **Media**: `public/media` (photos pulled from the catalogue, WebP), logos in `public/images/brand`

The contact page's enquiry form doesn't store anything. It opens WhatsApp (or the mail app) with the
message already filled in.

## Production (not deployed yet)

`compose.prod.yaml` + `Dockerfile` mirror zuv: `cfac-prod-{nginx,php,ssr,mysql,cloudflared}`, project
name pinned `cfac-prod`, no published ports. Before the first `up`: create the Cloudflare Tunnel
`cfac` (ingress → `http://nginx:80`), store its token in `~/.secrets/cfac-cloudflared.env`, write
`.env.production` (mode 600), and add a Configuration Rule turning **Email Obfuscation off** for the
host (it breaks Vue hydration, same as on zuv).

## To confirm with the owner

- Location: the catalogue has no address. The site says **Kota Kinabalu, Sabah**, inferred from the
  "KK" social handles and the event photos.
- Facebook page URL: the catalogue only gives the name. The link currently runs a Facebook search.
- LED pricing: the catalogue's "RM350 MT SQ FT" is shown as **RM350 per m²**.
