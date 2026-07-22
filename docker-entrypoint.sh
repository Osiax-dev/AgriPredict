#!/bin/bash

php artisan config:clear
php artisan cache:clear

php artisan config:cache

php artisan storage:link || true

php artisan migrate --force || true

apache2-foreground