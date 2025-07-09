docker compose exec app bash : # Open a bash shell in the app container

# Laravel in bestehendes Verzeichnis installieren:
docker compose exec app composer install                    # Install existing dependencies
docker compose exec app composer require laravel/framework  # Add Laravel framework
docker compose exec app php artisan key:generate           # Generate application key

# ODER neues Laravel-Projekt in Unterordner erstellen:
docker compose exec app composer create-project laravel/laravel temp-laravel
docker compose exec app bash -c "mv temp-laravel/* . && mv temp-laravel/.* . && rmdir temp-laravel"

# Services starten:
docker compose up -d                                        # Start all services
docker compose exec app php artisan serve --host=0.0.0.0 --port=8000  # Start Laravel dev server