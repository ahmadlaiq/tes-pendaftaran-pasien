# Dokumentasi RESTful API - Sistem Pendaftaran Pasien

Dokumentasi ini menjelaskan endpoint API yang tersedia, parameter yang dibutuhkan, serta format response.

## Informasi Dasar
- **Base URL**: `http://localhost/api`
- **Format Response**: JSON
- **Autentikasi**: Laravel Sanctum (Token-based). Gunakan header `Authorization: Bearer {token}` untuk semua endpoint kecuali login.

---

## 1. Autentikasi

### Login
Digunakan untuk mendapatkan token akses.

- **URL**: `/login`
- **Method**: `POST`
- **Payload**:
  ```json
  {
      "email": "admin@klinik.com",
      "password": "password"
  }
  ```
- **Response (200 OK)**:
  ```json
  {
      "status": "success",
      "message": "Login berhasil",
      "data": {
          "token": "1|abcde...",
          "user": { ... }
      }
  }
  ```

---

## 2. Manajemen Pasien

### Daftar Pasien
Mengambil daftar pasien dengan pagination.

- **URL**: `/pasien`
- **Method**: `GET`
- **Params**: 
  - `q` (Optional): Pencarian berdasarkan Nama atau NIK.
- **Response (200 OK)**:
  ```json
  {
      "status": "success",
      "message": "Daftar pasien berhasil diambil",
      "data": {
          "data": [
              {
                  "id": 1,
                  "nama_lengkap": "Budi Santoso",
                  "nik": "1234567890123456",
                  "tanggal_lahir": "1990-01-01",
                  "jenis_kelamin": "Laki-laki",
                  "alamat": "Jl. Merdeka",
                  "nomor_telepon": "0812..."
              }
          ],
          "links": { ... },
          "meta": { ... }
      }
  }
  ```

### Tambah Pasien Baru
- **URL**: `/pasien`
- **Method**: `POST`
- **Payload**:
  ```json
  {
      "nama_lengkap": "Ani Wijaya",
      "nik": "3201234567890001",
      "tanggal_lahir": "1995-05-15",
      "jenis_kelamin": "Perempuan",
      "alamat": "Jl. Mawar No. 10",
      "nomor_telepon": "08571234567"
  }
  ```
- **Response (201 Created)**:
  ```json
  {
      "status": "success",
      "message": "Pasien berhasil ditambahkan",
      "data": { "id": 2, "nama_lengkap": "Ani Wijaya", ... }
  }
  ```

### Detail Pasien
- **URL**: `/pasien/{id}`
- **Method**: `GET`

### Update Pasien
- **URL**: `/pasien/{id}`
- **Method**: `PUT`
- **Payload**: Sama dengan POST (semua field bersifat optional/sometimes).

### Hapus Pasien
- **URL**: `/pasien/{id}`
- **Method**: `DELETE`

---

## 3. Pendaftaran Kunjungan

### Buat Pendaftaran Baru
- **URL**: `/pendaftaran`
- **Method**: `POST`
- **Payload**:
  ```json
  {
      "pasien_id": 1,
      "poli_id": 2,
      "tanggal_kunjungan": "2026-04-28",
      "keluhan": "Sakit gigi geraham kanan"
  }
  ```
- **Response (201 Created)**:
  ```json
  {
      "status": "success",
      "message": "Pendaftaran berhasil dibuat",
      "data": {
          "id": 10,
          "pasien": { ... },
          "poli": "Poli Gigi",
          "nomor_antrian": 5,
          "status": "Menunggu"
      }
  }
  ```

### Daftar Kunjungan
- **URL**: `/pendaftaran`
- **Method**: `GET`
- **Params**:
  - `tanggal` (Optional): Filter berdasarkan tanggal (YYYY-MM-DD).
  - `poli_id` (Optional): Filter berdasarkan ID Poli.
- **Response (200 OK)**: Daftar pendaftaran ter-paginate.

### Ubah Status Kunjungan
- **URL**: `/pendaftaran/{id}/status`
- **Method**: `PATCH`
- **Payload**:
  ```json
  {
      "status": "Dilayani"
  }
  ```
  *Opsi status: Menunggu, Dilayani, Selesai.*
