# Post-Deployment Scripts

The deployment of this app will be performed as a 'zip' deployment in which all
the assets are zipped up and sent to the App Service. This is done by Circle CI.
See: https://github.com/projectkudu/kudu/wiki/Deploying-from-a-zip-file

The App Service allows us to run arbitrary post-deployment scripts. I have
created a folder, `post-deploy-scripts`, to hold these scripts in order to keep
deployments more self-contained (i.e. to make sure I don't lose track of all
this stuff again). We must set an environment variable (app setting) to point
the App Service to this folder:
`SCM_POST_DEPLOYMENT_ACTIONS_PATH=D:\home\site\wwwroot\post-deploy-scripts`.
see: https://github.com/projectkudu/kudu/wiki/Post-Deployment-Action-Hooks

The App Service will run all scripts in the folder, so to maintain ordering I'm
prepending a number to the start of the script name. NB: The scripts must be
Windows-friendly: `.bat`, `.cmd`, `.ps1`.
