FROM php:7.4-apache
COPY site/ /var/www/html/
RUN docker-php-ext-install mysqli
RUN apt update -y && apt-get install -y libbrotli1 libmbedtls12 && apt-get clean
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
Expose 80

# docker run -it --rm --name my-running-app my-php-
#  docker run -i --rm --name php_contt -p 80:80 php_apache