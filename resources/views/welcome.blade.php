<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>API Поиска Товаров</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            color: white;
            margin-bottom: 3rem;
        }
        
        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        
        .header p {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        .content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 3rem;
        }
        
        .card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }
        
        .card h2 {
            color: #667eea;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .card p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1rem;
        }
        
        .card ul {
            list-style: none;
            margin: 1rem 0;
        }
        
        .card li {
            padding: 0.5rem 0;
            color: #666;
            display: flex;
            align-items: center;
        }
        
        .card li:before {
            content: "✓";
            color: #667eea;
            font-weight: bold;
            margin-right: 0.8rem;
        }
        
        .code-block {
            background: #f5f5f5;
            border-left: 4px solid #667eea;
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 6px;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            overflow-x: auto;
            color: #333;
        }
        
        .btn {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            margin-right: 1rem;
            margin-bottom: 1rem;
            transition: background 0.3s;
            border: none;
            cursor: pointer;
        }
        
        .btn:hover {
            background: #764ba2;
        }
        
        .footer {
            text-align: center;
            color: white;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .footer p {
            margin: 0.5rem 0;
        }
        
        .footer a {
            color: white;
            text-decoration: none;
            font-weight: 500;
        }
        
        .footer a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .header h1 {
                font-size: 1.8rem;
            }
            
            .content {
                grid-template-columns: 1fr;
            }
            
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }
        
        table tr {
            border-bottom: 1px solid #eee;
        }
        
        table th, table td {
            text-align: left;
            padding: 0.8rem;
        }
        
        table th {
            color: #667eea;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>API Поиска Товаров</h1>
            <p>API для поиска, фильтрации и пагинации товаров</p>
        </div>
        
        <div class="content">
            <div class="card">
                <h2>API Endpoint</h2>
                <p>Основной endpoint для получения списка товаров с полной поддержкой фильтрации и сортировки.</p>
                <div class="code-block">GET /api/products</div>
                <p><strong>Формат ответа:</strong></p>
                <div class="code-block">
                    {
                    "data": [
                        {
                        "id": 1,
                        "name": "iPhone 14 Pro",
                        "price": 999.99,
                        "category_id": 1,
                        "in_stock": true,
                        "rating": 4.8
                        }
                    ],
                    "meta": {
                        "current_page": 1,
                        "last_page": 10,
                        "per_page": 15,
                        "total": 150
                    }
                    }
                </div>
            </div>
            <div class="card">
                <h2>Быстрый старт</h2>
                <div class="code-block">
                    composer install
                    php artisan key:generate
                    php artisan migrate:fresh --seed
                    php artisan serve
                </div>
                <p style="color: #666; margin: 1rem 0;">Затем откройте в браузере или используйте curl:</p>
                <div class="code-block">
                    curl "http://localhost:8000/api/products"
                </div>
                <a href="http://localhost:8000/api/products" class="btn" target="_blank">Открыть API →</a>
            </div>
        </div>
        <div class="content">
            <div class="card">
                <h2>Примеры запросов</h2>
                <p><strong>1. Все товары (первая страница):</strong></p>
                <div class="code-block">GET /api/products</div>
                
                <p><strong>2. Поиск iPhone в цене $100-$1000:</strong></p>
                <div class="code-block">GET /api/products?q=iphone&price_from=100&price_to=1000</div>
                
                <p><strong>3. Товары в наличии, рейтинг >= 4:</strong></p>
                <div class="code-block">GET /api/products?in_stock=true&rating_from=4&sort=price_asc</div>
                
                <p><strong>4. Категория 1, первая страница:</strong></p>
                <div class="code-block">GET /api/products?category_id=1&page=1&per_page=20</div>
            </div>
            <div class="card">
                <h2>Query Параметры</h2>
                <table>
                    <tr>
                        <th>Параметр</th>
                        <th>Описание</th>
                    </tr>
                    <tr>
                        <td><code>q</code></td>
                        <td>Поиск по названию</td>
                    </tr>
                    <tr>
                        <td><code>price_from</code></td>
                        <td>Минимальная цена</td>
                    </tr>
                    <tr>
                        <td><code>price_to</code></td>
                        <td>Максимальная цена</td>
                    </tr>
                    <tr>
                        <td><code>category_id</code></td>
                        <td>ID категории</td>
                    </tr>
                    <tr>
                        <td><code>in_stock</code></td>
                        <td>true/false - наличие товара</td>
                    </tr>
                    <tr>
                        <td><code>rating_from</code></td>
                        <td>Минимальный рейтинг (0-5)</td>
                    </tr>
                    <tr>
                        <td><code>sort</code></td>
                        <td>price_asc, price_desc, rating_desc, newest</td>
                    </tr>
                    <tr>
                        <td><code>page, per_page</code></td>
                        <td>Пагинация (по умолчанию 1, 15)</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="footer">
            <p><strong>API Поиска Товаров</strong></p>
            <p>Решение с полной архитектурой и тестовым покрытием</p>
            <p style="font-size: 0.9rem; opacity: 0.8;">Создано: 16 января 2026 г. | Версия: 1.0.0</p>
            <p style="margin-top: 1rem;">
                <a href="http://localhost:8000/api/products" target="_blank">API Endpoint</a>
            </p>
        </div>
    </div>
</body>
</html>
