FROM php:7.1-apache-jessie

RUN echo 'deb http://ftp.fr.debian.org/debian/ jessie main contrib non-free' > /etc/apt/sources.list && \
    echo 'deb-src http://ftp.fr.debian.org/debian/ jessie main contrib non-free' >> /etc/apt/sources.list && \
    echo 'deb http://security.debian.org/ jessie/updates main contrib non-free' >> /etc/apt/sources.list && \
    echo 'deb-src http://security.debian.org/ jessie/updates main contrib non-free' >> /etc/apt/sources.list && \
    echo 'deb http://ftp.fr.debian.org/debian/ jessie-updates main contrib non-free' >> /etc/apt/sources.list && \
    echo 'deb-src http://ftp.fr.debian.org/debian/ jessie-updates main contrib non-free' >> /etc/apt/sources.list && \
    echo 'deb http://ftp.debian.org/debian jessie-backports main' > /etc/apt/sources.list.d/backports.list && \
    echo 'deb http://ftp.utexas.edu/dotdeb/ stable all' > /etc/apt/sources.list.d/dotdeb.list && \
    echo 'deb-src http://ftp.utexas.edu/dotdeb/ stable all' > /etc/apt/sources.list.d/dotdeb.list && \
    apt-get -y update && apt-get install -y wget apt-transport-https && \
    echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list && \
    curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && \
    wget -q -O - https://dl-ssl.google.com/linux/linux_signing_key.pub |  apt-key add - && \
    wget https://www.dotdeb.org/dotdeb.gpg && apt-key add dotdeb.gpg && \
    curl -sL https://deb.nodesource.com/setup_6.x | bash - && \
    apt-get install -y nodejs libpq-dev libffi-dev libssl-dev libgmp3-dev libmpfr-dev libmpc-dev && \
    apt-get install -y -t jessie-backports libpq-dev zlib1g-dev libgconf-2-4 libx11-6 libfontconfig nano xvfb jq bc && \
    apt-get -y update && apt-get install yarn && \
    curl -sS -o /tmp/icu.tar.gz -L http://download.icu-project.org/files/icu4c/62.1/icu4c-62_1-src.tgz && \
    tar -zxf /tmp/icu.tar.gz -C /tmp && \
    cd /tmp/icu/source && \
    ./configure --prefix=/usr/local && \
    make && \
    make install && \
    mkdir -p /var/log/symfony && \
    chown -R www-data. /var/log/symfony/ && \
    docker-php-ext-install pgsql pdo_pgsql zip opcache && \
    docker-php-ext-configure intl && docker-php-ext-install intl && \
    pecl install xdebug-2.5.3 && docker-php-ext-enable xdebug opcache && \
    wget https://composer.github.io/installer.sig -O - -q | tr -d '\n' > installer.sig && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('SHA384', 'composer-setup.php') === file_get_contents('installer.sig')) { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php'); unlink('installer.sig');" && \
    DEBIAN_FRONTEND=noninteractive apt install -y locales && \
    sed -i -e 's/# fr_FR.UTF-8 UTF-8/fr_FR.UTF-8 UTF-8/' /etc/locale.gen && \
    echo 'LANG="fr_FR.UTF-8"'>/etc/default/locale && \
    dpkg-reconfigure --frontend=noninteractive locales && \
    update-locale LANG=fr_FR.UTF-8 && \
    apt-get remove -y wget && \
    apt-get autoremove -y && \
    rm -rf /var/lib/apt/lists/*
ENV LANG fr_FR.UTF-8

WORKDIR /mnt/apps/symfony

COPY etc/symfony.conf /etc/apache2/sites-available/
COPY etc/symfony.ini /usr/local/etc/php/conf.d/
COPY docker-php-entrypoint /usr/local/bin/

RUN curl -LsS https://symfony.com/installer -o /usr/local/bin/symfony && \
    chmod +x /usr/local/bin/docker-php-entrypoint && \
    chmod a+x /usr/local/bin/symfony && \
    chown -R www-data:www-data /var/log/symfony && \
    a2enmod rewrite && \
    a2dissite 000-default.conf && \
    a2ensite symfony.conf