FROM 687884979921.dkr.ecr.eu-west-1.amazonaws.com/laravel-php8.3-rocky:latest

COPY ./ /var/www/code/

RUN composer install --no-dev && \
  chown -R nginx:nginx ./

RUN sed -i "s/^;*max_execution_time = .*/max_execution_time = 600/" /etc/php.ini
RUN sed -i "s/^;*upload_max_filesize = .*/upload_max_filesize = 100M/" /etc/php.ini
RUN sed -i "s/^;*memory_limit = .*/memory_limit = 20m/" /etc/php.ini

RUN sed -i "s/^php_value\[memory_limit\] = .*/php_value[memory_limit] = 512M/" /etc/php-fpm.d/www.conf

RUN sed -i '/try_files \$uri =404;/i \        proxy_read_timeout 600s;\n        fastcgi_read_timeout 600s;' /etc/nginx/conf.d/code.conf
RUN sed -i '/server_name _;/a \    client_max_body_size 100M;' /etc/nginx/conf.d/code.conf

RUN chmod 777 -R storage/
