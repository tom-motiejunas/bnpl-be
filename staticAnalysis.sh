#!/usr/bin/env bash

echo "Running PHPStan"
./vendor/bin/phpstan analyse --memory-limit 1G

echo "Running Pint"
./vendor/bin/pint --test
