#!/usr/bin/env bash
set -euo pipefail

APP_DIR="${APP_DIR:-$(pwd)}"
COMPOSER_BIN="${COMPOSER_BIN:-$(command -v composer || true)}"
BRANCH="${DEPLOY_BRANCH:-main}"

if [ -n "${PHP_BIN:-}" ]; then
  PHP="${PHP_BIN}"
elif [ -x /usr/local/lsws/lsphp83/bin/php ]; then
  PHP="/usr/local/lsws/lsphp83/bin/php"
else
  PHP="$(command -v php)"
fi

if ! "$PHP" -r 'exit(version_compare(PHP_VERSION, "8.3.0", ">=") ? 0 : 1);'; then
  echo "Temoe Tumbuh requires PHP 8.3 or newer. Selected: $PHP"
  exit 1
fi

if [ -z "$COMPOSER_BIN" ] || [ ! -f "$COMPOSER_BIN" ]; then
  echo "Composer not found. Install Composer first."
  exit 1
fi

cd "$APP_DIR"

maintenance_started=0
bring_up() {
  if [ "$maintenance_started" -eq 1 ] && [ -f artisan ]; then
    "$PHP" artisan up >/dev/null 2>&1 || true
  fi
}
trap bring_up EXIT

echo "[Temoe Tumbuh] Fetching latest code..."
git fetch origin "$BRANCH"
git reset --hard "origin/$BRANCH"

echo "[Temoe Tumbuh] Installing PHP dependencies..."
"$PHP" "$COMPOSER_BIN" install \
  --no-dev \
  --prefer-dist \
  --no-interaction \
  --optimize-autoloader

if [ -f artisan ]; then
  echo "[Temoe Tumbuh] Preparing Laravel with $PHP..."
  mkdir -p storage/app/public storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache
  chmod -R ug+rw storage bootstrap/cache || true

  "$PHP" artisan down --retry=10 || true
  maintenance_started=1

  "$PHP" artisan migrate --force
  "$PHP" artisan storage:link || true
  "$PHP" artisan optimize:clear
  "$PHP" artisan config:cache
  "$PHP" artisan route:cache
  "$PHP" artisan view:cache
  "$PHP" artisan up
  maintenance_started=0
fi

echo "[Temoe Tumbuh] Deployment complete."
