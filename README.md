# laravel_posts_app

## 開発環境
- PHP 8.0
- Laravel Framework 8.41.0
- niginx 1.18.0
- MySQL 8.0.25
- docker
- docker-compose 3.8


## get started


#### クローンする
```
$ git clone https://github.com/k-iwashita-prtimes/posts_app_laravel.git
```

#### cloneしたディレクト配下へcdした後、dockerをbuild, upする。
```
$ docker compose build --no-cache
$ docker compose up -d 
```

#### dockerコンテナの中で、必要なファイルの生成, migrationを行う
```
$ docker compose exec app bash
$ composer install
$ cp .env.example .env
$ php artisan key:generate
$ php artisan migrate
$ php artisan db:seed
$ php artisan storage:link
$ npm install
$ npm run dev
$ composer dump-autoload
$ exit 
```

#### http://127.0.0.1:10080/  へ接続する。


#### ※MySQLに接続したい時
```
$ docker-compose exec db bash -c 'mysql -u${MYSQL_USER} -p${MYSQL_PASSWORD} ${MYSQL_DATABASE}'
