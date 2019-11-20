# ------------------------------------------------
# makefile
# ------------------------------------------------
include config.mk

rm = rm -rf

define docker
	@echo Running $1 for ${TARGET}
	$(docker_run) $1 /bin/bash -c "$2"
endef

all: build

test: buildtest runtest

dev_npm_install:
	@echo -e "\033[0;36m**\033[0;32m Running npm install in development mode \033[0m"
	$(call docker, ${npm_image}, ${npm_dev})

dev_composer_install:
	@echo -e "\033[0;36m**\033[0;32m Running php composer install in development mode \033[0m"
	$(call docker, ${composer_image}, ${composer_dev})

npm_update:
	@echo -e "\033[0;36m**\033[0;32m Running npm package update \033[0m"
	$(call docker, ${npm_image}, ${npm_update})

composer_update:
	@echo -e "\033[0;36m**\033[0;32m Running php composer package update \033[0m"
	$(call docker, ${composer_image}, ${composer_update})

npm_install:
	@echo -e "\033[0;36m**\033[0;32m Running npm install in production mode \033[0m"
	$(call docker, ${npm_image}, ${npm_prod})

composer_install:
	@echo -e "\033[0;36m**\033[0;32m Running php composer install in production mode \033[0m"
	$(call docker, ${composer_image}, ${composer_prod})

dev_packages: dev_npm_install dev_composer_install

update_packages: npm_update composer_update

prod_packages: npm_install composer_install

dev: export APP_ENV = development
dev: dev_packages
	@echo -e "\033[0;36m**\033[0;32m Building ${TARGET} in development mode \033[0m"
	$(call docker, ${npm_image}, npm run dev)

build: export APP_ENV = production
build: prod_packages
	@echo -e "\033[0;36m**\033[0;32m Building ${TARGET} in production mode \033[0m"
	$(call docker, ${npm_image}, npm run build)

watch: export APP_ENV = development
watch:
	@echo -e "\033[0;36m**\033[0;32m Building ${TARGET} in development watch mode \033[0m"
	$(call docker, ${npm_image}, npm run watch)

buildtest: export APP_ENV = development
buildtest: dev_packages
	@echo -e "\033[0;36m**\033[0;32m Building ${TARGET} for testing \033[0m"
	$(call docker, ${npm_image}, npm run build)

runtest:
	@echo -e "\033[0;36m**\033[0;32m Starting phpunit testing... \033[0m"
	$(call docker, ${npm_image}, npm run test)
	@echo -e "\033[0;36m**\033[0;32m Starting frontend regression testing... \033[0m"
	$(call docker, ${npm_image}, npm run test)

clean:
	@echo -e "\033[0;36m**\033[0;32m Cleaning npm packages and cache \033[0m"
	$(call docker, ${npm_image}, ${rm} ${npm_clean})
	@echo -e "\033[0;36m**\033[0;32m Cleaning php composer packagse and cache \033[0m"
	$(call docker, ${composer_image}, ${rm} ${composer_clean})

.PHONEY: dev watch test build clean

