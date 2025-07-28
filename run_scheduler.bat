@echo off
cd /d F:\php_laravel_Projects\MedicalCenter
php artisan schedule:run >> NUL 2>&1
