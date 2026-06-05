FROM php:8.1-apache

# Instalar extensões PHP necessárias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libpq-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_pgsql zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Habilitar módulos Apache
RUN a2enmod rewrite headers

# Permitir .htaccess em todo o projeto
RUN sed -i 's|<Directory /var/www/>|<Directory /var/www/html/>|g' /etc/apache2/apache2.conf \
    && sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Render usa a variável PORT — configurar Apache para ouvi-la
RUN echo '#!/bin/bash\nsed -i "s/Listen 80/Listen ${PORT:-80}/" /etc/apache2/ports.conf\nsed -i "s/:80/:${PORT:-80}/" /etc/apache2/sites-enabled/000-default.conf\nexec apache2-foreground' \
    > /usr/local/bin/start.sh && chmod +x /usr/local/bin/start.sh

WORKDIR /var/www/html

COPY . .

# Criar pasta de uploads com permissão de escrita
RUN mkdir -p uploads && chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \;

EXPOSE 80

CMD ["/usr/local/bin/start.sh"]
