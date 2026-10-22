# Sapi Berkah Amanah — Roadmap, Risiko, dan Decision Log

**Dibuat:** 22 Oktober 2026  
**Status:** `DRAFT / DISCOVERY` — prioritas usulan; tidak berarti pekerjaan sudah dijadwalkan atau disetujui.

## 1. Prinsip pengembangan

- **Pertahankan stack saat ini:** Vue 3 di website pelanggan, Laravel 11 untuk API dan panel admin Blade, MySQL untuk transaksi internal.
- **Evolusi bertahap:** keamanan dan kepastian transaksi mendahului fitur finansial.
- **Tidak perlu rewrite/microservices** hanya karena ada peternak dan reseller.
- **Satu sumber kebenaran finansial:** backend + catatan terverifikasi, tidak memakai nilai dari browser sebagai dasar pelunasan.
- **Data pelanggan dan rekening adalah data sensitif:** akses berdasarkan kebutuhan, pemrosesan dan retensi yang jelas.
- **Lolos review hukum/syariah sebelum go-live:** terutama setoran lintas bulan dan penggunaan dana.

## 2. Usulan roadmap bertahap

| Prioritas | Fase | Deliverables / exit criteria | Status |
| --- | --- | --- | --- |
| P0 | Stabilitas & keamanan | Audit akses halaman admin/reseller; perbaiki auth/seed; perbarui kredensial demo; perjelas data tersedia vs terjual; uji CRUD, status, media, dan akses | Belum dimulai melalui diskusi ini |
| P1 | Fondasi pesanan | Definisi model bisnis & akad; identitas pelanggan, paket/spesifikasi, order dan pemenuhan; proteksi stok/kuota; riwayat perubahan | Blocked: keputusan bisnis & syariah |
| P1 | Pembayaran langsung | Evaluasi gateway, sandbox, invoice, webhook, refund dasar, rekonsiliasi bank/VA, monitoring admin | Blocked: kontrak merchant & desain pembayaran |
| P1/P2 | Qurban bertahap | Perjanjian dan jadwal setoran; tagihan tiap periode; verifikasi manual/otomatis; pengingat; status terlambat, batal dan refund | Blocked: akad, dana, risiko, kebijakan |
| P2 | Peternak mitra | Data pemasok, penawaran, penjaminan paket, alokasi hewan, kewajiban pemasok, dokumen pemenuhan | Proposed |
| P2 | Reseller | Akun/role, atribusi referensi, dashboard terbatas, komisi, penanganan refund | Proposed |
| P3 | Operasional lanjut | Patungan sapi per bagian (jika dipilih), penjadwalan kurban, dokumentasi serah-terima dan penyembelihan, laporan | Proposed |

**Existing engineering notes:** `backend/context/TASK.md` menandai Fase 1/1.5 lama selesai dan role/reseller lanjutan sebagai fase mendatang. Roadmap baru ini **tidak membatalkan pekerjaan yang sudah ada**, melainkan perlu diselaraskan oleh tim.

## 3. Risiko & quality gates sebelum pembayaran nyata

1. **Otorisasi dan privasi:** semua halaman berisi data reseller/identitas/rekening harus diuji akses tanpa login serta antar-role; hindari menampilkan PII pada log.
2. **Akun admin:** periksa `User::$fillable` vs mekanisme seeder `is_admin`; jangan gunakan kredensial demo di lingkungan produksi.
3. **Katalog:** pastikan konsistensi data hewan `tersedia/terjual` dan aturan kapan paket dapat dipesan.
4. **Pembayaran:** backend validasi harga & status; webhook signature, idempotensi, penanganan retry; jangan percaya return URL sebagai bukti lunas.
5. **Bukti transfer:** status tetap pending sampai mutasi/statement bank diverifikasi, dengan audit identitas verifier.
6. **Stok dan kuota:** transaksi bersamaan tidak boleh membuat satu hewan/bagian terjual dua kali; tentukan reservasi & expiry.
7. **Media:** pastikan hapus video menggunakan resource type yang benar, termasuk rollback/kompensasi kegagalan layanan eksternal.
8. **Testing:** buat automated tests untuk auth, business rules, pembatalan, pembayaran duplikat, partial payments, refund, concurrency dan webhook; jangan hanya mengandalkan template test.
9. **Docs/API:** samakan endpoint yang didokumentasikan dengan route aktual `/api/hewan-kurban`; migrasikan field frontend legacy secara bertahap.
10. **Kesiapan operasi:** kebijakan backup, audit log, error monitoring, rekonsiliasi harian dan prosedur insiden keuangan.

**Audit ini hanya indikasi dari pembacaan source code, belum verifikasi aplikasi yang berjalan.** Jangan mempublikasikan contoh kredensial atau data pendaftar.

## 4. Entitas data yang mungkin diperlukan (konseptual, bukan skema DB)

- `customers` / identitas dan profil pelanggan.
- `farm_partners` / peternak, kewenangan menjual, kesepakatan pemasok.
- `animal_offers` / inventori spesifik atau paket spesifikasi (perlu menghindari konflik dengan tabel `hewan_kurbans` yang sudah ada).
- `orders` / pesanan, harga disepakati, kontrak/akad, tanggal target, referral.
- `payment_schedules` / jadwal pembayaran berkala.
- `payment_attempts` + `payments` / instruksi transfer, webhook, konfirmasi, refund, asal dana dan provider reference.
- `allocations` / hewan aktual dan bagiannya yang dialokasikan.
- `reseller_attributions` + `commissions` / asal lead, perhitungan dan status hak komisi.
- `fulfillments` / pengiriman, penyembelihan, penyaluran dan bukti.
- `audit_events` / aktor, peristiwa, waktu, perubahan penting.

**Catatan:** catatan pembayaran **bukan** izin menampung dana publik atau membuat saldo wallet. Pemisahan kewajiban akuntansi harus disepakati terlebih dahulu.

## 5. Decision log (pertanyaan yang BELUM diputuskan)

| ID | Pertanyaan | Opsi diskusi | Status |
| --- | --- | --- | --- |
| D-01 | Status SBA dalam transaksi: penjual utama atau agen peternak? | Reseller hewan milik SBA / perantara berkuasa | **OPEN** |
| D-02 | Paket bertahap: hewan tertentu atau spesifikasi? | Hewan spesifik / paket spesifikasi / kombinasi dengan syarat | **OPEN** |
| D-03 | Akad pelanggan saat hewan belum dialokasikan dan dana dicicil? | Perlu review fikih; jangan mengasumsikan salam/murabahah | **OPEN — review syariah wajib** |
| D-04 | Uang setoran diterima siapa dan digunakan kapan? | Rekening usaha, mekanisme terpisah/mitra berizin; tergantung akad | **OPEN — review hukum wajib** |
| D-05 | Siapa menjamin harga tetap dan risiko peternak? | SBA / peternak / pembagian risiko dalam kontrak | **OPEN** |
| D-06 | Penentuan tenor, DP, minimum setoran, masa tenggang? | Fleksibel menurut produk vs jadwal tetap | **OPEN** |
| D-07 | Ketentuan pembatalan, refund dan tunggakan? | Aturan tertulis yang adil dan dapat dieksekusi | **OPEN** |
| D-08 | Penyedia payment gateway? | Midtrans, Xendit, DOKU atau mitra lain setelah evaluasi | **OPEN** |
| D-09 | Kapan komisi reseller muncul dan dibayar? | Berdasar pembayaran sah / pemenuhan / ketentuan kontrak | **OPEN** |
| D-10 | Cara alokasi hewan dan jadwal peternak? | Alokasi saat akad / menjelang hari kurban | **OPEN** |
| D-11 | Apakah program patungan sapi (maks. 7 bagian) ikut MVP? | Ya / fase terpisah | **OPEN** |
| D-12 | Siapa mengurus penyembelihan dan distribusi daging? | SBA / peternak / pelanggan dengan wakalah jelas | **OPEN** |

### Yang telah dikonfirmasi dalam diskusi (bukan keputusan akad)

- **CONFIRMED:** platform mempunyai hubungan dengan **peternak mitra** dan **reseller**.
- **CONFIRMED:** ide program bertahap ialah **memilih hewan atau paket dahulu, lalu membayar bertahap**, bisa mingguan/bulanan.
- **CONFIRMED:** ingin mendiskusikan produk, bisnis, pembayaran, dan sisi agama **sebelum coding**.
- **NOT DECIDED:** SBA membeli hewan lalu menjual ulang atau hanya menjadi perantara; belum ada pernyataan final model penjual.
- **NOT IMPLEMENTED:** akun pelanggan, fitur cicilan/setoran, checkout online, dan dashboard komisi.

## 6. Tindak lanjut discovery (belum coding)

- [ ] Petakan alur keuangan nyata SBA ↔ pelanggan ↔ peternak ↔ reseller.
- [ ] Tetapkan status penjual, kepemilikan hewan, dan kewajiban tiap pihak dalam perjanjian.
- [ ] Diskusikan akad pembayaran bertahap dengan ahli fikih muamalah.
- [ ] Konsultasi legal/regulasi tentang penerimaan dan penggunaan setoran pelanggan.
- [ ] Tetapkan aturan harga, keterlambatan, penggantian hewan, refund, biaya, dan komisi.
- [ ] Tulis SRS/PRD final beserta contoh state transition dan kasus uji.
- [ ] Baru setelah sign-off: desain database, API, dan UX, lanjut sandbox payment gateway.

## 7. Bacaan silang

- [Diskusi produk & alur](PRODUCT_DISCOVERY_2026-10-22.md)
- [Risiko syariah dan kepatuhan](SYARIAH_AND_COMPLIANCE_REVIEW.md)
