# 🏆 TFD - Trif Factory Depok
### *Premium Thrift E-Commerce & Smart Logistics Suite*

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/tailwindcss-%2338B2AC.svg?style=for-the-badge&logo=tailwind-css&logoColor=white)
![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)

**TFD (Trif Factory Depok)** adalah platform e-commerce eksklusif yang dirancang khusus untuk industri thrift fashion kelas atas. Aplikasi ini menggabungkan estetika desain premium dengan sistem logistik cerdas untuk memberikan pengalaman belanja yang mulus dan profesional.

---

## ✨ Fitur Utama

### 🚛 Smart Logistics Suite
- **Professional Shipping Labels**: Cetak label pengiriman otomatis format A6/A7 lengkap dengan branding TFD.
- **Smart Tracking Links**: Pelacakan paket satu-klik (JNE, J&T, Sicepat) langsung dari dashboard pelanggan.
- **Auto-Status Management**: Pembaruan status otomatis menjadi "Dikirim" saat nomor resi diinput oleh admin.
- **Demo Mode**: Fitur "Magic Resi" untuk melakukan simulasi proses logistik saat presentasi/demo.

### 💳 Transaction & Payments
- **Dynamic Checkout**: Penghitungan ongkir otomatis berdasarkan kurir yang dipilih.
- **QRIS Payment Integration**: Pembayaran modern dengan alur verifikasi bukti bayar yang intuitif.
- **Automated Invoicing**: Dashboard pelanggan lengkap dengan riwayat transaksi dan invoice digital.

### 💬 Real-time Interaction
- **Staff-Customer Chat**: Sistem komunikasi langsung antara pelanggan dan admin/petugas untuk konsultasi produk.
- **Product Reviews**: Sistem ulasan produk berbasis rating bintang dan testimoni pelanggan.

---

## 🛠️ Tech Stack & Architecture
- **Framework**: Laravel 12.x (The latest & fastest)
- **Frontend**: Tailwind CSS (Custom Premium Dark Theme)
- **Icons**: Lucide Icons
- **Database**: MySQL / MariaDB

---

## 🚀 Panduan Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/Ipan2007/TFD.git
   cd TFD
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Environment Setup**
   - Salin `.env.example` menjadi `.env`
   - Sesuaikan konfigurasi database Anda.
   ```bash
   php artisan key:generate
   php artisan storage:link
   ```

4. **Database & Seeding**
   Jalankan perintah ini untuk membuat struktur tabel dan mengisi data awal (akunya admin, produk, dll).
   ```bash
   php artisan migrate:fresh --seed
   ```

---

## 🔐 Default Credentials (Untuk Testing)

Gunakan akun di bawah ini untuk mengakses dashboard sesuai level otoritas:

| Role | Email | Password |
| :--- | :--- | :--- |
| **Administrator** | `admin@tfd.com` | `password123` |
| **Petugas (Staff)** | `petugas@tfd.com` | `password123` |
| **Customer** | `user@tfd.com` | `password123` |

---

## 📸 Preview Design
*Website ini menggunakan palet warna **Zinc & Emerald** dengan efek glasmorphism untuk menciptakan kesan mewah dan eksklusif.*

---

© 2026 **TRIP FACTORY DEPOK (TFD)**. Developed for Academic & Professional Demonstration.
