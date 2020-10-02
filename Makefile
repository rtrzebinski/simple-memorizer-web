SHELL := /bin/bash
default: help

args = `arg="$(filter-out $@,$(MAKECMDGOALS))" && echo $${arg:-${1}}`

help: ## Show this help
	@IFS=$$'\n' ; \
    help_lines=(`fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##/:/'`); \
    printf "%-30s %s\n" "target" "help" ; \
    printf "%-30s %s\n" "------" "----" ; \
    for help_line in $${help_lines[@]}; do \
        IFS=$$':' ; \
        help_split=($$help_line) ; \
        help_command=`echo $${help_split[0]} | sed -e 's/^ *//' -e 's/ *$$//'` ; \
        help_info=`echo $${help_split[2]} | sed -e 's/^ *//' -e 's/ *$$//'` ; \
        printf '\033[36m'; \
        printf "%-30s %s" $$help_command ; \
        printf '\033[0m'; \
        printf "%s\n" $$help_info; \
    done

clean: ## Stop all running docker containers (recommended to run before 'start' command to ensure ports are not taken)
	docker ps -q | xargs docker stop

start: ## Create and start containers, composer dependencies, db migrate and seed etc. - everything in one command
	make build
	make up
	make composer-install
	rm -f .env
	cp .env.dev .env
	docker-compose --file laradock/docker-compose.yml --project-directory laradock exec workspace mysql -h mysql -u root -proot -e "drop database if exists dev;"
	docker-compose --file laradock/docker-compose.yml --project-directory laradock exec workspace mysql -h mysql -u root -proot -e "create database dev;"
	docker-compose --file laradock/docker-compose.yml --project-directory laradock exec workspace mysql -h mysql -u root -proot -e "DROP USER IF EXISTS 'dev';"
	docker-compose --file laradock/docker-compose.yml --project-directory laradock exec workspace mysql -h mysql -u root -proot -e "CREATE USER 'dev' IDENTIFIED BY 'dev';"
	docker-compose --file laradock/docker-compose.yml --project-directory laradock exec workspace mysql -h mysql -u root -proot -e "GRANT ALL ON *.* TO 'dev';"
	docker-compose --file laradock/docker-compose.yml --project-directory laradock exec workspace php artisan key:generate
	docker-compose --file laradock/docker-compose.yml --project-directory laradock exec workspace php artisan migrate
	docker-compose --file laradock/docker-compose.yml --project-directory laradock exec workspace php artisan db:seed
	@printf "\n=========> Server is available at: http://localhost\n"

build: ## Build or re-build containers
	rm -rf laradock
	git clone git@github.com:rtrzebinski/laradock.git
	cp .laradock.env.example laradock/.env
	docker-compose --file laradock/docker-compose.yml --project-directory laradock build workspace php-fpm nginx mysql

up: ## Start containers
	docker-compose --file laradock/docker-compose.yml --project-directory laradock up -d workspace php-fpm nginx mysql

down: ## Stop and remove containers, networks, images, and volumes
	@docker-compose --file laradock/docker-compose.yml --project-directory laradock down

composer-install: ## Composer install
	@docker-compose --file laradock/docker-compose.yml --project-directory laradock exec -T workspace composer install

composer-update: ## Composer update
	@docker-compose --file laradock/docker-compose.yml --project-directory laradock exec -T workspace composer update

bash: ## SSH workspace container (run bash)
	@docker-compose --file laradock/docker-compose.yml --project-directory laradock exec workspace bash

test: ## Run all unit tests or given test file
	@docker-compose --file laradock/docker-compose.yml --project-directory laradock exec workspace ./vendor/bin/phpunit $(call args)

test-filter: ## Run unit tests of given class or test method
	@docker-compose --file laradock/docker-compose.yml --project-directory laradock exec workspace ./vendor/bin/phpunit --filter $(call args)

paratest: ## Run test with paratest
	@docker-compose --file laradock/docker-compose.yml --project-directory laradock exec workspace ./vendor/bin/paratest --runner SqliteRunner