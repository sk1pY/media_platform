#!/bin/bash

echo "1. Копируем .env.example -> .env"
cp .env.example .env
sed -i 's/^#\s*\(DB_[A-Z_]*=.*\)/\1/' .env

echo "2. Запускаем контейнеры Sail"
docker-compose up -d

echo "3. Устанавливаем зависимости Composer"
docker-compose exec composer install

echo "4. Настраиваем Mailpit в .env"
sed -i '/^MAIL_MAILER=/c\MAIL_MAILER=smtp' .env
sed -i '/^MAIL_HOST=/c\MAIL_HOST=mailpit' .env
sed -i '/^MAIL_PORT=/c\MAIL_PORT=1025' .env
sed -i '/^MAIL_USERNAME=/c\MAIL_USERNAME=null' .env
sed -i '/^MAIL_PASSWORD=/c\MAIL_PASSWORD=null' .env
sed -i '/^MAIL_ENCRYPTION=/c\MAIL_ENCRYPTION=null' .env
sed -i '/^MAIL_FROM_ADDRESS=/c\MAIL_FROM_ADDRESS=demo@example.com' .env
sed -i '/^MAIL_FROM_NAME=/c\MAIL_FROM_NAME="Demo App"' .env

echo "5 Настройка БД"
sed -i '/^DB_CONNECTION=/c\DB_CONNECTION=mysql' .env
sed -i '/^DB_HOST=/c\DB_HOST=mysql' .env
sed -i '/^DB_PORT=/c\DB_PORT=3306' .env
sed -i '/^DB_DATABASE=/c\DB_DATABASE=media_platform' .env
sed -i '/^DB_USERNAME=/c\DB_USERNAME=root' .env
sed -i '/^DB_PASSWORD=/c\DB_PASSWORD=root' .env

echo "6. Генерируем ключ приложения"
docker-compose artisan key:generate

echo "7. миграции"
docker-compose exec php php artisan migrate --force

echo "8. Сеем "
docker-compose exec php php artisan db:seed

echo "9. Создаем символическую ссылку для storage"
docker-compose exec php php artisan storage:link

echo "10. Устанавливаем зависимости npm"
docker-compose exec node npm install

echo "11. Собираем (Vite)"
docker-compose exec node npm run build







