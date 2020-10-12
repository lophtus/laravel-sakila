# About

<code>laravel-sakila</code> is a demo web application based on the MySQL Sakila sample database.

# Installation

```bash
$ git clone https://github.com/lophtus/laravel-sakila
$ cd laravel-sakila
$ composer install
$ cp .env.example .env
$ php artisan key:generate --ansi
$ php artisan migrate --seed
$ php artisan storage:link
$ php artisan serve

# Visit http://localhost:8000
```

# Laravel Homestead

```bash
$ cp Homestead.yaml.example Homestead.yaml
$ vagrant up

# Add homestead.test to hosts file & visit http://homestead.test
```

# License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
