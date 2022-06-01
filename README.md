## xSolla Code Test

### Set up

- `cp .env.example .env`
- `php artisan key:generate`
- Set your database in .env 
- `composer install`
- `php artisan migrate`
- `npm run production`

### Generate dummy records

`php artisan comedians:create 100`

### Unit Tests

`./vendor/bin/phpunit`

