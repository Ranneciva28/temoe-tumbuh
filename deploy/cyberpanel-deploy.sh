#!/usr/bin/env bash
set -euo pipefail

APP_DIR="${APP_DIR:-$(pwd)}"
PHP_BIN="${PHP_BIN:-php}"
COMPOSER_BIN="${COMPOSER_BIN:-composer}"
BRANCH="${DEPLOY_BRANCH:-main}"

cd "$APP_DIR"

echo "[Temoe Tumbuh] Fetching latest code..."
git fetch origin "$BRANCH"
git reset --hard "origin/$BRANCH"

echo "[Temoe Tumbuh] Installing PHP dependencies..."
$COMPOSER_BIN install \
  --no-dev \
  --prefer-dist \
  --no-interaction \
  --optimize-autoloader

if [ -f artisan ]; then
  echo "[Temoe Tumbuh] Preparing Laravel..."
  $PHP_BIN artisan down --retry=10 || true
  $PHP_BIN artisan migrate --force
  $PHP_BIN artisan storage:link || true
  $PHP_BIN artisan optimize:clear
  $PHP_BIN artisan config:cache
  $PHP_BIN artisan route:cache
  $PHP_BIN artisan view:cache
  chmod -R ug+rw storage bootstrap/cache || true
  $PHP_BIN artisan up || true
fi

echo "[Temoe Tumbuh] Deployment complete."
