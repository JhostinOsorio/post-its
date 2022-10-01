# Post Its Project (Laravel 9 | MySQL)

## Requeriments :
Requerimients basic for start project

- Apache __(2.4.54)__
- PHP __(8.1.10)__
- MySQL __(8.0.30)__
- Composer __(2.4.2)__

## Database :
Creating database

```
CREATE DATABASE post-its;
```
## Instalation :
Instalation dependencies and migrations the tables and data fake

```
cp .env.example .env
composer install
php artisan migrate
php artisan db:seed
php artisan jwt:secret
php artisan storage:link
php artisan serve
```

## Queue :
Execute queue for task in second plain (send email)
```
php artisan queue:work
```