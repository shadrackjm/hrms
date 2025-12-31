#!/usr/bin/env bash
# exit on error
set -o errexit

echo "--- Installing PHP dependencies ---"
composer install --no-dev --optimize-autoloader

echo "--- Installing Node dependencies ---"
npm install

echo "--- Building assets ---"
npm run build

echo "--- Preparing Database (SQLite) ---"
# Create empty database file if it doesn't exist
touch database/database.sqlite

echo "--- Running Migrations ---"
php artisan migrate --force --seed

echo "--- Optimizing ---"
php artisan config:cache
php artisan route:cache
php artisan view:cache
