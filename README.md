# Laravel Assignment – API Project

A Laravel-based API project with role-based access control, queue management, and Swagger documentation.

## 📋 Requirements

- PHP >= 8.2
- Composer
- MySQL
- Laravel 12

## 🚀 Project Setup

### 1️⃣ Clone Repository

```bash
git clone <your-private-repo-url>
cd ecommerce-task
```

### 2️⃣ Install Dependencies

```bash
composer install
```

### 3️⃣ Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` with your database credentials:

```env
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

### 4️⃣ Run Migrations & Seeders

```bash
php artisan migrate --seed
```

**Seeders will create:**
- Roles (`super-admin`, `user`)
- Default admin user (if configured)

### 5️⃣ Queue Configuration (IMPORTANT)

Set queue driver in `.env`:

```env
QUEUE_CONNECTION=database
```

Create queue table:

```bash
php artisan queue:table
php artisan migrate
```

Start queue worker:

```bash
php artisan queue:work
```

**Required for:**
- Notifications
- Background jobs

### 6️⃣ Run Application

```bash
php artisan serve
```

Application will run at:
```
http://127.0.0.1:8000
```

## 📚 API Documentation (Swagger)

### Generate Swagger Documentation

```bash
php artisan l5-swagger:generate
```

### Access Swagger UI

```
http://127.0.0.1:8000/api/documentation
```

## 🔧 Troubleshooting

- Ensure all PHP extensions required by Laravel are installed
- Verify MySQL service is running
- Check file permissions for `storage` and `bootstrap/cache` directories
- Keep the queue worker running for background jobs
