# Role Permission Management

A demo application to illustrate Role Permission Management.

## Installation

Clone the repo locally:

```sh
git clone https://github.com/KMSoe/role-permissions.git role_permissions
cd role_permissions
```

Install PHP dependencies:

```sh
composer install
```

Setup configuration:

```sh
cp .env.example .env
```

Generate application key:

```sh
php artisan key:generate
```

Create an MySQL database - ngo_db.

```sh
create database ngo_db;
```

Run database migrations and database seeder:

```sh
php artisan migrate:fresh --seed
```

Create Laravel Passport Personal access client:

```sh
php artisan passport:install
```

Run the dev server (the output will give the address):

```sh
php artisan serve --host 0.0.0.0 --port 8000
```

You're ready to go! Visit Role Permission Management in your postman (postman collection attached), and login with:

Super Admin User
- **Username:** superadmin@example.com
- **Password:** password

Manager User
- **Username:** manager@example.com
- **Password:** password

Standard User
- **Username:** standard@example.com
- **Password:** password

## APIs
To run APIs, the postman collection file is attached in the zip. The environmental variable **base_url** is the url where you run (eg. 0.0.0.0:8000/api or 127.0.0.0:8000/api). The **prefix /api** is included.

## Running tests

To run the Role Permission Management tests, run:

```
phpunit
```