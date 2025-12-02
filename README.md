# 📑 Dokumentasi Proyek logistikpolres
Sistem Informasi Manajemen Logistik Kepolisian Resor (SIMLOG POLRES)

---

## 💡 Konsep Sistem

**SIMLOG POLRES** adalah sistem berbasis web yang dibangun menggunakan Framework **Laravel** untuk mendigitalisasi proses pengelolaan stok barang dan aset di divisi logistik Polres.

Tujuan utama pengembangan sistem ini adalah:
- **Digitalisasi Inventaris:** Menggantikan pencatatan manual (buku/kertas) menjadi database terpusat.
- **Real-time Monitoring:** Memantau ketersediaan stok barang dinas (seragam, ATK, peralatan) secara akurat.
- **Histori Transaksi:** Mencatat setiap pergerakan barang (masuk/keluar) dengan detail waktu dan penanggung jawab.
- **Efisiensi:** Mempercepat proses pelaporan stok opname.

---

## 🚀 Fitur Utama

### 🏠 Dashboard Utama
- Statistik total barang.
- Informasi stok menipis (Low Stock Alert).
- Grafik riwayat transaksi (opsional).

### 📦 Manajemen Barang
- Data Master Barang (Tambah, Edit, Hapus).
- Manajemen Kategori Barang.
- Upload Foto Barang.

### 📝 Transaksi Logistik
- **Barang Masuk:** Mencatat penambahan stok dari pengadaan.
- **Barang Keluar:** Mencatat pengambilan barang oleh personel/divisi lain.
- **Riwayat:** Log aktivitas lengkap (Siapa mengambil apa, kapan, dan berapa banyak).

---

## 🔐 Autentikasi & Keamanan
- Sistem Login Multi-Level (Admin & Petugas).
- Enkripsi Password menggunakan *Bcrypt*.
- Proteksi CSRF (Cross-Site Request Forgery) bawaan Laravel.

---

## 👥 Multi User (Hak Akses)

| Role | Akses Fitur | Deskripsi |
| :--- | :--- | :--- |
| **👮‍♂️ Admin** | *Full Access* | Bisa mengelola user lain, mengedit data master kategori, menghapus riwayat fatal, dan melihat semua laporan. |
| **👤 Petugas** | *Operator* | Fokus pada input barang masuk, barang keluar, dan cek stok harian. Tidak bisa menghapus data master sensitif. |

---

## 🔑 Akun Default (Seeder)

| Role | Email / Username | Password |
|------|------------------|-----------|
| *Admin* | admin@polres.go.id | password |
| *Petugas* | petugas@polres.go.id | password |

---

## 🗂️ ERD (Entity Relationship Diagram)

Berikut adalah struktur database yang menghubungkan User, Barang, dan Riwayat Transaksi:

```mermaid
erDiagram
    %% --- 1. Tabel Utama Proyek ---
    users {
        bigint id PK
        varchar name
        varchar email
        timestamp email_verified_at
        varchar password
        varchar remember_token
        enum role "admin, petugas"
        timestamp created_at
        timestamp updated_at
    }

    barangs {
        bigint id PK
        varchar kode_barang
        varchar nama_barang
        varchar kategori
        int jumlah
        varchar satuan
        varchar kondisi
        varchar gambar
        timestamp created_at
        timestamp updated_at
    }

    riwayats {
        bigint id PK
        bigint barang_id FK
        bigint user_id FK
        enum jenis_transaksi
        int jumlah
        text keterangan
        timestamp created_at
        timestamp updated_at
    }

    kategoris {
        bigint id PK
        varchar nama_kategori
        timestamp created_at
        timestamp updated_at
    }

    %% --- 2. Tabel Bawaan Laravel ---
    migrations {
        int id PK
        varchar migration
        int batch
    }

    failed_jobs {
        bigint id PK
        varchar uuid
        text connection
        text queue
        longtext payload
        longtext exception
        timestamp failed_at
    }

    personal_access_tokens {
        bigint id PK
        varchar tokenable_type
        bigint tokenable_id
        varchar name
        varchar token
        text abilities
        timestamp last_used_at
        timestamp created_at
        timestamp updated_at
    }

    password_reset_tokens {
        varchar email PK
        varchar token
        timestamp created_at
    }

    %% --- 3. Definisi Relasi ---
    users ||--o{ riwayats : "mencatat"
    barangs ||--o{ riwayats : "memiliki"
    ## 🔷 UML Diagram
*(Diagram UML akan muncul otomatis di sini karena menggunakan kode Mermaid di bawah)*

```mermaid
classDiagram
    class User {
        +id: int
        +name: string
        +email: string
        +role: enum
        +riwayats() HasMany
    }

    class Barang {
        +id: int
        +kode_barang: string
        +nama_barang: string
        +jumlah: int
        +riwayats() HasMany
    }

    class Riwayat {
        +id: int
        +user_id: int
        +barang_id: int
        +jenis_transaksi: enum
        +jumlah: int
        +user() BelongsTo
        +barang() BelongsTo
    }

    User "1" --> "*" Riwayat : HasMany
    Barang "1" --> "*" Riwayat : HasMany
