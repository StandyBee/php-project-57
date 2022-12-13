start:
	php artisan serve --host 0.0.0.0

start-frontend:
	npm run dev

setup:
	composer install
	cp -n .env.example .env
	php artisan key:gen --ansi
	touch database/database.sqlite
	php artisan migrate
	php artisan db:seed
	npm ci
	npm run build

watch:
	npm run watch

migrate:
	php artisan migrate

console:
	php artisan tinker

log:
	tail -f storage/logs/laravel.log

test:
	composer exec --verbose phpunit tests

deploy:
	git push heroku

lint:
	composer exec phpcs -- --standard=PSR12 app routes tests

lint-fix:
	composer phpcbf -- --standard=PSR12 app routes tests database

test-coverage:
	XDEBUG_MODE=coverage composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml

install:
	composer install

validate:
	composer validate