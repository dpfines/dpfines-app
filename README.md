````markdown
# DP Fines Laravel App

A **Laravel-based web application** to track global data privacy enforcement actions.

- Public users can **view fines** without logging in.  
- Admin users can **log in** to manage fines (add/edit/delete).  

---

## 📌 Features

- Display fines in a table with:
  - Organisation
  - Regulator
  - Sector
  - Fine amount & currency
  - Date
  - Law
  - View Case button (links to official source)
- Admin panel with authentication:
  - Login/Logout
  - CRUD operations for fines
  - Protected routes accessible only by admins
- Pagination for large datasets
- Bootstrap 5 frontend styling

---

## ⚙️ Requirements

- PHP 8.1+  
- Laravel 10+  
- MySQL/MariaDB  
- Composer  
- Node.js & npm (optional, if compiling assets)  

---

## 🚀 Installation

1. Clone the repository:

```bash
git clone https://github.com/dpfines/dpfines-app.git
cd dpfines-app
````

2. Install PHP dependencies:

```bash
composer install
```

3. Copy `.env.example` to `.env`:

```bash
cp .env.example .env
```

4. Set database credentials in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dbfines
DB_USERNAME=root
DB_PASSWORD=
```

5. Generate Laravel app key:

```bash
php artisan key:generate
```

6. Run migrations:

```bash
php artisan migrate
```

7. (Optional) Seed admin user:

```bash
php artisan db:seed --class=AdminSeeder
```

8. Run the local development server:

```bash
php artisan serve
```

Visit `http://127.0.0.1:8000` for the public fines page.
Admin panel: `http://127.0.0.1:8000/admin/login`

---

## 🔐 Admin Login

Default seeded admin account:

* Email: `admin@example.com`
* Password: `password123`

> ⚠️ Change the password immediately in production.

---

## 💾 Adding Fines

* Admin panel allows creating, editing, and deleting fines.
* Public view displays fines with a "View Case" button linking to the official case URL (`link_to_case`).

---

## 💻 Tech Stack

* Backend: Laravel 10
* Frontend: Blade + Bootstrap 5
* Database: MySQL / MariaDB

---

## 📂 Folder Structure

```
app/
├─ Http/Controllers/GlobalFineController.php
├─ Http/Controllers/AdminAuthController.php
resources/
├─ views/
│  ├─ fines/ (public views)
│  ├─ admin/ (admin panel views)
├─ layout.blade.php
database/
├─ migrations/
├─ seeders/
```

---

## 🛠 Development Notes

* Use `php artisan tinker` to inspect database tables.
* Do **not commit** `.env` or `vendor/` folder.
* Include `.env.example` for setup instructions.

---

## 📌 License

This project is licensed under the MIT License.

```

---

This README covers:

- Project overview  
- Features (public and admin panel)  
- Installation instructions  
- Admin credentials  
- Tech stack and folder structure  

