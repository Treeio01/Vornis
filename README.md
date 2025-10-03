# Платформа Vornis

Vornis — это платформа на Laravel 10 + Inertia/Vue 3, которая помогает сообществу отмечать подозрительные кошельки Solana, вести публичный список и вознаграждать участников. В проект входит кастомный лендинг, пользовательская панель и админка на Filament.

## Требования
- PHP 8.1+
- Composer 2+
- Node.js 18+ и npm 9+
- MySQL 8

## Запуск локально
1. Клонируйте репозиторий и установите зависимости бэкенда:
   ```bash
   composer install
   ```
2. Установите зависимости фронтенда:
   ```bash
   npm install
   ```
3. Скопируйте файл окружения и сгенерируйте ключ:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   В `.env` укажите параметры БД (`DB_*`), `APP_URL`, настройки почты и очередей.
4. Примените миграции и сидеры (создадут базовые настройки и администратора):
   ```bash
   php artisan migrate --seed
   ```
5. Запустите Vite и встроенный сервер Laravel:
   ```bash
   npm run dev
   php artisan serve
   ```
   Приложение будет доступно по адресу `http://127.0.0.1:8000`, ассеты — по `http://127.0.0.1:5173`.

## Продакшн-сборка
- Соберите фронтенд: `npm run build`
- Закешируйте конфиги/маршруты: `php artisan config:cache && php artisan route:cache`
- Настройте веб‑сервер на директорию `public`.

## Настройка Nginx
Пример `/etc/nginx/sites-available/vornis.conf`:
```nginx
server {
    listen 80;
    server_name vornis.example.com;
    root /var/www/vornis/public;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }

    access_log /var/log/nginx/vornis.access.log;
    error_log  /var/log/nginx/vornis.error.log;
}
```
После добавления: создать симлинк в `sites-enabled`, проверить конфиг `nginx -t` и перезапустить Nginx. Проверьте права на `storage` и `bootstrap/cache` (`www-data:www-data`).

## Настройка Apache 2
Пример `/etc/apache2/sites-available/vornis.conf`:
```apache
<VirtualHost *:80>
    ServerName vornis.example.com
    DocumentRoot /var/www/vornis/public

    <Directory /var/www/vornis/public>
        AllowOverride All
        Require all granted
        # Для PHP-FPM раскомментируйте строку ниже и укажите актуальный сокет
        # SetHandler "proxy:unix:/run/php/php8.2-fpm.sock|fcgi://localhost/"
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/vornis-error.log
    CustomLog ${APACHE_LOG_DIR}/vornis-access.log combined
</VirtualHost>
```
Активируйте модули `rewrite proxy proxy_fcgi setenvif`, включите сайт `a2ensite vornis.conf` и перезапустите Apache.

## Контрольный список после деплоя
- Установите `APP_ENV=production`, `APP_DEBUG=false`
- Настройте воркеры очередей: `php artisan queue:work`
- Добавьте расписание в cron: `* * * * * php /var/www/vornis/artisan schedule:run >> /dev/null 2>&1`
- Настройте резервное копирование БД и `.env`

## Доступ в админку Filament
Сидер создаёт дефолтного администратора: `admin@vornis.com / password`. Сразу смените пароль и email.

## Тестирование и линтеры
- Запуск тестов: `php artisan test`
- Проверка стиля/форматирования: `./vendor/bin/pint`, `npm run lint`

## Структура проекта (кратко)
- `app/` — бэкенд (контроллеры, сервисы, enum-ы, Filament ресурсы)
- `resources/js/` — SPA на Vue (компоненты, страницы, layout)
- `database/` — миграции, сидеры
- `resources/assets/` — статические ассеты лендинга
- `routes/` — веб/апи маршруты (в том числе Inertia)

## Полезные команды
```bash
# Очистка кешей
php artisan optimize:clear

# Обновление зависимостей
composer update
npm update

# Генерация фронтенда для production
npm run build
```

