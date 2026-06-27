# Amsaz Bakers & Sweets — Installation & Deployment Guide

## Requirements

| Requirement | Version |
|-------------|---------|
| PHP | 8.3+ |
| MySQL / MariaDB | 8.0+ |
| Composer | 2.x |
| Node.js & npm | 18+ |
| Web Server | Nginx or Apache |

Required PHP extensions: `BCMath`, `Ctype`, `cURL`, `DOM`, `Fileinfo`, `JSON`, `Mbstring`, `OpenSSL`, `PCRE`, `PDO`, `PDO_MySQL`, `Tokenizer`, `XML`, `GD` or `Imagick`

---

## Local Development Setup

### 1. Clone & install dependencies

```bash
git clone <repo-url> bakers
cd bakers
composer install
npm install
```

### 2. Environment configuration

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:

```ini
APP_NAME="Amsaz Bakers & Sweets"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bakery
DB_USERNAME=root
DB_PASSWORD=

CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=log          # emails write to storage/logs/laravel.log in dev
MAIL_FROM_ADDRESS="info@bakerssweets.pk"
MAIL_FROM_NAME="${APP_NAME}"
```

### 3. Database setup

```bash
php artisan migrate --seed
```

The seeder creates:
- Super-admin user: `admin@bakerssweets.pk` / `Admin@1234`
- Roles: `super-admin`, `admin`, `editor`

### 4. Storage link

```bash
php artisan storage:link
```

### 5. Build assets

```bash
npm run dev       # development (watch)
npm run build     # production build
```

### 6. Run the app

```bash
php artisan serve
```

Visit `http://localhost:8000` for the frontend.  
Admin panel: `http://localhost:8000/admin`

### 7. Process the queue (development)

In a separate terminal:

```bash
php artisan queue:work --tries=3
```

Alternatively, use the `sync` driver in `.env` for no-queue dev mode:

```ini
QUEUE_CONNECTION=sync
```

---

## Production Deployment

### Server configuration (Nginx)

```nginx
server {
    listen 80;
    server_name bakerssweets.pk www.bakerssweets.pk;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    server_name bakerssweets.pk www.bakerssweets.pk;

    ssl_certificate     /etc/ssl/certs/bakerssweets.crt;
    ssl_certificate_key /etc/ssl/private/bakerssweets.key;

    root /var/www/bakers/public;
    index index.php;

    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    location ~ \.php$ {
        fastcgi_pass  unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* { deny all; }

    # Cache static assets
    location ~* \.(jpg|jpeg|png|gif|ico|webp|svg|css|js|woff2?)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        access_log off;
    }
}
```

### Production `.env`

```ini
APP_ENV=production
APP_DEBUG=false
APP_URL=https://bakerssweets.pk

CACHE_STORE=redis         # recommended; fall back to database if no Redis
QUEUE_CONNECTION=redis    # recommended; fall back to database if no Redis
SESSION_DRIVER=redis

MAIL_MAILER=smtp
MAIL_HOST=smtp.your-provider.com
MAIL_PORT=587
MAIL_USERNAME=your-smtp-user
MAIL_PASSWORD=your-smtp-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@bakerssweets.pk"
MAIL_FROM_NAME="Amsaz Bakers & Sweets"

REDIS_HOST=127.0.0.1
REDIS_PORT=6379
```

### Deploy script

```bash
#!/usr/bin/env bash
set -e

# Pull latest code
git pull origin main

# Install/update dependencies
composer install --no-dev --optimize-autoloader

# Build frontend assets
npm ci && npm run build

# Run new migrations
php artisan migrate --force

# Clear and rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Re-link storage (idempotent)
php artisan storage:link

# Restart queue workers
php artisan queue:restart

echo "Deploy complete."
```

### Supervisor (queue worker)

```ini
; /etc/supervisor/conf.d/bakers-worker.conf
[program:bakers-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/bakers/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/log/bakers-worker.log
stopwaitsecs=3600
```

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start bakers-worker:*
```

### Scheduler (cron)

Add to the web server user's crontab (`crontab -e`):

```cron
* * * * * cd /var/www/bakers && php artisan schedule:run >> /dev/null 2>&1
```

---

## Post-deployment checks

```bash
# Confirm app is up
curl -I https://bakerssweets.pk/up

# Check the sitemap generates
curl -s https://bakerssweets.pk/sitemap.xml | head -5

# Confirm security headers
curl -I https://bakerssweets.pk | grep -E "X-Frame|X-Content|Strict"

# Confirm queue workers are processing
php artisan queue:monitor
```

---

## Useful Artisan Commands

| Command | Purpose |
|---------|---------|
| `php artisan cache:clear-content` | Clear nav/featured/sitemap caches |
| `php artisan cache:clear-content --all` | Flush entire cache |
| `php artisan queue:work --tries=3` | Start queue worker (dev) |
| `php artisan queue:failed` | List failed jobs |
| `php artisan queue:retry all` | Retry all failed jobs |
| `php artisan migrate:status` | Check migration state |
| `php artisan route:list --path=admin` | List admin routes |
| `php artisan config:cache` | Cache config for production |

---

## Mail Setup (Production)

Recommended providers: **Mailgun**, **Postmark**, **Amazon SES**, or **SMTP2GO**.

Example for Mailgun (Laravel HTTP driver):

```ini
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=mg.bakerssweets.pk
MAILGUN_SECRET=key-xxxxxxxxxxxxxxxx
MAILGUN_ENDPOINT=api.eu.mailgun.net   # EU customers only
```

Install the driver:

```bash
composer require symfony/mailgun-mailer symfony/http-client
```

Emails queued by the app:
- **Contact form** → notify admin
- **Job application received** → notify admin
- **Newsletter subscription** → welcome email to subscriber

---

## Queued Jobs Reference

All mail is sent via the `database` (or `redis`) queue. If a job fails after 3 attempts it is moved to `failed_jobs`.

```bash
# Monitor in real time
php artisan queue:work --verbose

# Inspect a failed job
php artisan queue:failed

# Retry a specific failed job (use ID from queue:failed list)
php artisan queue:retry 5

# Delete all failed jobs
php artisan queue:flush
```

---

## Security Notes

- **Never commit `.env`** to version control.
- Change the default admin password immediately after first login.
- Keep `APP_DEBUG=false` in production — it leaks stack traces.
- The `SecurityHeaders` middleware sets `X-Frame-Options`, `X-Content-Type-Options`, `Referrer-Policy`, and (in production) `HSTS`.
- Rate limiters are active on: Contact form (5/hr), Newsletter (3/hr), Job Apply (10/day).
- Admin panel is protected by: authentication + email verification + `EnsureIsAdmin` role check.
- Uploaded resumes live in `storage/app/public/resumes/` — ensure your web server does **not** serve `.php` files from the `storage` directory.

---

## Directory Structure (key paths)

```
app/
├── Console/Commands/ClearContentCache.php
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          — Admin CRUD controllers
│   │   ├── Frontend/       — Public-facing controllers
│   │   └── SitemapController.php
│   ├── Middleware/
│   │   ├── EnsureIsAdmin.php
│   │   └── SecurityHeaders.php
│   └── Requests/
│       ├── Admin/          — Server-side validation for admin forms
│       └── Frontend/       — Server-side validation for public forms
├── Mail/
│   ├── ContactNotificationMail.php
│   ├── JobApplicationReceivedMail.php
│   └── NewsletterWelcomeMail.php
├── Models/                 — Eloquent models (all with fillable + casts)
├── Observers/ContentObserver.php
├── Policies/BlogPostPolicy.php
└── Services/
    ├── CacheService.php
    ├── ImageService.php
    └── SitemapService.php

resources/views/
├── admin/      — Admin panel views
├── emails/     — Transactional email templates
├── errors/     — Custom 403 / 404 / 419 / 429 / 500 / 503 pages
└── frontend/   — Public website views
```
