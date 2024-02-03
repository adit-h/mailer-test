# TODO - Work in Progress
# =======================
FROM php:8.1-fpm AS deps
WORKDIR /
# use latest stable version available here. https://pecl.php.net/package/memcached/3.2.0
RUN apt-get update && apt-get install -y libmemcached-dev libssl-dev zlib1g-dev \
	&& pecl install memcached-3.2.0 \
	&& docker-php-ext-enable memcached


# Rebuild the source code only when needed
FROM composer AS builder
WORKDIR /
COPY composer.* ./
RUN composer install


# Production image, copy all the files and run next
FROM php:8.1-alpine AS runner
WORKDIR /

COPY --from=builder --chown=var-www:var-www . ./
#COPY --from=builder --chown=var-www:var-www /app/composer.json ./
#COPY --from=builder --chown=var-www:var-www /vendor ./vendor
#COPY --from=builder --chown=var-www:var-www /.env ./

EXPOSE 3000

ENV PORT 3000
