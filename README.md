# Sapi Berkah Amanah

Platform katalog hewan kurban (sapi, kambing, dan domba) dengan booking melalui WhatsApp, pendaftaran reseller, serta pengelolaan hewan melalui dashboard admin.

> **Status:** kode yang ada merupakan baseline implementasi. Fitur checkout online, akun pelanggan, setoran berkala, dan manajemen peternak/reseller lanjutan **masih rencana**; belum dianggap tersedia atau disetujui untuk produksi.

## Teknologi saat ini

- **Frontend pelanggan:** Vue 3, Vite, JavaScript, Tailwind CSS.
- **Backend/API dan panel admin:** PHP 8.2, Laravel 11, Laravel Blade, MySQL.
- **Integrasi:** Cloudinary untuk media; Google Apps Script/Google Sheets untuk data pendaftaran reseller.
- **Autentikasi saat ini:** session untuk web admin dan Laravel Sanctum untuk API admin.

Direktori `frontend/` adalah website pelanggan, sedangkan `backend/` berisi REST API dan panel admin Blade. Booking pelanggan saat ini dilakukan lewat WhatsApp, **bukan checkout dengan pembayaran online**.

## Dokumentasi dan perencanaan

| Dokumen | Isi |
| --- | --- |
| [Diskusi produk dan alur bisnis](docs/PRODUCT_DISCOVERY_2026-10-22.md) | Rangkuman visi platform, aktor, pembelian langsung, program kurban bertahap, peternak mitra, reseller, dan contoh alur. |
| [Roadmap dan daftar keputusan](docs/ROADMAP_AND_DECISIONS.md) | Usulan tahapan pengembangan, kebutuhan minimum, risiko teknis, dan keputusan yang masih terbuka. |
| [Kajian awal syariah dan kepatuhan](docs/SYARIAH_AND_COMPLIANCE_REVIEW.md) | Hal-hal yang harus dikaji bersama ahli fikih muamalah, hukum, dan penyedia pembayaran **sebelum menerima setoran**. |
| [Konteks teknis backend](backend/context/CONTEXT.md) | Catatan arsitektur dan status teknis lama; verifikasi terhadap kode sebelum dipakai sebagai dasar implementasi. |
| [Dokumentasi API backend](backend/README.md) | Panduan backend lama; pastikan endpoint yang dirujuk cocok dengan `backend/routes/api.php`. |

### Catatan perubahan dokumen

- **22 Oktober 2026:** hasil diskusi awal arah pengembangan dicatat agar dapat ditinjau bersama tim. **Belum ada kode aplikasi yang diubah sebagai bagian dari dokumentasi ini.**
- Istilah **"Tabungan Qurban"** adalah nama ide fitur. Struktur akad, status dana pelanggan, syarat pembatalan, dan kesesuaian regulasi **belum diputuskan**.

## Kondisi implementasi yang perlu diingat

Pada snapshot repository yang ditinjau tanggal 22 Oktober 2026 (baseline commit `4f09ea8`), endpoint publik yang ada adalah `GET /api/hewan-kurban`, `GET /api/hewan-kurban/{id}`, dan `POST /api/daftar-reseller`. Lihat kode route untuk referensi aktual. Dokumentasi lama dapat berbeda dari implementasi.

Dilarang memakai rencana dalam folder `docs/` sebagai klaim bahwa platform sudah menjadi penyedia layanan tabungan, dompet digital, pembayaran berulang, atau sistem pembiayaan syariah.
