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
    pdo_mysql \
    pdo_pgsql \
    opcache \
    zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash \
    && apt-get install -y symfony-cli

RUN echo "memory_limit=256M" > /usr/local/etc/php/conf.d/memory-limit.ini \
    && echo "date.timezone=Europe/Paris" > /usr/local/etc/php/conf.d/timezone.ini

# Configure Git pour éviter les erreurs de safe.directory
RUN git config --global --add safe.directory /app \
    && git config --global --add safe.directory '*'

WORKDIR /app

# Créer les répertoires vendor et var avec les bonnes permissions
RUN mkdir -p /app/vendor /app/var \
    && chmod -R 777 /app

EXPOSE 8000

CMD ["symfony", "serve", "--no-tls", "--port=8000", "--allow-http", "--allow-all-ip"]
