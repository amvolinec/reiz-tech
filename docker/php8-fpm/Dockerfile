FROM php:8.2-fpm-buster

# Develop tools
RUN set -eux; \
        apt-get update; \
        apt-get install -y --no-install-recommends \
            git \
            gnupg \
            unzip \
            ssh \
            nano \
            mariadb-client \
        ;

# sendmail for MailHog
RUN set -eux; \
        curl -sL https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 -o /usr/local/bin/mhsendmail; \
        chmod +x /usr/local/bin/mhsendmail

# PHP Extensions
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN set -eux; \
        install-php-extensions \
            redis \
            bcmath \
            mbstring \
            bz2 \
            calendar \
            dba \
            exif \
            gd \
            gettext \
            igbinary \
            intl \
            mcrypt \
            pdo \
            pdo_mysql \
            mysqli \
            pcntl \
            pdo_sqlite \
            pdo_sqlsrv \
            sqlsrv \
            soap \
            shmop \
            sockets \
            sysvmsg \
            sysvsem \
            sysvshm \
            tidy \
            xsl \
            zip \
            opcache \
            xdebug \
        ; \
        rm -rf /var/lib/apt/lists/*

ARG TIMEZONE="UTC"
RUN set -eux; \
        ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime; \
        echo ${TIMEZONE} > /etc/timezone

RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini; \
    sed -i '/realpath_cache_size/c\realpath_cache_size=4096K' /usr/local/etc/php/php.ini; \
    sed -i '/realpath_cache_ttl/c\realpath_cache_ttl=600' /usr/local/etc/php/php.ini; \
    sed -i '/cgi.fix_pathinfo/c\cgi.fix_pathinfo=0' /usr/local/etc/php/php.ini; \
    sed -i '/date.timezone/c\date.timezone="UTC"' /usr/local/etc/php/php.ini; \
    sed -i '/default_socket_timeout/c\default_socket_timeout=60' /usr/local/etc/php/php.ini; \
    sed -i '/memory_limit/c\memory_limit=2024M' /usr/local/etc/php/php.ini; \
    sed -i '/max_execution_time/c\max_execution_time=300' /usr/local/etc/php/php.ini;

# Composer
COPY composer-install.sh .
RUN set -eux; \
        chmod +x composer-install.sh; \
        ./composer-install.sh; \
        rm composer-install.sh

RUN set -eux; \
        addgroup --gid 1000 --system user; \
        adduser --uid 1000 --gid 1000 --disabled-login --system --shell /bin/bash user; \
        adduser user www-data

RUN rm /etc/ssl/openssl.cnf

COPY openssl.cnf /etc/ssl/

USER user

WORKDIR /var/www/laravel

CMD ["php-fpm", "-F"]
