# laravel8-api-auth-social
Laravel 8 API authentication via social networks
Laravel 8 REST API Authentication with Passport and Socialite  
-------------------------------------------------------------

composer create-project laravel/laravel

composer require laravel/passport

php artisan migrate 
php artisan passport:install
php artisan passport:keys

php artisan vendor:publish --tag=passport-config
php artisan vendor:publish --tag=passport-migrations


composer require laravel/socialite 
php artisan make:model SocialAccount -m
php artisan make:migration make_password_and_email_fields_nullable_in_users_table --table=users
php artisan migrate
