docker network create my-golden-gate 2> /dev/null

docker-compose --env-file ./.env up -d --build --force-recreate --remove-orphans || exit

docker-compose exec mysql bash -c "mysql -uroot -proot -e \"IF NOT EXISTS(SELECT * FROM sys.databases WHERE name = 'master') create database master CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\" "

docker-compose exec php-fpm bash -c "cd /var/www && COMPOSER_MEMORY_LIMIT=-1 composer install" || exit

docker-compose exec php-fpm bash -c "php artisan migrate" || exit
