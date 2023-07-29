# ecommerce-impl in PHP with Laravel 10.10

## Run project in dev mode

* install PHP 8.1
* [install Composer](https://getcomposer.org/doc/00-intro.md)
* install Mysql, Postgresql or Sqlite
* [install Rabbitmq](https://www.rabbitmq.com/download.html)
* [install Meilisearch](https://www.meilisearch.com/docs/learn/getting_started/installation)
* [install Redis](https://redis.io/docs/getting-started/installation/)

## On Debian | Ubuntu

* install require php extensions

```sh
apt install php8.1-{cli,common,amqp,ast,bcmath,bz2,calendar,ctype,decimal,dev,dom,exif,ffi,fileinfo,gd,gettext,gmagick,http,iconv,imagick,intl,json,ldap,mbstring,mcrypt,memcache,memcached,mongodb,mysql,mysqli,mysqlnd,opcache,pdo,pdo-mysql,pdo-pgsql,pdo-sqlite,phar,posix,redis,simplexml,sockets,sqlite3,tidy,tokenizer,uuid,xmlreader,xmlwriter,xsl,yaml,zip}
```

## Windows
* Todo

## Docker
* Todo

## Run Project

```
cd laravel-backend
cp .env.example .env 
```

Edit .env:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=MaryShop
DB_USERNAME=MaryShop
DB_PASSWORD=db-p@55

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MEILISEARCH_HOST=http://127.0.0.1:7700
MEILISEARCH_KEY=

RABBITMQ_HOST=localhost
RABBITMQ_PORT=5672
RABBITMQ_USER=guest
RABBITMQ_PASSWORD=guest
RABBITMQ_VHOST=/
RABBITMQ_QUEUE=maryshop
```


Update database and run dev server:

```
composer update
php artisan passport:install
php artisan migrate
php artisan db:seed
php artisan passport:client --password
php artisan scout:import "App\Models\Product"
php artisan queue:work &
php artisan serve --port=8000 &
```

## Test endpoints

* To see endpoints:
```sh
php artisan route:list
```

* Run tests:
```sh
cd nodejs-integration-tests
yarn
yarn start
```

## Todo
* finalize the CRUD implementation for models
* implement repository pattern for models
* add swagger-ui to project
* implement a recomendation engine to suggest products to user
* implement a prediction engine for sales
* use redis as cache for some statistics