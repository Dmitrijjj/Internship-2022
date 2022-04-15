1. cp .env.example .env
2. cd docker 
3. cp .env.example .env
4. sh scripts/run.sh
5. docker ps, check CONTAINER_ID  laravel-test_php-fpm
6. docker exec -it <CONTAINER_ID> bash
7. php artisan db:seed
8. import collection to Postman
