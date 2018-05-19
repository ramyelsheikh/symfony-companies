# RESTing with Symfony 3.2

## Setup the Project


1. Make sure you have [Composer installed](https://getcomposer.org/).

2. Install the composer dependencies:

```bash
composer install
```

3. Load up your database

Make sure `app/config/parameters.yml` is correct for your database
credentials. Then:

```bash
php app/console doctrine:database:create
php app/console doctrine:schema:update --force
```

4. Start up the built-in PHP web server:

```bash
php app/console server:run
```

Then find the site at http://localhost:8000.

## In Progress:

1. Swagger

2. 