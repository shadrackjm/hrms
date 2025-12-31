# Render.com Deployment Guide (Laravel + SQLite)

This guide explains how to deploy your HRMS to **Render.com**.

## 1. Prepare your Repository
Make sure you have pushed your latest code to GitHub or GitLab. Render will pull the code from there.

## 2. Create a Web Service
1. Login to **Render.com**.
2. Click **New** > **Web Service**.
3. Connect your GitHub/GitLab repository.
4. Configure the service:
   - **Name**: `hrms-yourname`
   - **Environment**: `PHP`
   - **Build Command**: `./build.sh`
   - **Start Command**: `php artisan serve --host=0.0.0.0 --port=$PORT`
   - **Plan**: `Free`

## 3. Environment Variables (Advanced > Add Environment Variable)
Add the following keys to Render's environment settings:
- `APP_KEY`: (Copy from your local .env)
- `APP_ENV`: `production`
- `APP_DEBUG`: `false`
- `DB_CONNECTION`: `sqlite`
- `DB_DATABASE`: `database/database.sqlite`
- `APP_URL`: (Your Render URL, e.g., `https://your-app.onrender.com`)

## ⚠️ Important Note on SQLite Persistence
On Render's **Free Tier**, the file system is **ephemeral**. This means:
- Any data you save (employees, logs, etc.) will be **deleted** when the server restarts (which happens daily).
- To keep data permanently, you would need a **Render Disk** (requires a paid plan) or use an external database like **PostgreSQL** (Render has a free PostgreSQL for 90 days).

> [!TIP]
> For permanent storage without cost, using **Shared Hosting** (via FTP) or a **VPS** is still the best option since we can easily store the SQLite file there.
