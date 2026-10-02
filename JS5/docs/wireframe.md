# USERFLOW dan WIREFRAME SIMPUS-MINI
## Aktor Sistemnya
- **Tamu**: Hanya bisa melihat katalog buku (Beranda, Daftar Buku) tanpa login.
- **Petugas**: Login untuk mengakses seluruh fitur CRUD dan transaksi peminjaman/pengembalian.
## Userflow
### 1. Peminjaman Buku
```
> [Petugas Login] -> [Dashboard] -> [Pilih menu "Peminjaman Baru"] -> [Pilih Anggota] -> [Pilih Buku (stok > 0)] -> [Simpan] -> [Stok buku berkurang 1] -> [Kembali ke Dashboard]
```

### 2. Pengembalian Buku
```
> [Dashboard] -> [Menu "Pengembalian"] -> [Cari transaksi aktif (anggota/buku)] -> [Tandai "Dikembalikan"] -> [Stok buku bertambah 1] -> [Kembali ke Dashboard]
```

### 3. Pencarian anggota yang tunggakannya sudah lewat jatuh tempo -- latiham tambahan 2.
```
> [Petugas Login] -> [Dashboard] -> [Pilih menu "Anggota"] -> [Klik Filter "Tunggakan / Terlambat"] -> [Sistem Menampilkan Daftar Anggota Menunggak] -> [Petugas Pilih Anggota] -> [Lihat Detail Riwayat & Denda] -> [Kirim Notifikasi / Cetak Tagihan]
```

## Wireframe
### 1. Halaman Login
```
+-------------------------------------------------------+
|                     SIMPUS-Mini                       |
+-------------------------------------------------------+
|                                                       |
|                  [ Login Petugas ]                    |
|                                                       |
|         Username : [________________________]         |
|                                                       |
|         Password : [________________________]         |
|                                                       |
|                      [ Masuk ]                        |
|                                                       |
|           Belum punya akun? Daftar di sini            |
+-------------------------------------------------------+
```

### 2. Dashboard Petugas
```
+----------------------------------------------------------------------------+
| SIMPUS-Mini  Beranda | Buku | Anggota | Peminjaman | (Nama Petugas) Logout |
+----------------------------------------------------------------------------+
|                                                                            |
|      [Total Buku]           [Total Anggota]        [Sedang Dipinjam]       |
|                                                                            |
|      Aksi Cepat:                                                           |
|      [+ Peminjaman Baru]   [+ Pengembalian]                                |
|                                                                            |
|      Transaksi Terbaru                                                     |
|      +--------------------------------------------------------------+      |
|      |    Anggota   |       Buku       | Tgl Pinjam | Status        |      |
|      +--------------+------------------+------------+---------------+      |
|      | Otto Oct.    |  Laskar Pelangi  | 01/07/2024 | Dipinjam      |      |
|      +--------------------------------------------------------------+      |
|                                                                            |
+----------------------------------------------------------------------------+
```

### 3. Form Peminjaman Buku
```
+-------------------------------------------------------+
| Form Peminjaman Buku                                  |
+-------------------------------------------------------+
|                                                       |
| Anggota       : [ dropdown pilih anggota ]            |
|                                                       |
| Buku          : [ dropdown, hanya stok>0 ]            |
|                                                       |
| Tanggal Pinjam: [ auto: hari ini ]                    |
|                                                       |
|             [ Simpan Peminjaman ]                     |
+-------------------------------------------------------+
```

### 4. Form Pengembalian Buku
```
+----------------------------------------------------+
| Pengembalian Buku                                  |
+----------------------------------------------------+
|                                                    |
| Cari transaksi aktif:                              |
| [ nama anggota / judul buku_____________________]  |
|                                                    |
|                                                    |
|  Anggota  |  Buku  |  Tgl Pinjam  |  [Kembalikan]  |
|                                                    |
+----------------------------------------------------+
```

### 5. Riwayat Peminjaman per Anggota
```
+--------------------------------------------------------------+
|  Riwayat Peminjaman - Otto Oct.                              |
+--------------------------------------------------------------+
|                                                              |
|  +--------------------------------------------------------+  |
|  | Buku            | Pinjam     | Kembali    | Status     |  |
|  +-----------------+------------+------------+------------+  |
|  | Laskar Pelangi  | 01/07/2024 | 07/07/2024 | Selesai    |  |
|  +--------------------------------------------------------+  |
|                                                              |
+--------------------------------------------------------------+
```

### 6. Registrasi Anggota Baru -- latihan tambahan 1
```
+-------------------------------------------------------+
|                      SIMPUS-Mini                      |
+-------------------------------------------------------+
|                                                       |
|              [ Registrasi Anggota Baru ]              |
|                                                       |
|       Nama Lengkap : [________________________]       |
|                                                       |
|       Email        : [________________________]       |
|                                                       |
|       No. Telepon  : [________________________]       |
|                                                       |
|                                                       |
|                 [ Daftar Sekarang ]                   |
|                                                       |
|            Sudah punya akun? Login di sini            |
+-------------------------------------------------------+
```

####
Note: dibuat berdasarkan Js4 - Wireframe & User Flow dan Js4 - UI-UX Design
