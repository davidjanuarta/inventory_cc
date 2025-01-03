how to run docker 

# docker-compose build
# docker-compose up -d

how to check version
# docker exec php_docker php --version
# docker exec php_docker composer --version
# docker exec db_tusmart mysql --version

masuk kedalam db melalui docker
# docker exec -it db_tusmart sh (username: root, password: root)

melihat container running
# docker container ls -a

create project laravel dengan docker
# docker exec php_docker composer create-project laravel/laravel:^10.0 ./

setup package laravel
# docker exec php_docker composer require laravel/breeze --dev
# docker exec php_docker php artisan migrate
# docker exec php_docker php artisan db:seed

jika ingin menjalankan artisan maka gunakan -it (iterative)
# docker exec -it php_docker php artisan breeze:install
# docker exec -it php_docker /var/www/artisan
# docker-compose exec name_of_npm_container npm run dev
# docker exec -it php_docker sh
# docker exec -it php_docker npm install

node & npm
# docker exec -it php_docker npm --version
# docker exec -it php_docker node --version


berhenti menjalankan
# docker compose down