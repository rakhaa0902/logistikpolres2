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
    users ||--o{ riwayats : "mencatat (1:N)"
    barangs ||--o{ riwayats : "memiliki (1:N)"
    
    users {
        bigint id PK
        varchar name
        varchar email UK
        enum role "admin, petugas"
    }

    barangs {
        bigint id PK
        varchar kode_barang UK
        varchar nama_barang
        varchar kategori
        int jumlah
        varchar satuan
        varchar gambar
    }

    riwayats {
        bigint id PK
        bigint barang_id FK
        bigint user_id FK
        enum jenis_transaksi "masuk, keluar"
        int jumlah
        text keterangan
        timestamp created_at
    }
