# 📚 Laravel Books & Orders API (High Performance Sample Project)

This is a **practice backend project built with Laravel** focusing on designing a scalable order system with:

* Repository Pattern
* Service Layer Architecture
* Redis Caching
* Redis Locking
* Idempotency Key Support
* Database Transactions (ACID)
* API Resources
* Rate Limiting (extendable)
* Dockerized environment (PHP, MySQL, Redis, Nginx)

---

# 🚀 Features

## 📖 Books Module

* List all books
* Create new book
* Cached index endpoint (Redis)

## 📦 Orders Module

* Create order with multiple books
* Stock validation
* Atomic stock decrement
* Redis distributed lock per book
* Idempotent order creation (prevent duplicate orders)
* Order items persistence

---

# 🧠 Architecture

This project follows a clean layered architecture:

```
Controller → FormRequest → Service → Repository → Model
```

### Layers

* **Controller** → request orchestration only
* **FormRequest** → validation layer
* **Service** → business logic (orders, stock, pricing)
* **Repository** → database abstraction
* **Resource** → API response formatting

---

# ⚡ Key Concepts Implemented

## 🔁 Idempotency Key

Prevents duplicate order creation on retries.

Example header:

```
Idempotency-Key: 550e8400-e29b-41d4-a716-446655440000
```

---

## 🔒 Redis Locking

Prevents race condition on stock decrement:

```php
Cache::lock("book:$bookId", 5)->block(3, function () {
    // stock decrement logic
});
```

---

## 🧾 ACID Transactions

All order creation is wrapped in DB transactions to ensure:

* Atomicity
* Consistency
* Isolation
* Durability

---

## ⚡ Caching

Books index endpoint is cached using Redis:

```php
Cache::remember('books:index', 60, fn () => ...)
```

---

# 🐳 Docker Stack

* PHP 8.3 (FPM)
* MySQL 8
* Redis
* Nginx

---

# 📡 API Endpoints

## Books

```
GET    /api/books
POST   /api/books
```

## Orders

```
POST   /api/orders/store
```

### Example Request

```json
{
  "items": [
    {
      "book_id": 1,
      "quantity": 2
    },
    {
      "book_id": 3,
      "quantity": 1
    }
  ]
}
```

---

# 🧪 Tech Stack

* Laravel 13
* PHP 8.3
* MySQL
* Redis (Cache + Lock)
* Docker / Docker Compose

---

# 📌 Goals of This Project

This project was built as a **backend engineering practice** to simulate real-world challenges like:

* High concurrency order handling
* Stock race condition prevention
* Idempotent API design
* Scalable caching strategies
* Clean architecture principles

---

# 💡 What I Learned

* Designing stateless APIs
* Handling race conditions with Redis locks
* Proper caching strategies in Laravel
* Service/Repository separation
* Building idempotent APIs (production pattern)

---

# 🚀 Future Improvements

* Queue-based order processing
* Event-driven architecture
* Payment gateway integration
* Advanced rate limiting per user/IP
* API versioning (v1/v2)
* Full observability (logging + metrics)

---

# 👨‍💻 Author

Backend Developer (Laravel)
Focused on scalable APIs, system design, and performance optimization.
