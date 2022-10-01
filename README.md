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
CREATE DATABASE `post-its`;
```
## Instalation :
Instalation dependencies and migrations the tables and data fake

Copy enviroment
```
cp .env.example .env
```
Install dependencies
```
composer install --ignore-platform-reqs
```
Migrate tables
```
php artisan migrate
```
Migrate data fake (Groups)
```
php artisan db:seed
```
Generate Secret for JWT (Auth)
```
php artisan jwt:secret
```
Generate symbolic link
```
php artisan storage:link
```
Run local server
```
php artisan serve
```

## Queue :
Execute queue for task in second plain (send email)
```
php artisan queue:work
```

## Postman
This is a quick guide to use the API

[API Post Its](https://documenter.getpostman.com/view/12863914/2s83tDpsdC)

 1. User/Create User
 2. Auth/Login
 3. User/Assign Group
 4. Etc...
