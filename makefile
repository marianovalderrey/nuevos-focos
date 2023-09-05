docker-up:
	@echo running docker
	-docker-compose up -d
	-sudo chmod 777 application/storage/* -R && sudo chown mvalderrey:mvalderrey application/storage/logs/* -R
	-docker-compose exec focos_calor_app bash -c "composer install"
	-docker-compose exec focos_calor_app bash -c "composer dump-autoload"
	-sudo chmod 777 application/storage/app/public -R

envs:
	@echo creating laravel env file from default
	-cp docker/envs/.env.postgresql.example application/.env

bash:
	@echo running bash
	-docker-compose exec focos_calor_app bash

bash-nginx:
	@echo running bash
	-docker-compose exec nginx bash

ssh-server:
	@echo running ssh command for dev
	ssh root@134.209.31.50

query-monitor:
	@echo query monitor
	-clear
	-docker-compose exec focos_calor_app bash -c "php artisan laravel-query-monitor"

migrate-refresh:
	@echo running migrate-refresh
	-docker-compose exec focos_calor_app bash -c "php artisan clear"
	-docker-compose exec focos_calor_app bash -c "php artisan config:clear"
	-docker-compose exec focos_calor_app bash -c "php artisan migrate:fresh --force"
	-docker-compose exec focos_calor_app bash -c "php artisan key:generate --force"
	-docker-compose exec focos_calor_app bash -c "php artisan passport:keys --force"
	-docker-compose exec focos_calor_app bash -c "php artisan db:seed --force"
	-docker-compose exec focos_calor_app bash -c "php artisan config:cache"
	-docker-compose exec focos_calor_app bash -c "php artisan config:clear"
	-docker-compose exec focos_calor_app bash -c "php artisan storage:link"

migrate-create:
	@echo running migrate-create
	#-docker-compose exec focos_calor_app bash -c "php artisan migrate:fresh --force"
	-docker-compose exec focos_calor_app bash -c "php artisan migrate"

clear-cache:
	@echo clear cache
	-docker-compose exec focos_calor_app bash -c "php artisan cache:clear"
	-docker-compose exec focos_calor_app bash -c "php artisan clear-compiled"
	-docker-compose exec focos_calor_app bash -c "php artisan route:clear"
	-docker-compose exec focos_calor_app bash -c "php artisan config:clear"
	-docker-compose exec focos_calor_app bash -c "php artisan view:clear"

composer-update:
	@echo running composer update
	-docker-compose exec focos_calor_app bash -c "composer update --no-interaction"

composer-install:
	@echo running composer update
	-docker-compose exec focos_calor_app bash -c "composer install --no-interaction"

composer-dump-autoload:
	@echo running composer dump-autoload
	-docker-compose exec focos_calor_app bash -c "composer dump-autoload"

generar-clave-secreta:
	@echo running artisan php jwt:secret
	-docker-compose exec focos_calor_app bash -c "php artisan jwt:secret"

ejecutar-generador-focos:
	@echo running artisan php focos:generar
	-docker-compose exec focos_calor_app bash -c "php artisan focos:generar npp"

init: envs docker-up composer-install migrate-create
