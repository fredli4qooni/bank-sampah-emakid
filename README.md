# Bank Sampah Emakid

> Platform digital untuk Bank Sampah — pencatatan nasabah, transaksi setor sampah, penarikan saldo, dokumentasi, dan chatbot panduan.

Laravel 13 • PHP 8.4 • MySQL 8.

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
| DB       | MySQL 8.4                                     |
| Frontend | Blade + Tailwind + Vite, Alpine               |
| Auth     | Laravel Breeze                                |
| Export   | barryvdh/laravel-dompdf, maatwebsite/excel    |

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

## 📂 Struktur

```
.
├── app/
│   ├── Http/
│   ├── Models/
│   └── services/          # ChatbotService, dll
└── database/migrations/
```

---

## 🔐 Environment penting

| Variable                     | Keterangan                                 |
|------------------------------|--------------------------------------------|
| `APP_KEY`                    | Wajib di-set                               |
| `APP_URL`                    | URL publik (untuk asset, link email)       |
| `DB_*`                       | Kredensial MySQL                           |
| `SESSION/CACHE/QUEUE_DRIVER` | Disarankan `database`                      |

---

## 📜 Lisensi

MIT © Bank Sampah Emakid