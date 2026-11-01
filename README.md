# 🚀 HarmDung - Installation & Setup Guide

Welcome to **HarmDung**! Follow this guide to clone the repository and set up the project on your machine.

This guide provides two setup options:
- **Option A: Using Laravel Sail (Docker & MySQL)** – Recommended (Course 261343 Standard)
- **Option B: Using Local PHP & SQLite (No Docker)** – Lightweight alternative

---

## 🐋 Option A: Setup using Laravel Sail (Docker & MySQL)

*Recommended if you have Docker Desktop installed.*

### 📋 Prerequisites for Option A
1. **Docker Desktop** – Running on your machine ([Download Docker Desktop](https://www.docker.com/products/docker-desktop/))
2. **Git** – [Download Git](https://git-scm.com/)

---

### Step 1: Clone the Repository & Navigate to App Directory

```bash
git clone <repository-url>
cd HarmDung/harmdung-app
```

---

### Step 2: Create `.env` Configuration File

Copy `.env.example` to `.env`:

- **macOS / Linux / Git Bash:**
  ```bash
  cp .env.example .env
  ```
- **Windows (Command Prompt):**
  ```cmd
  copy .env.example .env
  ```
- **Windows (PowerShell):**
  ```powershell
  Copy-Item .env.example .env
  ```

Ensure your `.env` contains the Sail MySQL database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=harmdung
DB_USERNAME=sail
DB_PASSWORD=password
```

---

### Step 3: Install PHP Dependencies via Docker

If you don't have PHP or Composer installed locally on your host machine, you can run Composer inside a temporary Docker container:

- **macOS / Linux / Git Bash:**
  ```bash
  docker run --rm \
      -u "$(id -u):$(id -g)" \
      -v "$(pwd):/var/www/html" \
      -w /var/www/html \
      laravelsail/php84-composer:latest \
      composer install --ignore-platform-reqs
  ```
- **Windows (PowerShell / Command Prompt):**
  *(If you have Composer installed locally, simply run `composer install`)*

---

### Step 4: Start Laravel Sail

Start the application containers (PHP web app & MySQL database) in background mode:

```bash
./vendor/bin/sail up -d
```
*(On Windows CMD/PowerShell, use `vendor\bin\sail up -d`)*

---

### Step 5: Generate Application Key

```bash
./vendor/bin/sail artisan key:generate
```

---

### Step 6: Install Frontend Dependencies & Build Assets

```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
```

*(For active frontend development with hot-reloading, run `./vendor/bin/sail npm run dev` instead).*

---

### Step 7: Run Database Migrations & Seeders

```bash
./vendor/bin/sail artisan migrate --seed
```

---

### Step 8: Access the Application

Open your browser and navigate to:
👉 **[http://localhost](http://localhost:8000)**

---

### 🗄️ Connecting to MySQL via DBeaver (Sail)

- **Host:** `127.0.0.1` or `localhost`
- **Port:** `3306`
- **Database:** `harmdung` (or matching `DB_DATABASE` in `.env`)
- **Username:** `sail`
- **Password:** `password`

---

<br>

---

## 💻 Option B: Setup using Local PHP & SQLite (No Docker)

*Alternative option if you prefer running PHP directly on your computer.*

### 📋 Prerequisites for Option B
1. **PHP** (>= 8.3) with SQLite extensions enabled.
2. **Composer** – [Download Composer](https://getcomposer.org/)
3. **Node.js** (v18+ or v20+) & **npm**

---

### Step 1: Clone & Configure Environment

```bash
git clone <repository-url>
cd HarmDung/harmdung-app
cp .env.example .env
```

Ensure `.env` uses SQLite:
```env
DB_CONNECTION=sqlite
```

---

### Step 2: Install Dependencies & Key Generation

```bash
composer install
npm install
php artisan key:generate
```

---

### Step 3: Create SQLite Database & Migrate

- **macOS / Linux:**
  ```bash
  touch database/database.sqlite
  ```
- **Windows:**
  ```cmd
  type NUL > database\database.sqlite
  ```

Run migrations:
```bash
php artisan migrate --seed
```

---

### Step 4: Run Application

```bash
composer run dev
```
*(or run `php artisan serve` and `npm run dev` in separate terminals).*

Access the application at:
👉 **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

## 🛠️ Common Sail Commands

| Action | Command |
|---|---|
| Start Sail | `./vendor/bin/sail up -d` |
| Stop Sail | `./vendor/bin/sail stop` |
| View Container Logs | `./vendor/bin/sail logs -f` |
| Run Artisan Command | `./vendor/bin/sail artisan <command>` |
| Run NPM Command | `./vendor/bin/sail npm <command>` |
| Run PHPUnit Tests | `./vendor/bin/sail test` |

---

## ❓ Troubleshooting

- **Port 80 or 3306 already in use:**
  If port 80 is occupied, set `APP_PORT=8080` in `.env` and access `http://localhost:8080`.
- **Database Connection Refused:**
  Ensure `DB_HOST=mysql` (not `127.0.0.1`) when running inside Sail.
- **Permission Errors (macOS/Linux):**
  ```bash
  chmod -R 775 storage bootstrap/cache
  ```
