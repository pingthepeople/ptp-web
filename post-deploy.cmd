:: This script includes any actions that should be run following a successful
:: deployment to the Azure App Service.
:: https://github.com/projectkudu/kudu/wiki/Post-Deployment-Action-Hooks

:: Apply any pending database migrations
php artisan migrate --force