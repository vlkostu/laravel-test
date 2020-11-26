# Тестовое задание Laravel

## Задание
[Смотреть тут](TASK.md)

## Старт
> Иметь локально докер https://docs.docker.com/docker-for-windows/install/  

1. Перейти в папку `_docker`, выполнить `cp .env.example .env` (скопировать `.env.example` и сохранить как `.env`)  
2. Выбрать `DATA_PATH_HOST` в `.env`, который раньше не юзался, иначе ошибка будет (для *windows* аля `D:/.laradock/ltest_data`)  
3. \[Only Windows\] установить `COMPOSE_PATH_SEPARATOR` в `;`  
4. Перейти в папку `_docker/nginx/sites`, выполнить `cp ltest.conf.example ltest.conf`  
5. Перейти в папку `_docker/laravel-horizon/supervisord.d` и выполнить `cp laravel-horizon.conf.example laravel-horizon.conf`  
6. `docker-compose up -d nginx mysql phpmyadmin laravel-horizon redis redis-webui` (из папки `_docker`)  

\* при необходимости xdebug - нужно поставит true `WORKSPACE_INSTALL_XDEBUG` и `PHP_FPM_INSTALL_XDEBUG`.  

### Первый запуск
Войти в **workspace**-контейнер (`docker-compose exec workspace bash`) и выполнить команды:  
```
composer install
cp .env.example .env
php artisan key:generate
chmod -R 777 storage bootstrap/cache
php artisan storage:link

[optional]:
php artisan migrate --seed
```  

> PS. Не забыть прописать домен в hosts-файл: `127.0.0.1 laravel-test.com`.  

## PhpMyAdmin / Redis Admin / Queue
- phpmyadmin: {IP}:9999
- redis admin: {IP}:9987
- horizon (queue): /horizon
