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

Create an MySQL database - role_db.

```sh
create database role_db;
```

Run database migrations and database seeder:

```sh
php artisan migrate:fresh --seed
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

## Running tests

To run the Role Permission Management tests, run:

```
phpunit
```