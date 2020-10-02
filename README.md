# laravel-photo-sharing-app

## コンテナ構成

- Nginx (Web サーバ)
- PHP-FPM (PHP の実行環境)
- MySQL (RDBMS)
- phpMyAdmin

## 構築方法

### 前準備 (初回のみ)

```
// データベースのデータ保存用ボリュームを作成
$ docker volume create --name laravel-photo-sharing-app-database-data

// イメージのビルド
$ docker-compose build

// (Dockerfile を変更した場合は再ビルド)
$ docker-compose build --no-cache
```

### コンテナの起動

```
// リポジトリのclone
$ git clone git@github.com:tamurayk/laravel-photo-sharing-app.git

// 開発環境の起動
$ cd laravel-photo-sharing-app
$ docker-compose up -d

// ※下記のように開発環境を起動すると http://localhost:8080/ で phpMyAdmin にアクセスできます
$ docker-compose -f docker-compose.yml -f docker-compose.local.yml up -d
```

### 依存パッケージのインストール (初回のみ)

```
$ docker exec -it php-fpm /bin/ash
# composer install
```

```
$ yarn install
```


### `public/` 以下の assets のバンドル

- 初回起動時、及び、`resource/` 以下のファイルを更新した際は、Laravel Mix の実行が必要です

```
// Laravel Mix(=Webpackのwrapper)で `resource/` 以下のファイルを `public/` 以下にバンドル
$ yarn yun dev
```

- 参考
  - https://laravel.com/docs/6.x/frontend#writing-css

### `.env` ファイルの作成と `Application Key` の生成 (初回のみ)

```
$ cp .env.example .env
$ docker exec php-fpm php artisan key:generate
```

### migration

```
$ docker exec php-fpm php artisan migrate
```

### seeder の実行

```
$ docker exec -it php-fpm /bin/ash

// (Seederを追加した場合はオートローダを再生成)
# composer dump-autoload

// DatabaseSeeder クラスを実行
# php artisan db:seed
```

### テスト用 DB の作成 (初回のみ)

- テスト用のDBを作成

```
$ docker exec -it database /bin/bash
# mysql -u root -p
mysql> CREATE DATABASE `webapp_testing`;

// 権限付与
mysql> GRANT ALL ON webapp_testing.* TO webapp;

// (権限確認)
mysql> SHOW GRANTS FOR 'webapp'@'%';
+------------------------------------------------------------+
| Grants for webapp@%                                        |
+------------------------------------------------------------+
| GRANT USAGE ON *.* TO 'webapp'@'%'                         |
| GRANT ALL PRIVILEGES ON `webapp`.* TO 'webapp'@'%'         |
| GRANT ALL PRIVILEGES ON `webapp_testing`.* TO 'webapp'@'%' |
+------------------------------------------------------------+
```

- `.env.testing` ファイルの作成と `Application Key` の生成

```
$ cp .env.testing.example .env.testing

// test用の Application Key を作成
$ docker exec -it php-fpm /bin/ash
# php artisan key:generate --env=testing
```

### アプリケーションへのアクセス

- ユーザー向けサイト: http://localhost:8000/
- phpMyAdmin: http://localhost:8080/ (phpMyAdmin コンテナを起動している場合のみアクセス可)

## 静的解析

### PHPStan

- [larastan](https://github.com/nunomaduro/larastan)

```
// run
# ./vendor/bin/phpstan analyse --memory-limit=2G
// help
# ./vendor/bin/phpstan analyse -h
// e.g.
# ./vendor/bin/phpstan analyse -l 6 --memory-limit=2G app/
```

### Psalm

- [psalm/psalm-plugin-laravel](https://github.com/psalm/psalm-plugin-laravel)

```
// run
# ./vendor/bin/psalm
```

## PHPUnit

```
// run
# ./vendor/bin/phpunit tests
// help
# ./vendor/bin/phpunit -h
```

## tips

### ルーティング定義の確認

```
php artisan route:list
```
