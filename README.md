# SIM-EPK KEPPKN

Aplikasi web untuk pengajuan, telaah, dan administrasi etik penelitian kesehatan (alur KEPK/KEPPKN) berbasis CodeIgniter.

## Stack Teknologi

- **Backend:** PHP (CodeIgniter 3, modular/HMVC style)
- **Database:** MySQL/MariaDB
- **Frontend:** Bootstrap, jQuery, Font Awesome (tema Ace)
- **Dokumen/PDF:** TCPDF (`application/libraries/Pdf.php` + `application/libraries/tcpdf*`)
- **HTTP/API helper:** cURL library (`application/libraries/Curl.php`)
- **Dependency management:** Composer (`vendor/`, `vendor/autoload.php`)

## Fitur Utama

- Manajemen pengajuan protokol etik penelitian.
- Proses telaah etik oleh penelaah dan tim KEPK.
- Alur keputusan (revisi, expedited, full board, exempted, dll).
- Manajemen dokumen administrasi (surat pengantar, surat persetujuan, surat perbaikan, surat pembebasan).
- Generate dokumen PDF untuk kebutuhan surat-menyurat.
- Dashboard dan statistik protokol.
- Manajemen user/profil dan struktur tim.
- Integrasi API internal melalui controller/model `Api`.

## Struktur & Path Penting

### Entry & Core Framework

- `index.php` — entry point aplikasi.
- `application/config/` — konfigurasi utama (`config.php`, `database.php`, `routes.php`, dll).
- `application/core/` — base controller/model custom (`Core_Controller.php`, dll).

### Modul Aplikasi (Fitur Bisnis)

- `application/modules/` — modul-modul fitur utama.
- Contoh modul penting:
	- `application/modules/pengajuan/`
	- `application/modules/protokol/`
	- `application/modules/telaah_awal/`
	- `application/modules/telaah_expedited/`
	- `application/modules/telaah_fullboard/`
	- `application/modules/surat_pembebasan/`
	- `application/modules/surat_persetujuan/`
	- `application/modules/surat_perbaikan/`
	- `application/modules/dashboard/`

### MVC Global

- `application/controllers/` — controller global.
- `application/models/` — model global.
- `application/views/` — view global (contoh: `application/views/v_home.php`).

### Assets & Upload

- `assets/css/`, `assets/js/`, `assets/images/` — static files frontend.
- `uploads/` — file upload dari user/sistem.
- `dokumen_arsip/` — arsip dokumen.

### Data & SQL

- `sim-epk-kepk-v2023.sql`
- `sim-epk-kepk-v202501.sql`

## Setup Singkat (Lokal)

1. Clone project ke web root (contoh: Laragon `www/EPK`).
2. Buat database MySQL lalu import file SQL yang diperlukan.
3. Atur koneksi DB di `application/config/database.php`.
4. Atur `base_url` di `application/config/config.php`.
5. Pastikan web server + PHP + MySQL aktif, lalu akses via browser.

## Catatan

- Beberapa fitur bergantung pada data master dan role user.
- Pastikan folder `uploads/` dan folder cache/log writable sesuai environment server.
