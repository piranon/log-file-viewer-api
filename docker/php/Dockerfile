FROM php:7.1-fpm

RUN apt-get update \
    && apt-get install -y vim git

RUN buildDeps="libpq-dev libzip-dev libicu-dev" \
    && apt-get install -y $buildDeps --no-install-recommends \
    && rm -rf /var/lib/apt/lists/*

RUN echo "alias ll='ls $LS_OPTIONS -l'" >> ~/.bashrc \
    && /bin/bash -c "source ~/.bashrc"

ADD access_log.1 /var/tmp/