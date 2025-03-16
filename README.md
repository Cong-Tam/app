
Điều kiện tiên quyết: Môi trường Docker, môi trường Git, v.v. đã được xây dựng

Đi đến thư mục làm việc của bạn. VD: "workspace"
Chạy lệnh:
+ git clone https://github.com/Cong-Tam/app.git

Đi đến "workspace/app"
Chạy lệnh:
+ cp .env.example .env
+ docker compose build
+ docker compose up -d

Đi đến "workspace/app/laravel-src"
Chạy lệnh:
+ cp .env.example .env

Trở về "workspace/app"
Chạy lệnh:
+ docker compose exec app bash -c "composer install"
+ docker compose exec app bash -c "php artisan key:generate"
+ docker compose exec app bash -c "php artisan migrate"
+ docker compose exec app bash -c "php artisan storage:link"
