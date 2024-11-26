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



## NOTAS AL PASO 

- En el composer agrege al autoload  un archivo de utilidades, esto es algo que hago para principalmente no tener que re escribir cosas tediosas, y principalmente, para evitar errores falsos de intelephense 

- El sistema de respuestas esta echo para manejar colleciones , items y respuestas de manera estandarizada.

- Como patrones de diseño, principalmente, uso lo que propone laravel, y me baso mucho en el principio tell don't ask.

- Decidi no usar repositorios, yo entiendo a eloquent como un repositorio, a parte de ORM.

- Tema testing, decidi solamente testear flujos completos (mas tipo feature que unit) , mas que nada para demostrar conocimiento, por que si le daba cobertura individual a servicios, controladores y utilidades, se me iba de tiempo.

