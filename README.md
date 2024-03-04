# Simple MVC

SimpleMVC is a lightweight custom PHP framework designed to provide a solid foundation for building robust web applications. This framework is mainly used for education purposes and as a learning tool, built to closely resemble the Laravel framework. 

## Current version
```
0.3.6
```
## Features

- **MVC Architecture:** Follows the Model-View-Controller architectural pattern for organized and maintainable code.
- **Routing:** Clean and customizable URL routing for handling requests.
- **Database Support:** Supports database integration and connections. Tested using MySQL and PostgreSQL. With some tweaks can work with most DMBS.
- **Template and Layout Engine:** Includes a simple and efficient template engine for building dynamic views. Can also use multiple layouts for different devices/parts of website.
- **Middleware Support:** Easily implement middleware for processing HTTP requests and responses.
- **Error Handling:** Comprehensive error handling for debugging and logging.

## Working:

>- [x] Router.
>- [x] Handle POST data.
>- [x] Handle GET data.
>- [X] Handle user registration.
>- [x] Layouts.
>- [x] Validation.
>- [x] Models.
>- [x] Middleware.
>- [X] Database connection.

## Known issues:

At this point the core of the project is complete and has the basic expected functionalities of a MVC based framework. Issues are possible and security concerns are many, so use it at your own risk. If you encounter any issues while using the framework, I encourage you to try and report them. 

## Installation

1. Clone project using git
```bash
git clone https://github.com/gitnjole/simple-mvc
```
2. Modify the database schema in `migrations/`
3. Create `.env` file from `.env-example` and adjust database parameters
4. Run `composer install`
5. Run migrations by executing `php migrations.php` from the project root directory
6. Start the php server from the `web/` directory using
```bash
php -S 127.0.0.1:[desired_port]
```

## Installation using Docker

Make sure you have docker installed on your system.

1. Clone project using git
2. Copy .env-example into .env
- Here you will need to modify the `.env` file along with `docker-compose.yml` with the following changes:

Inside the `docker-compose.yml` there will be a db configuration like this:
```bash
  db:
    image: mysql:8
    ports:
     - "3307:3306"
    volumes:
      - mysql-data:/var/lib/mysql
      - ./docker/mysql-config.cnf:/etc/mysql/conf.d/
    environment:
     - MYSQL_ROOT_PASSWORD: root
     - MYSQL_DATABASE: ''
     - MYSQL_USER: ''
     - MYSQL_PASSWORD: ''
```
You need to set these to be the same as in your `.env` file which would have to look something like
```bash
DB_DSN=mysql:host=db;port=3306;dbname=simple_mvc
DB_USER=user
DB_PASSWORD=pass
```
3. Navigate to the project root directory and run `docker -compose up -d`
4. Install dependencies `docker-compose exec app composer install`
5. Run migrations `docker-compose exec app php migrations.php`
6. You should now be able to access the landing page in the browser using http://127.0.0.1:8080

# Getting started

## Routing

Define your routes in `web/index.php`.
```php
$app->router->get('/form', [SiteController::class, 'form']);
$app->router->post('/form', [SiteController::class, 'formHandler']);
```

## Controllers

Create controllers in `controllers/`.
```php
namespace app\controllers

class YourController extends Controller
{}
```

## Views

Create the views in `views/`.

Currently, views are embeded through `{{content}}` in `views/layouts/main.html`.

## Migrations

Using the `migrations.php` file in the root directory, you can create and manage database migrations for your application. 

### Running migrations

The script is responsible for applying migrations and loading the necessary configurations while applying migrations defined in separate migration files. Now that the word migration has lost it's meaning, run the `migrations.php` file while in the root directory.

You should see something like the following lines:
```bash
[2024-03-04 00:21:29] - Applying migration migration01_initial.php
[2024-03-04 00:21:29] - Applied migration migration01_initial.php
[2024-03-04 00:21:29] - All migrations were applied.
```

- If you encounter an error 'Undefined array key "userClass" You need to make sure that you're passing in the following line in the `$config` array in `migrations.php`:
```php
$config = [
    // This line right here
    'userClass' => \app\models\User::class,
    'db' => [
        'DSN' => $_ENV['DB_DSN'],
        'USERNAME' => $_ENV['DB_USER'],
        'PASSWORD' => $_ENV['DB_PASSWORD']
    ]
];
```
### Creating migrations

Migration files are PHP classes containing Lift() and Drop() methods for applying and reverting the changes to the database schema, respectively. 
When creating a new migration, head over to the `/migrations/` directory and create a new migration file. The naming convention can be whatever you want, but I've chosen to stick with Laravel-like naming convention where files start with `migration` and end with a description of what the migration does, for example `migration0001_create_listing_table.php`.

# Attributions

This project was made as a learning experience and was largely inspired by the following sources:

- [PHP 8 Objects, Patterns, and Practice by Matt Zandstra](https://www.amazon.com/PHP-Objects-Patterns-Practice-Enhancements/dp/1484267907)
- [The Codeholic](https://www.youtube.com/@TheCodeholic)
- [Laravel documentation](https://laravel.com/docs/10.x)


