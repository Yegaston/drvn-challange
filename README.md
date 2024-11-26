# drvn Challange

## Hi!!! Thanks for checking out my code.

### Data Model

![Data Model](./readme-assets/data-model.svg)
![alt text](./readme-assets/image.png)

### First Time Setup

1. `cp .env.example .env`
2. `composer install`
3. `php artisan key:generate`
4. `php artisan migrate:fresh --seed`

If u need a DB, in the repo already exists a docker compose file to run a mariadb. This docker compsoe take the database settings from the .env file so take that in mind.

### Running the tests

`php artisan test`

### Running the server

`php artisan serve`

### Running the seeder

`php artisan db:seed`

### Running the migrations

`php artisan migrate`

### Running the migrations fresh

`php artisan migrate:fresh`
