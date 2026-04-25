# Sapi Berkah Amanah - API Documentation & Frontend Guide

Dokumen ini berisi panduan penggunaan REST API Backend untuk mempermudah tim Frontend dalam mengintegrasikan data. Harap perhatikan bagian **Perubahan Struktur Data** terkait adanya fitur baru (Kambing & Domba).

---

## ⚠️ PERHATIAN: Perubahan Struktur Data (PENTING!)

Mulai versi terbaru, sistem tidak hanya menjual Sapi, tetapi juga Kambing dan Domba. Oleh karena itu, skema penamaan data telah diubah agar lebih umum (baku).

Saat ini, API **masih menyediakan** kunci (*keys*) versi lama agar Frontend yang sedang berjalan tidak *error* (Backward Compatibility). Namun, **kunci lama tersebut akan segera dihapus**. Tim Frontend **DIWAJIBKAN** untuk segera bermigrasi ke kunci data yang baru.

| Kunci Lama (DEPRECATED) ❌ | Kunci Baru (STANDAR) ✅ | Penjelasan |
| :--- | :--- | :--- |
| `jenis_sapi` | **`nama`** | Nama hewannya (misal: "Limosin", "Brahman", "Etawa") |
| `berat_sapi` | **`berat`** | Berat hewan dalam satuan Kilogram (kg) |
| `umur_sapi` | **`umur`** | Umur hewan dalam satuan Tahun |
| *(Belum ada)* | **`jenis_hewan`** | Jenis spesifiknya: `"sapi"`, `"kambing"`, atau `"domba"` |

💡 **Tips untuk Frontend:**
Gunakan nilai `jenis_hewan` untuk memisahkan section katalog di halaman web (contoh: memfilter array `data.filter(item => item.jenis_hewan === 'kambing')`).

---

## 📌 Endpoint API Utama

### 1. Ambil Semua Katalog Hewan (List)
- **URL**: `/api/katalog`
- **Method**: `GET`
- **Deskripsi**: Mengambil seluruh data hewan kurban (Sapi, Kambing, Domba) yang berstatus **Tersedia**.

**Contoh Response Sukses (200 OK):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "jenis_hewan": "sapi",
      "nama": "Limosin Super",
      "kategori": "sultan",
      "berat": 650,
      "umur": 3,
      "harga": 35000000,
      "photos": [
        "http://domainanda.com/storage/photos/sapi1.jpg",
        "http://domainanda.com/storage/photos/sapi2.jpg"
      ]
    },
    {
      "id": 2,
      "jenis_hewan": "kambing",
      "nama": "Etawa Super",
      "kategori": "prime",
      "berat": 45,
      "umur": 1,
      "harga": 4500000,
      "photos": [
        "http://domainanda.com/storage/photos/kambing1.jpg"
      ]
    }
  ]
}
```

### 2. Detail Hewan Kurban
- **URL**: `/api/katalog/{id}`
- **Method**: `GET`
- **Deskripsi**: Mengambil detail satu hewan kurban berdasarkan ID, mencakup deskripsi lengkap dan URL video.

**Contoh Response Sukses (200 OK):**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "jenis_hewan": "sapi",
    "nama": "Limosin Super",
    "kategori": "sultan",
    "berat": 650,
    "umur": 3,
    "harga": 35000000,
    "deskripsi": "Sapi sehat walafiat rawatan khusus.",
    "video_url": "https://youtube.com/watch?v=xxxxx",
    "photos": [
      "http://domainanda.com/storage/photos/sapi1.jpg"
    ]
  }
}
```

---

## 💡 Format Pesan WhatsApp Dinamis (Saran UI/UX)
Dengan adanya `jenis_hewan` dan `nama`, saat user menekan tombol "Pesan Sekarang", Frontend bisa membuat pesan otomatis yang dinamis seperti ini:

```javascript
// Contoh di Vue/React/JS murni
const textWa = `Halo, saya tertarik untuk memesan ${item.jenis_hewan} jenis ${item.nama} (${item.kategori}) dengan berat ${item.berat}kg. Apakah masih tersedia?`;
```
*Hasil Output:* "Halo, saya tertarik untuk memesan kambing jenis Etawa Super (prime) dengan berat 45kg. Apakah masih tersedia?"
