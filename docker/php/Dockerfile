FROM php:7.3-fpm

#peclのredisを入れる
RUN apt-get -y update && \
    apt-get -y install git && \
    docker-php-source extract && \
    git clone -b 4.1.1 --depth 1 https://github.com/phpredis/phpredis.git /usr/src/php/ext/redis && \
    docker-php-ext-install redis && \
    rm -rf /usr/src/php/ext/redis

# 今の所DBで使わないのでコメントアウト
#RUN docker-php-ext-install pdo_mysql
