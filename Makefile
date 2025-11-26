init:
	@echo "Initializing project..."
	cp .env.example .env
	docker compose up -d --build
	@echo "Waiting for containers to be ready..."
	sleep 10
	docker exec php_app composer install
	docker exec php_app php artisan migrate
	docker exec php_app php artisan db:seed
	@echo "Project initialized successfully!"
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
