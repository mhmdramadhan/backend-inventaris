# Laravel Product Inventory API

---

## Features

- CRUD for Products (Create, Read, Update)
- Authentication with Laravel Sanctum
- Validation on request payloads
- Unit / Feature tests with Pest

---

## Requirements

- PHP >= 8.1
- Composer
- MySQL
- Laravel 12
- Laravel Sanctum

---

## Installation

1. Clone the repository:

```bash
git clone https://github.com/mhmdramadhan/backend-inventaris
cd backend-inventaris
```

2. Install dependencies:

```bash
composer install
```

3. Copy `.env.example` to `.env`:

```bash
cp .env.example .env
```

4. Generate application key:

```bash
php artisan key:generate
```

---

## Configuration

Update `.env` with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_product_api
DB_USERNAME=root
DB_PASSWORD=your_password
```

---

## Database Setup

1. Create database in MySQL:

```sql
CREATE DATABASE laravel_product_api;
```

2. Run migrations:

```bash
php artisan migrate
```

---

## Authentication

This API uses **Laravel Sanctum** for authentication.

- Register a user:

```
POST /api/register
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password"
}
```

- Login:

```
POST /api/login
{
    "email": "john@example.com",
    "password": "password"
}
```

- Use returned token in `Authorization` header:

```
Authorization: Bearer {token}
```

---

## API Endpoints

### Get All Products

```
GET /api/products
```

**Headers:**
`Authorization: Bearer {token}`

**Response:**

```json
[
  {
    "id": 1,
    "name": "Laptop Asus",
    "sku": "SKU123",
    "quantity": 10,
    "price": 15000000
  }
]
```

---

### Create Product

```
POST /api/products
```

**Headers:**
`Authorization: Bearer {token}`

**Body:**

```json
{
    "name": "Laptop Asus",
    "sku": "SKU123",
    "quantity": 10,
    "price": 15000000
}
```

**Validation:**

- `name` → required  
- `sku` → required, unique  
- `quantity` → required, integer  
- `price` → required, numeric

**Response:**

```json
{
    "status": true,
    "message": "Product created successfully",
    "data": {
        "id": 1,
        "name": "Laptop Asus",
        "sku": "SKU123",
        "quantity": 10,
        "price": 15000000
    }
}
```

---

### Update Product

```
PUT /api/products/{id}
```

**Headers:**
`Authorization: Bearer {token}`

**Body:**

```json
{
    "name": "Laptop Asus Updated",
    "quantity": 15
}
```

**Response:**

```json
{
    "status": true,
    "message": "Product updated successfully",
    "data": {
        "id": 1,
        "name": "Laptop Asus Updated",
        "sku": "SKU123",
        "quantity": 15,
        "price": 15000000
    }
}
```

---

## Testing

### Using Pest

1. Configure `.env.testing` for a separate database:

```env
DB_CONNECTION=mysql
DB_DATABASE=laravel_test
DB_USERNAME=root
DB_PASSWORD=your_password
```

2. Run tests:

```bash
php artisan test
```


**Author:** Rama
