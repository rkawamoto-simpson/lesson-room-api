FROM centos:centos7
MAINTAINER san.vo

RUN yum -y update; yum clean all

RUN yum -y install httpd;

RUN yum -y install epel-release
RUN rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-7.rpm
RUN yum -y --enablerepo=remi-php74 install php
RUN yum -y --enablerepo=remi-php74 install php-xml php-soap php-xmlrpc php-mbstring php-json php-gd php-mcrypt php-pdo php-pdo_mysql php-pdo_pgsql php-pgsql php-zip

RUN yum -y install ImageMagick

RUN yum -y install zip unzip
RUN yum -y install git

RUN yum clean all

WORKDIR /var/www/html

COPY ./config/httpd/httpd.conf /etc/httpd/conf/httpd.conf
COPY ./config/php/php.ini /etc/php.ini

COPY ./source /var/www/html
RUN chmod 777 -R storage
RUN chmod 777 -R public

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

RUN composer install

CMD ["/usr/sbin/httpd", "-D", "FOREGROUND"]