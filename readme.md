# moneyValue

## .env

## Change the variables to your settings

DB_USERNAME
DB_PASSWORD

## Create DB

DB_DATABASE=currency_converter_db

## Install the dependencies

$ cd api && composer install
$ cd admin && npm install

## Launch the migrations and the seeders

$ php artisan migrate:fresh --seed

## Run the server

$ php artisan serve

## Admin

email: admin@admin.fr password: password
