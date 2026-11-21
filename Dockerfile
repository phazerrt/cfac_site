# Production image for the Creative Factory site (same layout as iKSS/Bayu:
# php-fpm + nginx from one Dockerfile), plus a Node container for Inertia SSR.
FROM php:8.5-fpm-bookworm AS php-base

RUN apt-get update \
    && apt-get install -y --no-install-recommends unzip libicu-dev libzip-dev \
    && docker-php-ext-install pdo_mysql bcmath intl zip pcntl \
    && rm -rf /var/lib/apt/lists/*

COPY docker/php.ini /usr/local/etc/php/conf.d/zz-production.ini

WORKDIR /var/www/html

FROM php-base AS build

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY --from=node:22-bookworm /usr/local/bin/node /usr/local/bin/node
COPY --from=node:22-bookworm /usr/local/lib/node_modules /usr/local/lib/node_modules

RUN ln -sf /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm \
    && ln -sf /usr/local/lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx

COPY . /var/www/html

# Wayfinder generates TS route helpers through artisan during the Vite build,
# so the build needs a working (throwaway) .env.
RUN cp .env.example .env \
    && composer install --no-dev --no-interaction --optimize-autoloader \
    && php artisan key:generate --force \
    && npm ci \
    && npm run build:ssr \
    && rm -rf node_modules .env public/hot

# --- PHP-FPM -------------------------------------------------------------
FROM php-base AS php

COPY --from=build /var/www/html /var/www/html
COPY docker/php-entrypoint.sh /usr/local/bin/php-entrypoint

RUN chmod +x /usr/local/bin/php-entrypoint \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

ENTRYPOINT ["/usr/local/bin/php-entrypoint"]
CMD ["php-fpm"]

# --- Inertia SSR (Node) ---------------------------------------------------
FROM node:22-bookworm-slim AS ssr

WORKDIR /app
ENV NODE_ENV=production

COPY package.json package-lock.json .npmrc ./
RUN npm ci --omit=dev --ignore-scripts && npm cache clean --force

COPY --from=build /var/www/html/bootstrap/ssr ./bootstrap/ssr

USER node
EXPOSE 13714
CMD ["node", "bootstrap/ssr/app.js"]

# --- nginx ---------------------------------------------------------------
FROM nginx:1.30.7-alpine AS nginx

COPY docker/nginx.conf /etc/nginx/conf.d/default.conf
COPY --from=build /var/www/html/public /var/www/html/public
