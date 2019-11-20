# target
TARGET=bytegazette

UID=$(shell id -u)
GID=$(shell id -g)

docker_run=docker run --rm -t -v ${PWD}:/app -e HOME=/app --user ${UID}:${GID}

composer_image=composer
composer_prod=composer install --no-dev --no-suggest --prefer-dist --optimize-autoloader
composer_dev=composer install --no-suggest
composer_update=composer update
composer_clean=vendor var/*

npm_image=zealbyte/packer
npm_prod=npm install --production
npm_dev=npm install
npm_update=npm update
npm_clean=node_modules assets css js build dist manifest.json

