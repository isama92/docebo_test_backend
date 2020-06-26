# starting image (httpd is apache)
FROM httpd:2.4.43-alpine

# set workdir and volume
WORKDIR /var/www/html
VOLUME /var/www/html

# updates
RUN apk update; \
    apk upgrade;

# copy apache2 virtual host configuration
COPY ./vhost.conf /usr/local/apache2/conf/vhost.conf

# copy apache2 configuration
COPY ./apache.conf /usr/local/apache2/conf/httpd.conf

# create logs dir
RUN mkdir /var/apache_logs
