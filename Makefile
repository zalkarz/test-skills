init:
	cp .env.example .env
	docker compose up -d --build
	docker exec php_app composer install
	docker exec php_app php artisan migrate
	docker exec php_app php artisan db:seed
start:
	docker compose start
stop:
	docker compose stop
up:
	docker compose up -d
down:
	docker compose down --remove-orphans
bash:
	docker exec -it php_app bash
