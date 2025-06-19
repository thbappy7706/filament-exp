# 🛡️ RBAC Filament Dashboard

A personal practice project built using **[FilamentPHP](https://filamentphp.com/)** to explore dashboard building and **Role-Based Access Control (RBAC)** with clean Laravel architecture.

> 🎯 This project is for development practice purposes only.

---

## 🚀 Features

- ✅ Role-Based Access Control using Spatie Permissions
- 🧩 User, Role, and Permission Management with Filament Resources
- 📊 Dashboard Widgets & Custom Pages
- 🎨 Light/Dark Mode toggle
- 🧱 Responsive and modern UI powered by TailwindCSS
- ⚡ Built with Laravel 11 and Filament v3


## 🧰 Tech Stack

- **Laravel 11+**
- **PHP 8.2+**
- **Filament v3**
- **Spatie Laravel Permission**
- **TailwindCSS**
- **Livewire**

## 📋 Installation Guide

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js & NPM
- SQLite or other database system (MySQL, PostgreSQL)

### Step 1: Clone the Repository

```bash
git clone https://github.com/thbappy7706/filament-exp.git
cd filamen-prac
```

### Step 2: Install PHP Dependencies

```bash
composer install
```

### Step 3: Install JavaScript Dependencies

```bash
npm install
```

### Step 4: Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

Edit the `.env` file to configure your database connection if you're not using SQLite.

### Step 5: Database Setup

```bash
# If using SQLite
touch database/database.sqlite

# Run migrations and seed the database
php artisan migrate --seed
```

### Step 6: Build Assets

```bash
npm run build
```

### Step 7: Start the Development Server

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser to access the application.

### Step 8: Access the Filament Dashboard

Visit `http://localhost:8000/admin` to access the Filament dashboard.

Default admin credentials:
- Email: admin@example.com
- Password: password

### Development Workflow

For active development, you can use the following command to run multiple services concurrently:

```bash
composer dev
```

This will start the Laravel server, queue worker, logs, and Vite development server.

## 📁 Project Structure

```
├── app/                  # Application code
│   ├── Filament/         # Filament resources, pages, and widgets
│   ├── Http/             # HTTP layer (controllers, middleware)
│   ├── Models/           # Eloquent models
│   └── Providers/        # Service providers
├── bootstrap/            # Framework bootstrap files
├── config/               # Configuration files
├── database/             # Database migrations, factories, and seeders
│   ├── factories/        # Model factories for testing
│   ├── migrations/       # Database migrations
│   └── seeders/          # Database seeders
├── lang/                 # Language files
├── public/               # Publicly accessible files
├── resources/            # Frontend resources
│   ├── css/              # CSS files
│   ├── js/               # JavaScript files
│   └── views/            # Blade templates
├── routes/               # Route definitions
│   ├── console.php       # Console routes
│   └── web.php           # Web routes
├── storage/              # Storage for logs, cache, etc.
└── tests/                # Test files
```

### Key Directories

- **app/Filament/Resources/**: Contains Filament resource classes for CRUD operations
- **app/Models/**: Contains the application's data models
- **database/migrations/**: Database structure definitions
- **database/seeders/**: Initial data seeders including roles and permissions


