# 📦 Management Inventaris (Laravel API + Vue SPA)
---
Website ini adalah sistem manajemen data inventaris perusahaan berbasis **Laravel REST API** dan **Vue.js Single Page Application (SPA)**.

Aplikasi ini digunakan untuk mengelola:

* Data anggota (pegawai)
* Data inventaris barang
* Status kondisi barang
* Riwayat peminjaman barang
* Upload dokumen/foto inventaris
* Dashboard analytics inventaris

Project ini dibuat sebagai implementasi:

* RESTful API
* Bearer Token Authentication
* Relational Database Design
* Single Page Application Architecture

---

## ✨ Fitur Utama

### 🔐 Autentikasi

* Login menggunakan Bearer Token (Laravel Sanctum)
* Setiap request API dilindungi autentikasi

### 👥 Management Anggota

* Tambah anggota
* Edit anggota
* Hapus anggota
* Relasi ke Departemen & Jabatan

### 📦 Management Inventaris

* Tambah inventaris
* Edit inventaris
* Hapus inventaris
* Assign inventaris ke anggota
* Generate kode inventaris otomatis

### 📎 Upload File Inventaris

* Multiple file upload
* Upload foto barang
* Upload invoice/garansi
* Penyimpanan file menggunakan Laravel Storage

### 📊 Dashboard Analytics

Menampilkan:

* Total inventaris
* Barang Baik
* Barang Rusak
* Barang Dilelang
* Barang Tidak Dipakai
* Diagram batang (bar chart)

---

## 🧰 Teknologi yang Digunakan

### Backend

* Laravel 12
* Laravel Sanctum (Bearer Token Auth)
* RESTful API
* Eloquent ORM

### Frontend

* Vue 3 (Composition API)
* Vue Router
* Axios
* TailwindCSS
* Chart.js

### Database

* MySQL
* Relational Database (3NF Normalization)

---

## 🏗️ Arsitektur Sistem

Aplikasi menggunakan arsitektur **SPA + REST API terpisah**

Frontend (Vue) ⟶ Axios ⟶ REST API (Laravel) ⟶ Database (MySQL)

Keuntungan:

* Frontend dan backend dapat dikembangkan terpisah
* Lebih aman
* Lebih scalable
* Mudah dibuat mobile app di masa depan
---

## ✨ Fitur Utama

### 1. Authentication (Bearer Token)

* Login menggunakan email & password
* Setiap request API wajib membawa token
* Token disimpan di LocalStorage

---

### 2. Management Anggota

Fungsi:

* Tambah anggota
* Edit anggota
* Hapus anggota
* List anggota

Relasi:

```
Member -> Department
Member -> Position
```

---

### 3. Management Inventaris

Fungsi:

* Tambah data inventaris
* Edit data inventaris
* Hapus data inventaris
* Assign barang ke anggota
* Upload multiple file (foto/dokumen)
* Generate kode inventaris otomatis

Relasi:

```
Inventory -> Member
Inventory -> InventoryFiles
```

Status barang:

* baik
* rusak
* tidak_dipakai
* dilelang

---

### 4. Upload File

Inventaris mendukung:

* Multiple upload
* Foto barang
* Dokumen pembelian
* Invoice

File disimpan di:

```
storage/app/public/inventories
```

---

### 5. Dashboard Analytics

Menampilkan:

* Total barang
* Barang Baik
* Barang Rusak
* Barang Dilelang
* Barang Tidak Dipakai
* Diagram Bar Chart

---

## 🗄️ Struktur Database (ERD Sederhana)

![ERD](https://raw.githubusercontent.com/chandrakarim/Botika-Inventory/main/ERD.png)
```
departments
    id
    name

positions
    id
    name

members
    id
    name
    department_id
    position_id

inventories
    id
    inventory_code
    name
    type
    serial_number
    specification
    status
    member_id

inventory_files
    id
    inventory_id
    file_name
    file_path
    file_type
    file_size
```

Relasi:

* 1 Member memiliki banyak Inventaris
* 1 Inventaris memiliki banyak File

---
## 📊 Penjelasan ERD (Entity Relationship Diagram)

Sistem ini menggunakan database relasional (MySQL) yang sudah dinormalisasi untuk menghindari duplikasi data.

### 1. Members

Menyimpan data pengguna/pegawai yang dapat memegang inventaris.

Field penting:

* name → nama anggota
* department_id → relasi ke departemen
* position_id → relasi ke jabatan

Relasi:

* 1 Member dapat memiliki banyak Inventaris

---

### 2. Departments

Menyimpan data departemen perusahaan.

Contoh:

* IT
* HRD
* Finance

Relasi:

* 1 Department memiliki banyak Members

---

### 3. Positions

Menyimpan jabatan anggota.

Contoh:

* Staff
* Supervisor
* Manager

Relasi:

* 1 Position memiliki banyak Members

---

### 4. Inventories

Menyimpan data barang inventaris perusahaan.

Field penting:

* inventory_code → kode unik barang
* serial_number → nomor seri perangkat
* status → kondisi barang
* member_id → pemilik/peminjam barang

Relasi:

* 1 Inventaris dimiliki oleh 1 Member
* 1 Inventaris memiliki banyak file lampiran

---

### 5. Inventory Files

Menyimpan file yang berkaitan dengan inventaris.

Contoh:

* Foto barang
* Invoice pembelian
* Dokumen garansi

Relasi:

* 1 Inventaris memiliki banyak file (one to many)

---

### Normalisasi Database

Database sudah memenuhi minimal **3rd Normal Form (3NF)**:

* Data departemen dipisah dari member
* Data jabatan dipisah dari member
* Data file dipisah dari inventaris

Tujuannya:

* Menghindari redundansi data
* Mempercepat query
* Mempermudah maintenance database


# ⚙️ Cara Menjalankan Project

## 1. Clone Project

```
git clone <repository-url>
cd backend
```

---

## 2. Install Dependency Backend

```
composer install
```

---

## 3. Copy Environment

```
cp .env.example .env
```

---

## 4. Generate Key

```
php artisan key:generate
```

---

## 5. Setting Database (.env)

Buka `.env` lalu ubah:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventaris_db
DB_USERNAME=root
DB_PASSWORD=
```

Buat database baru di phpMyAdmin:

```
inventaris_db
```

---

## 6. Setup Database & Seeder

Jalankan perintah berikut:

```
php artisan migrate:fresh --seed
```

Perintah ini akan:

* Membuat seluruh tabel database
* Mengisi data awal (dummy data)
* Membuat akun login otomatis
* Mengisi data anggota & inventaris contoh
* Analytics langsung dapat ditampilkan

> ⚠️ Catatan:
> `migrate:fresh` akan menghapus seluruh isi database lalu membuat ulang dari awal.
> Aman digunakan karena project ini menggunakan database baru.

---

### Akun Login Default

Setelah seeder dijalankan, gunakan akun berikut:

```
Email    : admin@example.com
Password : password
```

---

## 7. Storage Link (WAJIB untuk upload file)

```
php artisan storage:link
```

---

## 8. Jalankan Backend API

```
php artisan serve
```

Backend berjalan di:

```
http://127.0.0.1:8000
```

---

# 🌐 Menjalankan Frontend

Masuk ke folder frontend:

```
cd frontend
```

## Install Dependency

```
npm install
```

## Jalankan Vue

```
npm run dev
```

Frontend berjalan di:

```
http://localhost:5173
```

---
## 🌐 URL Aplikasi

Frontend:
http://localhost:5173

Backend API:
http://127.0.0.1:8000/api

---

## 📮 Dokumentasi API (Postman)

Dokumentasi API tersedia dalam bentuk **Postman Collection**.

### Cara Menggunakan

1. Download file collection:

```
postman/Bontika Test.postman_collection
```

2. Buka aplikasi **Postman**

3. Klik **Import**

4. Pilih file:

```
Bontika Test.postman_collection
```

5. Jalankan request **Login** terlebih dahulu untuk mendapatkan token.

6. Copy token dari response login.

7. Masukkan token ke setiap request pada tab:

Authorization → Bearer Token

```
Bearer YOUR_TOKEN_HERE
```

---

### Endpoint Utama

#### Auth

| Method | Endpoint   | Keterangan |
| ------ | ---------- | ---------- |
| POST   | /api/login | Login user |

#### Members

| Method | Endpoint          |
| ------ | ----------------- |
| GET    | /api/members      |
| POST   | /api/members      |
| PUT    | /api/members/{id} |
| DELETE | /api/members/{id} |

#### Inventories

| Method | Endpoint              |
| ------ | --------------------- |
| GET    | /api/inventories      |
| POST   | /api/inventories      |
| PUT    | /api/inventories/{id} |
| DELETE | /api/inventories/{id} |

#### Analytics

| Method | Endpoint       |
| ------ | -------------- |
| GET    | /api/analytics |

---

### Upload File Inventaris

Endpoint:

```
POST /api/inventories
```

Body:

```
form-data
```

Field:

* name (text)
* type (text)
* serial_number (text)
* specification (text)
* status (text)
* member_id (number)
* files[] (file) ← multiple upload

# 🔐 Cara Login

Login melalui halaman:

```
/login
```

Setelah login:

* Server memberikan Bearer Token
* Token otomatis dipakai di semua request API

---

# 📡 API Endpoint

## Auth

| Method | Endpoint   | Fungsi          |
| ------ | ---------- | --------------- |
| POST   | /api/login | Login user      |
| GET    | /api/me    | Ambil data user |

---

## Members

| Method | Endpoint          |
| ------ | ----------------- |
| GET    | /api/members      |
| POST   | /api/members      |
| PUT    | /api/members/{id} |
| DELETE | /api/members/{id} |

---

## Inventories

| Method | Endpoint              |
| ------ | --------------------- |
| GET    | /api/inventories      |
| POST   | /api/inventories      |
| PUT    | /api/inventories/{id} |
| DELETE | /api/inventories/{id} |

---

## Analytics

| Method | Endpoint       |
| ------ | -------------- |
| GET    | /api/analytics |

---

# 🧪 Testing API

Gunakan:

* Postman
* Import collection (optional)

Header wajib:

```
Authorization: Bearer {token}
Accept: application/json
```

---

# ⚠️ Troubleshooting

Jika data tidak muncul / blank putih:

Jalankan:

```
php artisan optimize:clear
```

Lalu refresh:

```
CTRL + SHIFT + R
```

---

# 📌 Note

Project ini menggunakan:

* RESTful API
* Bearer Token Authentication
* Relational Database
* SPA Architecture
* Multiple File Upload

---

# 👨‍💻 Author

Nama : (Chandra Karim)
Project : Ujian / Technical Test - Management Inventaris
---
## Example Dashboard Analytics
![Dashboard_Analytics](https://raw.githubusercontent.com/chandrakarim/Botika-Inventory/main/Dashboard_Analytics.png)

## Dashboard Members
![Dashboard_Members](https://raw.githubusercontent.com/chandrakarim/Botika-Inventory/main/Dashboard_Members.png)

## Dashboard Data Inventory
![Dashboard_Data_inventory](https://raw.githubusercontent.com/chandrakarim/Botika-Inventory/main/Dashboard_Data_inventory.png)
