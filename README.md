# Bank Sampah Emakid

> Platform digital untuk Bank Sampah — pencatatan nasabah, transaksi setor sampah, penarikan saldo, dokumentasi, dan chatbot panduan.

Laravel 13 • PHP 8.4 • MySQL 8 • Docker • CI/CD via GitHub Actions • Cloudflare Tunnel.

---

## ✨ Fitur

- Manajemen **Unit / Nasabah** dengan saldo realtime
- **Setor & tarik saldo** dengan validasi admin
- **Jenis sampah** + harga per kategori
- **Laporan** PDF (DomPDF) & export Excel (Maatwebsite)
- **FAQ + Chatbot** rules (rule-based, tanpa API key)
- **Audit trail** koreksi transaksi
- **Backup log** operasional
- Multi-role auth (Breeze)

---

## 🧱 Stack

| Layer    | Tech                                          |
|----------|-----------------------------------------------|
| Backend  | Laravel 13.8, PHP 8.4                         |
| DB       | MySQL 8.4 (shared `infra-mysql` instance)     |
| Frontend | Blade + Tailwind + Vite, Alpine               |
| Auth     | Laravel Breeze                                |
| Export   | barryvdh/laravel-dompdf, maatwebsite/excel    |
| Runtime  | Docker (php-fpm + nginx + supervisor)         |
| Deploy   | GHCR + GitHub Actions + Cloudflare Tunnel     |

---

## 🛠️ Local Development

```bash
git clone https://github.com/fredli4qooni/bank-sampah-emakid.git
cd bank-sampah-emakid

cp .env.example .env
composer install
npm install
touch database/database.sqlite

php artisan key:generate
php artisan migrate --seed
npm run build    # atau: npm run dev

php artisan serve    # http://127.0.0.1:8000
```

Atau full dev (server + queue + logs + vite):

```bash
composer run dev
```

---

## 🐳 Production (Docker)

### Arsitektur

```
Cloudflare Edge ──► cloudflared (sidecar)
                          │
                          ▼
                     nginx :80 ──► php-fpm (Laravel)
                                       │
                                       ▼
                              infra-mysql (shared network: db-shared)
```

- Image dipush ke **GHCR**: `ghcr.io/fredli4qooni/bank-sampah-emakid`
- Setiap push ke `main` / tag → build → push → deploy via SSH
- Network `db-shared` (external) dipakai bersama infra-mysql
- `cloudflared` tunnel sidecar, tanpa expose port publik

### Server layout

```
~/sewa/bank-sampah-emakid/
├── docker-compose.prod.yml
├── .env                       # production secrets
└── (no source — pulled dari GHCR)
```

DB di server (sudah dibuat):

- **Database**: `bank_sampah_emakid`
- **User**: `bse_user`
- **Host**: `infra-mysql` (container name, di network `db-shared`)

### Setup server (sekali)

1. Buat folder:
   ```bash
   mkdir -p ~/sewa/bank-sampah-emakid && cd ~/sewa/bank-sampah-emakid
   ```

2. Copy `.env.production.example` → `.env` di server, lalu edit:
   ```bash
   # Generate APP_KEY lokal lalu paste:
   php artisan key:generate --show
   ```
   Isi `APP_KEY`, `CLOUDFLARE_TUNNEL_TOKEN`.

3. Copy `docker-compose.prod.yml` ke server (atau biarkan CI yang menarik dari repo).

4. Tarik & jalankan pertama kali manual:
   ```bash
   docker compose -f docker-compose.prod.yml pull app
   docker compose -f docker-compose.prod.yml up -d app cloudflared
   docker logs -f bank-sampah-emakid-app
   ```

---

## 🔁 CI/CD (GitHub Actions)

Workflow: `.github/workflows/deploy.yml`

**Trigger**:
- push ke `main`
- push tag `v*.*.*`
- manual `workflow_dispatch`

**Pipeline**:
1. Build multi-stage Docker image (composer + node + php-fpm)
2. Push ke GHCR (`ghcr.io/<owner>/bank-sampah-emakid:<tag>`)
3. SSH ke server → pull → up → prune

### GitHub Secrets yang dibutuhkan

| Secret                      | Value                              |
|-----------------------------|------------------------------------|
| `SSH_HOST`                  | IP/hostname server                 |
| `SSH_USER`                  | `ubuntu`                           |
| `SSH_PASSWORD`              | server password                    |
| `SSH_PORT`                  | `22` (optional)                    |
| `CLOUDFLARE_TUNNEL_TOKEN`   | token dari dashboard Cloudflare    |

> ⚠️ Pakai SSH key lebih aman dari password. Ganti `appleboy/ssh-action` ke mode `key` + secret `SSH_KEY` bila sudah siap.

---

## 🌐 Cloudflare Tunnel

1. Cloudflare Zero Trust → **Networks → Tunnels** → Create
2. Type: `Cloudflared`
3. Public hostname: mis. `banksampahemakid.my.id` → `http://bank-sampah-emakid-app:80`
4. Copy token → paste ke `.env` server sebagai `CLOUDFLARE_TUNNEL_TOKEN`

Container `cloudflared` akan auto-connect; container `app` listen di port 80 internal (tidak dipublish ke host).

---

## 📦 Build lokal image (opsional)

```bash
docker build -t bank-sampah-emakid:dev .
docker run --rm -p 8080:80 --env-file .env bank-sampah-emakid:dev
```

---

## 📂 Struktur

```
.
├── app/
│   ├── Http/
│   ├── Models/
│   └── services/          # ChatbotService, dll
├── database/migrations/
├── docker/
│   ├── entrypoint.sh
│   ├── nginx.conf
│   ├── php.ini
│   └── supervisord.conf
├── docker-compose.prod.yml
├── Dockerfile
└── .github/workflows/deploy.yml
```

---

## 🔐 Environment penting

| Variable                     | Keterangan                                 |
|------------------------------|--------------------------------------------|
| `APP_KEY`                    | Wajib di-set                               |
| `APP_URL`                    | URL publik (untuk asset, link email)       |
| `DB_*`                       | MySQL di network `db-shared`               |
| `SESSION/CACHE/QUEUE_DRIVER` | Disarankan `database`                      |
| `CLOUDFLARE_TUNNEL_TOKEN`    | Token dari dashboard tunnel                |

---

## 📜 Lisensi

MIT © Bank Sampah Emakid