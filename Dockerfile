FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    zip \
    curl \
    wget \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) \
    intl \
    pdo \
    pdo_pgsql \
    opcache \
    zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash \
    && apt-get install -y symfony-cli

RUN echo "memory_limit=256M" > /usr/local/etc/php/conf.d/memory-limit.ini \
    && echo "date.timezone=Europe/Paris" > /usr/local/etc/php/conf.d/timezone.ini

WORKDIR /app

RUN useradd -m -u 1000 symfony \
    && chown -R symfony:symfony /app

EXPOSE 8000

USER symfony

CMD ["symfony", "serve", "--no-tls", "--port=8000", "--allow-http"]
