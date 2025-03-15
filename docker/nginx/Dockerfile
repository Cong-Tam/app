# nginx
FROM nginx

ENV TZ=UTC
RUN echo "${TZ}" > /etc/timezone && dpkg-reconfigure -f noninteractive tzdata

# nginx config file
COPY ./*.conf /etc/nginx/conf.d/
COPY ./*.conf.template /etc/nginx/conf.d/
COPY ./security/*.conf /etc/nginx/conf.d/security/

WORKDIR /var/www/html