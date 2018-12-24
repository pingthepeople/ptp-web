:: This script includes any actions that should be run following a successful
:: deployment to the Azure App Service.
:: https://github.com/projectkudu/kudu/wiki/Post-Deployment-Action-Hooks

:: The path to this script must be set in the App Service settings under the key,
:: SCM_POST_DEPLOYMENT_ACTIONS_PATH. 
:: I've set this to D:\home\site\wwwroot\post-deploy.cmd.

:: Apply any pending database migrations
php artisan migrate --force