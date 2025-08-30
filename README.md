# child-rearing

# DEMO

# Features

# 使用バージョン

* Next.js: 15.3.3
* React: 19.1.0
* Laravel:  10
* PHP: 8.2
* MySQL: 8.0.32

# 使い方
* インストール方法
```
git clone git@github.com:yuta20253/child-rearing
```
## Laravel

* サーバー立ち上げ
```

docker compose -p child-rearing up -d --build
```

```
docker compose exec app bash
```

コンテナ内での操作
- 初回のみ
```
composer install
```

```
cp .env.example .env
```

```
php artisan key:generate
```

サーバーの立ち上げ
```
php artisan serve --host=0.0.0.0 --port=8000
```

## Next.js

 frontendディレクトリで
```
cd frontend
```

```
npm run dev
```

