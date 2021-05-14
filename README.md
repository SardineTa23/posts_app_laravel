# laravel_enviroment



## get started
#### クローンする
```
$ git clone https://github.com/k-iwashita-prtimes/posts_app.git
```

#####cloneしたディレクト配下へcdした後、
```
$ docker compose up -d --build
```

```
$ docker compose exec app bash
$ composer install
$ cp .env.example .env
$ php artisan key:generate
$ exit 
```

#### MySQLに接続したい
```
$ docker-compose exec db bash -c 'mysql -u${MYSQL_USER} -p${MYSQL_PASSWORD} ${MYSQL_DATABASE}'
```


