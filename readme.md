# IGA tracker website
A laravel app

## Set up
edit `.env` with `DB_` connection info, then run the following

```
# install dependencies
composer install
# create database tables
php artisan migrate
```

## Building assets
`package.json` contains several node.js scripts for building assets for development and production. After running `npm install`, the following can be used during development:

```
npm run dev   # build assets with NODE_ENV=development
npm run watch       # build assets and watch with polling
npm run production  # build assets with NODE_ENV=production
```

js and css are built to `public/js` and `public/css` respectively.
