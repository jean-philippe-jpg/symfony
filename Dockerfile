

FROM  php:8.1-fpm




RUN apt-get update && apt-get install -y \ 
        libpng-dev \ 
        libonig-dev \ 
        libxml2-dev \ 
        zip \ 
        unzip
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

ENTRYPOINT ["php-fpm"]