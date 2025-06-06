# 🎵 Laravel Concert Booking API

A Laravel-based API to manage and book concert tickets, built with Docker, MySQL, and Laravel Sanctum.

---
**Services:**
- `app`: Laravel (PHP 8.x)
- `nginx`: Web server
- `database`: MySQL 8.0

## 🚀 Features

- ✅ User Registration & Login (Sanctum)
- 🎫 View Concerts & Seat Types
- 🔐 Book Seats 
- ❌ Cancel Bookings
- 🧩 Secure RESTful API
- 📦 Dockerized Environment

---

## 🐳 How to Run Project


### 🧾 Prerequisites
- Docker + Docker Compose

### 📥 Clone Project
```bash
git clone https://github.com/cmdn-loanvo/concert-booking
cd concert-booking
```

### 🛠️ Setup and Run with Docker
```bash
docker compose up -d --build
```

### ⚙️ Configure Laravel
```bash
docker compose exec app composer install

docker compose exec app cp .env.example .env

docker compose exec app php artisan key:generate

docker compose exec app php artisan config:clear
```

### 🧪 Run Migrations and Seed Sample Data
```bash
docker compose exec app php artisan migrate --seed
```

Access app at: [http://localhost:8080](http://localhost:8080)

---
### ⚙️ Environment Variables

Located in `.env`:

```env
APP_URL=http://localhost:8080

DB_CONNECTION=mysql
DB_HOST=database
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secre

SESSION_DRIVER=database
CACHE_STORE=database

MAIL_MAILER=log
```

---

## 🗺️ Architecture Diagram

```
![System Architecture Diagram]((http://localhost:8080/images/diagram.png))
```

---

## 📦 API Endpoints

### 🔐 Auth

| Method | Endpoint         | Description          |
|--------|------------------|----------------------|
| POST   | `/api/register`  | Register user        |
| POST   | `/api/login`     | Login and get token  |
| POST   | `/api/logout`    | Logout               |


### 🎤 Concerts

| Method | Endpoint               | Description                 |
|--------|------------------------|-----------------------------|
| GET    | `/api/concerts`        | List all concerts           |
| GET    | `/api/concerts/{id}`   | Get concert + seat types    |

### 🧾 Bookings 
Add header: `Authorization: Bearer <token>`

| Method | Endpoint              | Description             |
|--------|-----------------------|-------------------------|
| POST   | `/api/bookings`       | Book a seat             |
| POST   | `/api/bookings/cancel`| Cancel a booking        |

---

## 💡 Example API Calls (Postman)

### Register
```http
POST /api/register
Content-Type: application/json

{
  "name": "User 1",
  "email": "user1@example.com",
  "password": "123456",
  "password_confirmation": "123456"
}

```

### Login
```http
POST /api/login
Content-Type: application/json

{
  "email": "test@example.com",
  "password": "password"
}
```

### List Concerts
```http
GET /api/concerts
```
### List Detail Concerts
```http
GET /api/concerts/1
```

### Book a Seat
```http
POST /api/bookings
Authorization: Bearer <token>
Content-Type: application/json

{
  "concert_id": 1,
  "seat_type_id": 2
}
```
### Cancel a Seat
```http
POST /api/bookings/cancel
Authorization: Bearer <token>
Content-Type: application/json

{
  "concert_id": 1,
  "seat_type_id": 2
}
```

---

## 🗃️ Database Models

### 🔹 users
| Column     | Type    |
|------------|---------|
| id         | bigint  |
| name       | varchar |
| email      | varchar |
| password   | varchar |

### 🔹 concerts
| Column     | Type        |
|------------|-------------|
| id         | bigint      |
| title      | varchar     |
| start_time | timestamps  |

### 🔹 seat_types
| Column         | Type     |
|----------------|----------|
| id             | bigint   |
| concert_id     | foreign  |
| name           | varchar  |
| total_quantity | int      |
| price          | decimal  |

### 🔹 bookings
| Column       | Type        |
|--------------|-------------|
| id           | bigint      |
| user_id      | foreign     |
| concert_id   | foreign     |
| seat_type_id | foreign     |
| price        | decimal     |
| deleted_at   | timedtamps  |

