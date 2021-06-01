init:
	docker-compose build --no-cache
	docker-compose up -d
	docker-compose exec app composer install
	docker-compose exec app cp .env.example .env
	docker-compose exec app php artisan key:generate
	docker-compose exec app cp .env.example .env.testing
	docker-compose exec app php artisan key:generate --env=testing
	docker-compose exec app php artisan storage:link
	docker-compose exec app chmod -R 777 storage bootstrap/cache
	docker-compose exec app php artisan migrate
	docker-compose exec app php artisan db:seed
	docker-compose exec app npm install
	docker-compose exec app npm run dev
	docker-compose exec app composer dump-autoload
	