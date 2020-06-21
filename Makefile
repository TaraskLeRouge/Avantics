args = `arg="$(filter-out $@,$(MAKECMDGOALS))" && echo $${arg:-${1}}`
DIR := ${CURDIR}
DOCKER?=docker
DOCKER_COMPOSE?=docker-compose
#RUN=$(DOCKER_COMPOSE) run --rm --volume $(DIR):/srv
#RUN_PHP-CLI= $(RUN) php-cli
EXEC?=$(DOCKER_COMPOSE) exec php-cli entrypoint.sh
NODE?=$(DOCKER_COMPOSE) exec node entrypoint.sh
COMPOSER=$(EXEC) php -d memory_limit=-1 /usr/local/bin/composer
CONSOLE=$(EXEC) bin/console


#PHPCSFIXER?=$(EXEC) php -d memory_limit=1024m vendor/bin/php-cs-fixer
#BEHAT=$(EXEC) vendor/bin/behat
#BEHAT_ARGS?=-vvv
#PHPUNIT=$(EXEC) vendor/bin/phpunit
#PHPUNIT_ARGS?=-v
#DOCKER_FILES=$(shell find ./docker/dev/ -type f -name '*')



## —— The Makefile ———————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'


## Project command ———————————————————————————————————

composer-install:
	$(COMPOSER) install --ignore-platform-reqs --prefer-source

composer-update: composer.json ## Update vendors according to the composer.json file
	$(COMPOSER) update
	
composer-require: ## [package]
	$(COMPOSER) require $(package)

rm:
	sudo rm -Rf ./public/build/ ./node_modules ./var ./vendor


## Symfony command ———————————————————————————————————

console:
	$(CONSOLE) make:controller

cc: ## Clear the cache.
	$(CONSOLE) cache:clear 

fix-perms: ## Fix permissions of all var files
	chmod -R 777 var/*



## Docker commands ———————————————————————————————————


web: ## Connect to container
	$(DOCKER_COMPOSE) exec -w "/srv" web bash 

cli: ## Connect to container
	$(DOCKER_COMPOSE) exec -w "/srv" -u 1000 php-cli bash 

app: ## Connect to container
	$(DOCKER_COMPOSE) exec -w "/srv" -u 1000 php-fpm bash 

up: ## Start the project
	$(DOCKER_COMPOSE) build --force-rm --pull
	$(DOCKER_COMPOSE) up -d --remove-orphans

down: ## Stop docker containers
	$(DOCKER_COMPOSE) down --remove-orphans
	$(DOCKER_COMPOSE) kill
	$(DOCKER_COMPOSE) rm -v --force

restart: down up ## Restart the project

ps: ## List docker containers
	$(DOCKER_COMPOSE) ps

logs: ## Logs docker containers
	$(DOCKER_COMPOSE) logs

stats: ## Display a live stream of container(s) resource usage statistics
	$(DOCKER) stats $(docker ps -q)
