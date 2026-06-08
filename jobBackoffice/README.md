# 🏢 Job Backoffice

The control panel for admins and company owners — publish job listings, review applications with AI scoring, and manage companies, categories, and users from one place.

Part of a monorepo that also includes **hireMe** 👤 (job seeker frontend).

## ✨ Features

- 📊 **Dashboard** — overview stats
- 💼 **Vacancies** — CRUD with soft deletes and restore
- 📋 **Applications** — review, update status, AI score/feedback
- 🏭 **Companies** — manage employers (admin) or edit own company (company owner)
- 🏷️ **Categories** — job category management (admin)
- 👥 **Users** — list, edit roles, soft delete/restore (admin)

## 📁 Project structure

```
laravel's project/
├── shared/          # job/shared — shared Eloquent models (Composer path package)
├── jobBackoffice/   # this app — admin & company owner panel
└── hireMe/          # job seeker app — browse & apply to vacancies
```

Both apps depend on `shared/` via Composer. Models such as `User`, `Vacancy`, `Company`, `Category`, `App`, and `Resume` live in `shared/src/Models/` and are imported as `App\Models\...` in each app.

**This app owns the database schema.** 🗄️ Migrations and seeders live here. hireMe reads the same tables but does not ship its own migrations.

## 📋 Requirements

- 🐘 PHP 8.3+
- 📦 Composer
- 🟢 Node.js & npm
- 🐬 MariaDB or MySQL

## 🚀 Setup

From the `jobBackoffice` directory:

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Create the database (default name: `jobbackoffice`), then configure `.env`:

```env
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jobbackoffice
DB_USERNAME=root
DB_PASSWORD=
```

Run migrations and seed demo data:

```bash
php artisan migrate
php artisan db:seed
npm install
npm run build
```

Or use the combined setup script:

```bash
composer run setup
```

## 💻 Development

Start the app server, queue worker, log tail, and Vite dev server together:

```bash
composer run dev
```

Or run them separately:

```bash
php artisan serve
npm run dev
```

Default URL: `http://127.0.0.1:8000` 🌐

## 🔐 User roles

| Role               | Access                                                               |
| ------------------ | -------------------------------------------------------------------- |
| 👑 `admin`         | Full access — categories, companies, users, vacancies, applications  |
| 🏢 `company_owner` | Own company profile, own vacancies, applications for those vacancies |
| 👤 `job_seeker`    | Not intended for this app (uses hireMe)                              |

After seeding, sign in with:

- 📧 **Email:** `admin@example.com`
- 🔑 **Password:** `12345678`

## 🔗 Shared models

Models are defined in `../shared/src/Models/`. To change a model, edit the file in `shared/` — both jobBackoffice and hireMe pick up the change automatically via the Composer symlink at `vendor/job/shared`.

After adding new classes under `shared/src/`, run:

```bash
composer dump-autoload
```

## 🧪 Testing

```bash
composer run test
# or
php artisan test
```

## 🔀 Related apps

| App                  | Purpose                | Default database |
| -------------------- | ---------------------- | ---------------- |
| 🏢 **jobBackoffice** | Admin & employer panel | `jobbackoffice`  |
| 👤 **hireMe**        | Job seeker frontend    | `hireme`         |

For local development, both apps can point at the same database if you want a single shared dataset. Otherwise, run migrations here and configure hireMe to use the same schema.

## 🛠️ Tech stack

- 🔴 Laravel 13
- 🔐 Laravel Breeze (auth)
- 🎨 Tailwind CSS 3
- ⚡ Alpine.js 3
- ✅ Pest (testing)
