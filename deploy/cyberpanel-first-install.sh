#!/usr/bin/env bash
set -euo pipefail

DOMAIN="${1:-}"
REPO_URL="${2:-https://github.com/Ranneciva28/temoe-tumbuh.git}"
PHP_BIN="${PHP_BIN:-/usr/local/lsws/lsphp83/bin/php}"

if [ -z "$DOMAIN" ]; then
  echo "Usage: bash deploy/cyberpanel-first-install.sh yourdomain.com [repo-url]"
  exit 1
fi

if [ ! -x "$PHP_BIN" ]; then
  PHP_BIN="$(command -v php || true)"
fi

if [ -z "$PHP_BIN" ]; then
  echo "PHP CLI not found. Install/select PHP 8.3+ first."
  exit 1
fi

if ! command -v composer >/dev/null 2>&1; then
  echo "Composer not found. Install Composer first."
  exit 1
fi

BASE="/home/$DOMAIN"
APP="$BASE/laravel-app"
WEBROOT="$BASE/public_html"

if [ ! -d "$BASE" ]; then
  echo "$BASE does not exist. Create the website in CyberPanel first."
  exit 1
fi

if [ ! -d "$APP/.git" ]; then
  echo "Cloning Temoe Tumbuh..."
  git clone "$REPO_URL" "$APP"
else
  echo "Application already cloned; pulling latest main..."
  cd "$APP"
  git fetch origin main
  git reset --hard origin/main
fi

cd "$APP"

if [ ! -f .env ]; then
  cp .env.example .env
  echo "Created .env from .env.example."
fi

composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader

if ! grep -q '^APP_KEY=base64:' .env; then
  "$PHP_BIN" artisan key:generate --force
fi

mkdir -p storage/app/public storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache
chmod -R ug+rw storage bootstrap/cache || true

if [ -e "$WEBROOT" ] && [ ! -L "$WEBROOT" ]; then
  BACKUP="$BASE/public_html.backup.$(date +%Y%m%d%H%M%S)"
  echo "Backing up existing public_html to $BACKUP"
  mv "$WEBROOT" "$BACKUP"
fi

ln -sfn "$APP/public" "$WEBROOT"

echo

echo "Code installed. NEXT: edit $APP/.env and fill DB + ADMIN_* values."
echo "Then run:"
echo "  cd $APP"
echo "  $PHP_BIN artisan migrate --seed --force"
echo "  $PHP_BIN artisan storage:link"
echo "  $PHP_BIN artisan optimize"
echo
echo "CyberPanel webroot now points to Laravel public/."
