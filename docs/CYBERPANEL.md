# Temoe Tumbuh — Tencent Lighthouse + CyberPanel

Production layout:

```text
GitHub main
  -> GitHub Actions (SSH)
  -> /home/<domain>/laravel-app
  -> /home/<domain>/public_html -> laravel-app/public
  -> CyberPanel / OpenLiteSpeed
```

## 1. Create the website in CyberPanel

Create the production domain in CyberPanel first and use PHP 8.3 or newer. Create a MySQL database and database user for Temoe Tumbuh.

Do not put the Laravel project directly inside `public_html`. The application lives in `/home/<domain>/laravel-app`; only Laravel's `public/` is web-accessible.

## 2. First install

SSH to the server and run the repository first-install script after the repository/script is available, or follow the same commands manually.

The script backs up an existing non-symlink `public_html` before replacing it with a symlink to Laravel `public/`.

After the script creates `.env`, configure:

- `APP_URL`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`
- `ADMIN_NAME`
- `ADMIN_EMAIL`
- `ADMIN_PASSWORD`

Then run:

```bash
php artisan migrate --seed --force
php artisan storage:link
php artisan optimize
```

If CyberPanel's CLI PHP differs from the website PHP, use the LiteSpeed PHP binary, for example `/usr/local/lsws/lsphp83/bin/php`. The deployment scripts also run Composer through this PHP binary, so a system Composer configured with an older default PHP remains safe.

## 3. GitHub Actions secrets

Configure these repository Actions secrets:

- `TENCENT_SSH_HOST` — Tencent Lighthouse public host/IP
- `TENCENT_SSH_PORT` — normally `22`
- `TENCENT_SSH_USER` — deployment SSH user
- `TENCENT_SSH_PRIVATE_KEY` — private key dedicated to deployment
- `TENCENT_SITE_USER` — CyberPanel website owner, for example `temoe6594`
- `TENCENT_APP_PATH` — `/home/<domain>/laravel-app`

The SSH user must be allowed to run the deployment command as `TENCENT_SITE_USER` through passwordless `sudo`. The workflow deliberately runs Git, Composer, migrations, and cache commands as the website owner so deployments do not leave root-owned application files behind.

Never commit SSH private keys, database passwords, admin passwords, Meta CAPI tokens, or `.env`.

Every push to `main` then executes `.github/workflows/deploy-cyberpanel.yml`, which connects by SSH and runs `deploy/cyberpanel-deploy.sh`.

## 4. Cloudflare

After the app is healthy on the origin server:

1. Point the domain DNS record to the Tencent Lighthouse IP.
2. Add the domain to Cloudflare / move nameservers if not already done.
3. Use HTTPS on the origin (CyberPanel SSL) and set Cloudflare SSL/TLS to Full (strict) when the origin certificate is valid.
4. Do not cache `/admin/*`, `/minat`, POST requests, or authenticated pages.

## 5. Deployment safety

The production deploy script:

1. fetches `main`;
2. installs Composer dependencies without dev packages;
3. puts Laravel into maintenance mode;
4. runs migrations;
5. ensures storage link exists;
6. rebuilds Laravel caches;
7. brings the application back online.

The `.env` file and uploaded files in `storage/app/public` live on the server and are not replaced by Git deployments.
