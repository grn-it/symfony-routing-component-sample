FROM composer:latest AS symfony-routing-component-sample

RUN apk add --no-cache bash && \
    curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash && \
    apk add symfony-cli acl

CMD ["symfony", "server:start", "--no-tls", "--passthru=src/index.php", "--port=8000"]
