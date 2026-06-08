# 👤 hireMe

The job seeker frontend for **Hire me** — browse open roles, upload a CV, and get instant AI score feedback on how well your resume fits each vacancy.

Part of a monorepo that also includes **jobBackoffice** (admin and employer panel).

## ✨ Features

- 🔍 **Vacancy search** — filter by title, location, company, or job type
- 📄 **Vacancy details** — view full listing with company and category
- 🤖 **AI resume parsing** — extract education, skills, experience, and summary from PDFs
- 📊 **AI fit scoring** — get a 0–100 score and detailed feedback for each application
- 📋 **My applications** — track status (pending, accepted, rejected) with summary stats
- 👤 **Profile** — update account details via Laravel Breeze

## 📁 Project structure

```
laravel's project/
├── shared/          # job/shared — shared Eloquent models (Composer path package)
├── jobBackoffice/   # admin & company owner panel — owns migrations & seeders
└── hireMe/          # this app — job seeker frontend
```

Both apps depend on `shared/` via Composer. Models such as `User`, `Vacancy`, `Company`, `Category`, `App`, and `Resume` live in `shared/src/Models/` and are imported as `App\Models\...` in each app.

**hireMe does not ship migrations.** Use the same database as jobBackoffice, or run migrations from jobBackoffice first.

## 📋 Requirements

- 🐘 PHP 8.3+
- 📦 Composer
- 🟢 Node.js & npm
- 🐬 MariaDB or MySQL
- 📑 `pdftotext` (from [poppler](https://poppler.freedesktop.org/)) — required for PDF resume parsing
- 🔑 OpenAI API key — for resume parsing and application scoring
- ☁️ S3-compatible storage — CVs are stored on the `cloud` disk (Laravel Cloud / AWS S3)

Install `pdftotext` on macOS:

```bash
brew install poppler
```

## 🚀 Setup

### 1. Database (jobBackoffice first)

From the `jobBackoffice` directory, create and seed the database:

```bash
cd ../jobBackoffice
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
```

See [jobBackoffice/README.md](../jobBackoffice/README.md) for full details.

### 2. hireMe

From the `hireMe` directory:

```bash
composer install
cp .env.example .env
php artisan key:generate
npm install
npm run build
```

Configure `.env` — at minimum:

```env
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jobbackoffice   # same DB as jobBackoffice, or your own copy
DB_USERNAME=root
DB_PASSWORD=

OPENAI_API_KEY=your-openai-api-key
OPENAI_ORGANIZATION=          # optional

LARAVEL_CLOUD_ACCESS_KEY_ID=
LARAVEL_CLOUD_SECRET_ACCESS_KEY=
LARAVEL_CLOUD_DEFAULT_REGION=
LARAVEL_CLOUD_BUCKET=
LARAVEL_CLOUD_URL=
LARAVEL_CLOUD_ENDPOINT=
```

For local development, point `DB_DATABASE` at the same database jobBackoffice uses so vacancies and applications stay in sync.

Or use the combined setup script (expects an existing database with migrations already applied):

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
php artisan queue:listen
npm run dev
```

Default URL: `http://127.0.0.1:8000`

## 🔗 Shared models

Models are defined in `../shared/src/Models/`. To change a model, edit the file in `shared/` — both apps pick up the change via the Composer symlink at `vendor/job/shared`.

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
| 👤 **hireMe**        | Job seeker frontend    | `hireme`         |
| 🏢 **jobBackoffice** | Admin & employer panel | `jobbackoffice`  |

See the [root README](../README.md) for the full monorepo overview.

## 🛠️ Tech stack

- Laravel 13
- Laravel Breeze (auth)
- Tailwind CSS 3
- Alpine.js 3
- OpenAI PHP (GPT-4o-mini)
- Spatie PDF-to-text
- Laravel Cloud / S3 file storage
- Pest (testing)
