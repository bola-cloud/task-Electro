# Task Management API

A robust RESTful API for a Task Management System built with Laravel 11, utilizing a Service Layer architecture, clean code principles, and modern PHP 8.2+ features.

## 🚀 Features
- **Authentication**: Secure API endpoints using Laravel Sanctum.
- **Projects Module**: Full CRUD operations scoped to the authenticated user.
- **Tasks Module**: Task management with advanced filtering (Status, Priority) and searching (Title).
- **Dashboard**: Real-time user-scoped metrics (Total, Active, Completed, Pending, Overdue tasks).
- **Service Layer Pattern**: Business logic is decoupled from controllers for better maintainability (Bonus Feature).
- **Scheduled Jobs**: Automated daily job to check for overdue tasks (Bonus Feature).

## 🛠️ Environment Setup & Prerequisites
- PHP 8.2 or higher
- Composer
- MySQL or SQLite

## ⚙️ Installation Steps

1. **Clone the repository:**
   ```bash
   git clone https://github.com/bola-cloud/task-Electro.git
   cd task-Electro
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Environment Configuration:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Run Migrations and Seeders:**
   ```bash
   php artisan migrate:fresh --seed
   ```

## 🧪 Test Credentials
A default test user is created via the seeder for immediate testing:

Email: test@example.com

Password: password

## 🚦 Testing
To run the automated feature tests:

```bash
php artisan test
```
