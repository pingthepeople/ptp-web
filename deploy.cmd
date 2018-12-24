:: Deploy site files
@echo off
echo Deploying files...
xcopy %DEPLOYMENT_SOURCE% %DEPLOYMENT_TARGET% /Y

:: Apply any pending database migrations
php artisan migrate --force