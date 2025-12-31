# Oracle Cloud Deployment Guide (Always Free Tier)

This guide will help you deploy your HRMS application to an Oracle Cloud Compute instance.

## 1. Create a Compute Instance
1. Login to **Oracle Cloud Console**.
2. Go to **Compute** > **Instances** > **Create Instance**.
3. Choose **Canonical Ubuntu 22.04** (or Oracle Linux 8) as the Image.
4. Select the **Always Free Eligible** shape (usually `VM.Standard.E2.1.Micro` or `VM.Standard.A1.Flex`).
5. **Download your Private Key** (.key) - you will need this to SSH into the server.
6. Click **Create**.

## 2. Server Configuration (via SSH)
Once the instance is "Running", SSH into it:
```bash
ssh -i your_key.key ubuntu@your_instance_ip
```

### Install PHP 8.2 & Extensions
```bash
sudo apt update
sudo apt install -y php8.2 php8.2-curl php8.2-xml php8.2-zip php8.2-sqlite3 php8.2-mbstring unzip
```

### Install Composer
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

## 3. Deploy Application
1. **Clone your code** to `/var/www/hrms`.
2. **Setup .env**:
   ```bash
   cp .env.example .env
   # Ensure DB_CONNECTION=sqlite
   ```
3. **Install Dependencies**:
   ```bash
   composer install --optimize-autoloader --no-dev
   ```
4. **Generate Key & Migrate**:
   ```bash
   php artisan key:generate
   touch database/database.sqlite
   php artisan migrate --force --seed
   ```

## 4. Setup Web Server (Nginx/Apache)
Point your web server's root to the `public/` directory of your application and ensure the `storage/` and `bootstrap/cache/` directories are writable by the web server user.

> [!TIP]
> Since we use **SQLite**, you don't need to install or configure a MySQL server on your Oracle instance, making it very easy to maintain!
