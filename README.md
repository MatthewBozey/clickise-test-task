# Test Project

Это проект на Laravel с использованием PostgreSQL в качестве базы данных, Redis для кеширования, RabbitMQ для управления очередями и Vite для сборки фронтенда. Проект нацелен на выполнение веб-приложений с асинхронной обработкой задач и современной фронтенд-сборкой.

---


## Требования

- PHP 8.3
- Composer
- Node.js 16+
- NPM
- Docker и Docker Compose

---


## Установка

### 1. Клонируйте репозиторий

```bash
git clone https://github.com/MatthewBozey/clickise-test-task.git
cd clickise-test-task
```

### 2. Установите зависимости

#### Установите зависимости PHP
```bash
composer install
```
#### Установите зависимости Node.js
```bash
npm install
```

### 3. Настройка окружения

Скопируйте .env.example в .env и настройте переменные окружения, такие как параметры базы данных, Redis, и RabbitMQ.

```bash
cp .env.example .env
```
**Не забудьте сгенерировать ключ приложения:**
```bash
php artisan key:generate
```

### 4. Запуск в Docker

Для запуска всех необходимых сервисов (PostgreSQL, Redis, RabbitMQ и приложения) используйте Docker Compose:

```bash
docker-compose up -d --build
```

### 5. Выполнение миграций

После запуска контейнеров выполните миграции базы данных:
```bash
docker-compose exec app php artisan migrate
```


### Структура проекта
- `app/` - Основной код приложения
- `database/` - Миграция, сидеры и фабрики базы данных
- `resources/` - Шаблоны Blade, vue и статические ресурсы 
- `routes/` - Файлы маршрутизации
- `public/` - Публично доступные файлы
- `docker-compose.yaml` - Конфигурация Docker