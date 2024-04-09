#!/usr/bin/env bash

echo "Running PHPStan"
php ./vendor/bin/phpstan analyse --memory-limit 1G

echo "Running Pint"
php ./vendor/bin/pint --test

echo "Running PHP Insights"
php artisan insights

echo "Running enlightn"
php artisan enlightn
