#!/bin/sh
set -e

SCRIPT_NAME="fix-server.sh"
COMPOSE_FILE="docker-compose.prod.yml"

echo "[$SCRIPT_NAME] === Fix nginx tmp permissions + rebuild ==="

if ! command -v docker >/dev/null 2>&1; then
    echo "[$SCRIPT_NAME] ERROR: docker not found"
    exit 1
fi

if [ ! -f "$COMPOSE_FILE" ]; then
    echo "[$SCRIPT_NAME] ERROR: $COMPOSE_FILE not found (run from project root)"
    exit 1
fi

echo "[$SCRIPT_NAME] [1/4] Applying immediate chown fix to running container..."
docker compose -f "$COMPOSE_FILE" exec -T app sh -c '
    mkdir -p /var/lib/nginx/tmp /var/log/nginx
    chown -R www-data:www-data /var/lib/nginx /var/log/nginx 2>/dev/null || true
    chmod -R 755 /var/lib/nginx /var/log/nginx 2>/dev/null || true
' || echo "[$SCRIPT_NAME] WARN: container not running or chown skipped"

echo "[$SCRIPT_NAME] [2/4] Patching docker/entrypoint.sh if nginx tmp fix is missing..."
if grep -q "Fixing nginx tmp permissions" docker/entrypoint.sh 2>/dev/null; then
    echo "[$SCRIPT_NAME] OK: entrypoint.sh already contains the fix"
else
    if [ ! -f docker/entrypoint.sh ]; then
        echo "[$SCRIPT_NAME] ERROR: docker/entrypoint.sh not found"
        exit 1
    fi
    cp docker/entrypoint.sh docker/entrypoint.sh.bak

    python3 - <<'PYEOF'
path = "docker/entrypoint.sh"
with open(path) as f:
    content = f.read()

inject = '''
echo "[entrypoint] Fixing nginx tmp permissions..."
mkdir -p /var/lib/nginx/tmp /var/log/nginx
chown -R www-data:www-data /var/lib/nginx /var/log/nginx 2>/dev/null || true
chmod -R 755 /var/lib/nginx /var/log/nginx 2>/dev/null || true
'''

marker = 'echo "[entrypoint] Optimizing..."'
if marker in content and "Fixing nginx tmp permissions" not in content:
    content = content.replace(marker, inject + "\n" + marker, 1)
    with open(path, "w") as f:
        f.write(content)
    print("Patched")
else:
    print("Already patched or marker not found")
PYEOF

    echo "[$SCRIPT_NAME] entrypoint.sh patched (backup at docker/entrypoint.sh.bak)"
fi

echo "[$SCRIPT_NAME] [3/4] Rebuilding app image (no cache)..."
docker compose -f "$COMPOSE_FILE" build --no-cache app

echo "[$SCRIPT_NAME] [4/4] Restarting container..."
docker compose -f "$COMPOSE_FILE" up -d app

echo "[$SCRIPT_NAME] Verifying..."
sleep 3
docker compose -f "$COMPOSE_FILE" exec -T app sh -c '
    echo "--- /var/www/public/storage ---"
    ls -la /var/www/public/storage 2>&1 | head -2
    echo "--- /var/lib/nginx/tmp ---"
    ls -la /var/lib/nginx/tmp 2>&1 | head -2
'

echo "[$SCRIPT_NAME] === Done. Try uploading an image now. ==="
