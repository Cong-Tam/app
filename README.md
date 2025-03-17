
Điều kiện tiên quyết: Môi trường Docker, môi trường Git, v.v. đã được xây dựng

Đi đến thư mục làm việc của bạn. VD: "workspace"
Chạy lệnh:
+ git clone https://github.com/Cong-Tam/app.git

Đi đến "workspace/app"
Chạy lệnh:
+ cp .env.example .env
+ docker compose build
+ docker compose up -d

Lưu ý: nếu chạy command "docker compose" có lỗi thì hãy thử "docker-compose"

Đi đến "workspace/app/laravel-src"
Chạy lệnh:
+ cp .env.example .env

Trở về "workspace/app"
Chạy lệnh:
+ docker compose exec app bash -c "composer install"
+ docker compose exec app bash -c "php artisan key:generate"

Nếu sử dụng ubuntu, cần cấp quyền thư mục
+ sudo chown -R 1000:1000 ./docker/elasticsearch/data
+ sudo chmod -R 777 ./docker/elasticsearch/data
+ sudo chmod -R 777 laravel-src/storage/logs

Chạy command kiểm tra các service đã có status UP:
+ docker compose ps -a
Nếu chưa:
+ docker compose start

Nếu tất cả đã có status UP 
+ docker compose exec app bash -c "php artisan migrate"
+ docker compose exec app bash -c "php artisan db:seed"
+ docker compose exec app bash -c "php artisan storage:link"
