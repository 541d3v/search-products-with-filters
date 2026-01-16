# API поиска, фильтрации, сортировки и пагинации товаров

Production-ready HTTP API endpoint для получения списка товаров с поддержкой поиска, фильтрации, сортировки и обязательной пагинации.

**Стек:** Laravel 12, PHP 8.2+, SQLite (MySQL/PostgreSQL совместимо)  
**Архитектура:** Query Object Pattern, Form Request Validation, API Resources  
**Тестирование:** PHPUnit с полным покрытием

---

## Требования

- PHP 8.2 или выше
- Composer
- Laravel 12
- SQLite (или MySQL/PostgreSQL)

---

## Установка и запуск

### 1. Клонирование репозитория

```bash
git clone https://github.com/541d3v/search-products-with-filters.git
cd search-products-with-filters
```

### 2. Установка зависимостей

```bash
composer install
```

### 3. Настройка окружения

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Создание БД и загрузка тестовых данных

```bash
php artisan migrate:fresh --seed
```

Эта команда создаст:
- Таблицы `users`, `categories`, `products`
- Индексы на `name`, `price`, `category_id`, `rating`, `created_at`, `in_stock`
- 10 категорий товаров
- 31 тестовый товар с реальными данными

### 5. Запуск development сервера

```bash
php artisan serve
```

API будет доступен по адресу: `http://localhost:8000/api/products`

---

## API Endpoint

### GET /api/products

Возвращает список товаров с фильтрацией, сортировкой и пагинацией.

---

## Query Параметры

| Параметр | Тип | Описание | Пример |
|----------|------|-----------|---------|
| `q` | string | Поиск по названию товара | `?q=iphone` |
| `price_from` | decimal | Минимальная цена | `?price_from=100` |
| `price_to` | decimal | Максимальная цена | `?price_to=500` |
| `category_id` | integer | Фильтр по категории | `?category_id=2` |
| `in_stock` | boolean | Фильтр по наличию (true/false/0/1) | `?in_stock=true` |
| `rating_from` | float | Минимальный рейтинг (0-5) | `?rating_from=4` |
| `sort` | string | Сортировка | `?sort=price_asc` |
| `page` | integer | Номер страницы (по умолчанию 1) | `?page=2` |
| `per_page` | integer | Записей на странице (по умолчанию 15, max 100) | `?per_page=30` |

---

## Допустимые значения сортировки

- `price_asc` - цена по возрастанию
- `price_desc` - цена по убыванию
- `rating_desc` - рейтинг по убыванию
- `newest` - по дате создания (по убыванию, используется по умолчанию)

---

## Примеры запросов

### 1. Получить все товары (первая страница)

```bash
curl http://localhost:8000/api/products
```

### 2. Поиск по названию

```bash
curl "http://localhost:8000/api/products?q=iphone"
```

### 3. Фильтр по цене

```bash
curl "http://localhost:8000/api/products?price_from=100&price_to=500"
```

### 4. Фильтр по категории

```bash
curl "http://localhost:8000/api/products?category_id=1"
```

### 5. Товары в наличии с минимальным рейтингом

```bash
curl "http://localhost:8000/api/products?in_stock=true&rating_from=4"
```

### 6. Комбинированный фильтр с сортировкой и пагинацией

```bash
curl "http://localhost:8000/api/products?q=laptop&price_from=500&price_to=2000&in_stock=true&sort=price_asc&page=1&per_page=20"
```

### 7. Сортировка по рейтингу

```bash
curl "http://localhost:8000/api/products?sort=rating_desc&per_page=10"
```

---

## Формат ответа

### Успешный ответ (200)

```json
{
  "data": [
    {
      "id": 1,
      "name": "iPhone 14 Pro",
      "price": 999.99,
      "category_id": 1,
      "in_stock": true,
      "rating": 4.8
    },
    {
      "id": 2,
      "name": "Samsung Galaxy S23",
      "price": 899.99,
      "category_id": 1,
      "in_stock": true,
      "rating": 4.7
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 10,
    "per_page": 15,
    "total": 150
  }
}
```

### Ошибка валидации (422)

```json
{
  "message": "The price_from field must be a valid number.",
  "errors": {
    "price_from": [
      "The price_from field must be a valid number."
    ]
  }
}
```

---

## Валидация параметров

| Параметр | Правила |
|----------|---------|
| `q` | string, nullable, max 255 символов |
| `price_from` | numeric, >= 0 |
| `price_to` | numeric, >= 0 |
| `category_id` | integer, существующая категория |
| `in_stock` | boolean (0, 1, true, false) |
| `rating_from` | numeric, between 0 and 5 |
| `sort` | in: price_asc, price_desc, rating_desc, newest |
| `page` | integer >= 1 |
| `per_page` | integer, 1-100 |

При некорректных параметрах API возвращает HTTP 422 с подробной информацией об ошибках.

---

## Архитектура

### Структура проекта

```
app/
├── Http/
│   ├── Controllers/
│   │   └── ProductController.php      # Контроллер API
│   ├── Requests/
│   │   └── GetProductsRequest.php    # Валидация параметров
│   └── Resources/
│       └── ProductResource.php        # Сериализация ответа
├── Models/
│   ├── Product.php                   # Модель товара с Scopes
│   └── Category.php                  # Модель категории
├── Services/
│   └── Filters/
│       └── ProductFilter.php         # Query Object для фильтрации
└── Providers/
    ├── RouteServiceProvider.php      # Регистрация маршрутов
    └── AppServiceProvider.php
```

### Ключевые компоненты

1. **GetProductsRequest** - FormRequest для валидации всех параметров
2. **ProductFilter** - Query Object Pattern для применения фильтров
3. **Product Model** - Eloquent Scopes для каждого типа фильтра
4. **ProductResource** - JSON сериализация данных
5. **ProductController** - Бизнес-логика endpoint'а

### Производительность

- **Индексы БД:**
  - Полнотекстовый поиск по `name` (LIKE для SQLite)
  - Индексы на `price`, `category_id`, `rating`, `created_at`, `in_stock`

- **Оптимизация запросов:**
  - Избегание N+1 запросов (используется Eloquent Query Builder)
  - Эффективная пагинация через `paginate()`
  - Применение фильтров в единственном SQL запросе

---

## Запуск тестов

```bash
php artisan test
```

Тесты проверяют:
- ✓ Получение списка товаров
- ✓ Пагинация и навигация по страницам
- ✓ Поиск по названию
- ✓ Фильтрацию по цене
- ✓ Фильтрацию по категории
- ✓ Фильтрацию по наличию
- ✓ Фильтрацию по рейтингу
- ✓ Сортировку (цена, рейтинг, дата)
- ✓ Валидацию входных параметров

**Результат:** 15 tests passed (109 assertions)

---

## Категории товаров

По умолчанию в БД создаются следующие категории:

1. Electronics
2. Clothing
3. Books
4. Home & Garden
5. Sports
6. Toys & Games
7. Beauty & Personal Care
8. Automotive
9. Food & Beverages
10. Pet Supplies

---

## Миграции и сиды

### Запуск миграций

```bash
php artisan migrate
```

### Загрузка тестовых данных

```bash
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=ProductSeeder
```

### Полный сброс и загрузка

```bash
php artisan migrate:fresh --seed
```

---

## Файлы конфигурации

- `config/app.php` - конфигурация приложения
- `config/database.php` - настройки БД
- `.env.example` - пример файла окружения

---

## Дополнительные команды

```bash
# Создание резервной копии БД
php artisan tinker

# Интерактивная консоль для тестирования
> \App\Models\Product::count()

# Просмотр всех маршрутов API
php artisan route:list --path=api
```

---

## Известные ограничения

- SQLite не поддерживает FULLTEXT индексы, используется LIKE (можно заменить на MySQL/PostgreSQL для better performance)
- Максимум 100 товаров на странице
