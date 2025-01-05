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

# Devcontainer

Start in Visual Studio Code and re-open in remote containers (`Remote-Containers: Reopen in Container`).

# UI

```bash
$ npm run build
```

# License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
