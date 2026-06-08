# 💼 Hire me

A full-stack job board built with Laravel. **hireMe** helps job seekers browse vacancies, find the right fit, and apply CV, with AI feedback that highlights gaps in their CV and what to improve. **jobBackoffice** is the management dashboard, gives admins and company owners the tools to manage the platform. Both apps share the same Eloquent models through the **shared** package.

## 📱 Apps

| Directory                              | Description                                                                             |
| -------------------------------------- | --------------------------------------------------------------------------------------- |
| 👤 [**hireMe**](hireMe/)               | Public-facing app for job seekers — browse vacancies, upload resumes, apply             |
| 🏢 [**jobBackoffice**](jobBackoffice/) | Admin and employer panel — manage vacancies, companies, categories, applications, users |
| 🔗 [**shared**](shared/)               | Composer package (`job/shared`) with shared Eloquent models                             |

## 🏗️ Architecture

```
┌─────────────┐     ┌─────────────────┐
│   hireMe    │     │  jobBackoffice  │
│ (job seeker)│     │ (admin/employer)│
└──────┬──────┘     └────────┬────────┘
       │                     │
       │   use App\Models\*  │
       └──────────┬──────────┘
                  ▼
         ┌────────────────┐
         │  shared/       │
         │  job/shared    │
         │  (6 models)    │
         └────────────────┘
```

**jobBackoffice** owns migrations and seeders. 🗄️ **hireMe** has app-specific features such as resume analysis (OpenAI) 🤖 and file storage (Laraveel Cloud).

## 🚀 Quick start

### 1️⃣ Shared package

The `shared/` folder is linked automatically when you run `composer install` in either app.

### 2️⃣ jobBackoffice (run first)

```bash
cd jobBackoffice
composer install
cp .env.example .env
php artisan key:generate
# configure DB in .env, then:
php artisan migrate --seed
npm install && npm run build
composer run dev
```

See [jobBackoffice/README.md](jobBackoffice/README.md) for details.

### 3️⃣ hireMe

```bash
cd hireMe
composer install
cp .env.example .env
php artisan key:generate
# configure DB in .env (can match jobBackoffice schema)
npm install && npm run build
composer run dev
```

hireMe does not include migrations — use the same database as jobBackoffice or run migrations from jobBackoffice first.

## 🔐 User roles

| Role               | App           |
| ------------------ | ------------- |
| 👤 `job_seeker`    | hireMe        |
| 🏢 `company_owner` | jobBackoffice |
| 👑 `admin`         | jobBackoffice |

## 📋 Requirements

- 🐘 PHP 8.3+
- 📦 Composer
- 🟢 Node.js & npm
- 🐬 MariaDB or MySQL

## 👋 Built with love

I built **Hire me** to mirror how hiring works in real life — candidates search for the right opportunity and learn what to improve.

## 💬 Have a suggestion?

I'd love to hear from you

- 📧 **Email:** samaali2h@gmail.com
- 💼 **LinkedIn:** https://www.linkedin.com/in/sama-alhelo/
