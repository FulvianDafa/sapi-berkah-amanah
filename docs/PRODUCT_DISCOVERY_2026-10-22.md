# Sapi Berkah Amanah — Product Discovery & Alur Bisnis

**Tanggal diskusi:** 22 Oktober 2026  
**Status:** catatan eksplorasi / `PROPOSED`, bukan PRD final atau persetujuan implementasi.  
**Tujuan dokumen:** menyimpan pembahasan produk supaya tim dapat melanjutkan analisis sebelum desain detail dan coding.

## 1. Ringkasan arah

Sapi Berkah Amanah (SBA) saat ini mengelola katalog hewan kurban dan pemesanan berbasis WhatsApp. Arah yang **sedang dibahas** ialah mengembangkan layanan menjadi platform yang memfasilitasi:

1. Katalog dan pembelian/booking langsung.
2. Akun pelanggan dan pemesanan hewan atau **paket kurban yang dipilih sejak awal**, kemudian **dibayar secara bertahap** (mingguan atau bulanan).
3. Integrasi pembayaran online melalui penyedia payment gateway dan opsi transfer rekening dengan rekonsiliasi.
4. Pengelolaan peternak mitra yang menyediakan hewan.
5. Pengelolaan reseller/agen pemasaran, atribusi pelanggan, dan potensi komisi.
6. Administrasi pemenuhan pesanan sampai pengiriman atau pelaksanaan kurban.

**Keputusan eksplisit dari diskusi:** pelanggan program bertahap **memilih hewan/paket dahulu, lalu menyetor**; bukan "nabung bebas tanpa produk". Rincian akad, harga, kepemilikan, dan alur keuangan **masih terbuka**.

## 2. Apa yang sudah ada vs belum ada

| Area | Snapshot implementasi saat ini | Konsep pengembangan |
| --- | --- | --- |
| Katalog | Vue website menampilkan sapi/kambing/domba, foto/detail, filter, dan tautan WhatsApp | Harga, ketersediaan, dan reservasi terhubung pesanan |
| Admin | Laravel Blade untuk CRUD hewan, status tersedia/terjual, dashboard | Pesanan, setoran, rekonsiliasi, mitra, dan pelaporan |
| Reseller | Formulir daftar; data diarahkan ke Google Apps Script/Sheets; admin dapat melihat daftar | Akun reseller, referral, atribusi penjualan, komisi |
| Pembayaran | Belum ada modul pembayaran online terintegrasi | Payment gateway dan transfer manual terverifikasi |
| Akun pelanggan | Belum ada alur akun pelanggan pada frontend publik | Registrasi/login, profil, program pembayaran bertahap |
| Peternak | Kemitraan merupakan konteks bisnis yang dikonfirmasi dalam diskusi | Master mitra, perjanjian, sumber stok, alokasi pesanan |
| Pelaksanaan kurban | Belum ada tracking formal | Pemenuhan, bukti serah-terima/penyembelihan/penyaluran |

Status di tabel hanya berdasarkan audit kode repository, **bukan verifikasi live production**.

## 3. Aktor dan batas kewenangan (usulan)

- **Pelanggan / pekurban:** registrasi, memilih produk/paket, menyetujui ketentuan, membayar, melihat transaksi dan progres, menerima dokumen pemenuhan.
- **Admin SBA:** mengatur katalog/paket, memverifikasi pesanan dan transfer, menangani pembayaran gagal/refund, mengelola mitra dan penyerahan.
- **Peternak mitra:** menyediakan hewan sesuai spesifikasi/kontrak, memperbarui informasi ketersediaan melalui koordinasi SBA, menyiapkan penyerahan/pelaksanaan.
- **Reseller:** memasarkan produk dan mereferensikan pelanggan; mengakses hanya informasi pesanan/komisi yang relevan, **tidak mengelola uang atau melihat data bank pribadi pelanggan lain**.
- **Pemilik/pengelola usaha:** menyetujui kebijakan harga, komisi, kontrak mitra, alokasi dana, dan keputusan refund.

**Usulan MVP:** operasional peternak dapat dikelola admin lebih dahulu; akun peternak mandiri tidak wajib untuk versi pertama. Jangan membuat aplikasi terpisah bagi tiap aktor terlalu dini.

## 4. Dua jalur pesanan

### 4.1 Pembelian langsung (pengembangan)

1. Pelanggan membuka katalog dan memilih hewan/paket.
2. Sistem meminta data penerima/pekurban, kontak, lokasi, waktu pengiriman atau pelaksanaan.
3. Sistem/administrator mengonfirmasi harga final, ongkir, kelayakan dan ketersediaan.
4. Pesanan dibuat dengan harga dan syarat yang disepakati.
5. Pelanggan membayar lunas atau DP (jika kebijakan DP diperbolehkan).
6. Sistem memverifikasi transaksi, **bukan hanya percaya callback browser atau bukti unggah**.
7. Admin mempersiapkan hewan; pesanan bergerak melalui tahap pemenuhan sampai selesai.

WhatsApp tetap menjadi kanal konsultasi dan pelayanan, bukan satu-satunya sumber status pembayaran.

### 4.2 Program "Tabungan Qurban" / pembayaran bertahap (konsep utama)

Nama produk sementara: **Program Qurban Bertahap**; istilah pemasaran "Tabungan Qurban" **tidak otomatis berarti produk tabungan/simpanan berizin**.

1. Pelanggan membuat akun dan memverifikasi kontak.
2. Pelanggan memilih **hewan spesifik** atau **paket berdasar spesifikasi**. Dua variasi ini berdampak berbeda pada alokasi stok dan akad.
3. Sistem memperlihatkan harga yang ditawarkan, standar hewan, biaya, jadwal penyelesaian, ketentuan pembatalan dan keterlambatan.
4. Admin memverifikasi kelayakan paket dan membuat/menyetujui perjanjian; **jangan langsung mengklaim kepemilikan hewan sebelum akad yang sah**.
5. Pelanggan memilih setoran **mingguan atau bulanan**; jumlah/tanggal merupakan jadwal yang disepakati. Setoran lebih cepat atau nominal berbeda hanya diperbolehkan sesuai aturan bisnis.
6. Pembayaran dilakukan via payment gateway atau transfer ke rekening usaha resmi.
7. Setoran dicatat **terkonfirmasi** hanya setelah notifikasi pembayaran terautentikasi atau rekonsiliasi mutasi bank.
8. Dashboard menampilkan total yang sudah dibayarkan, jadwal berikutnya, sisa kewajiban, dan riwayat.
9. Setelah persyaratan dipenuhi, admin menyelesaikan alokasi hewan, pelunasan, dan proses pengiriman/penyembelihan/penyaluran sesuai perjanjian.
10. Kasus tidak lunas sampai tenggat, refund, kematian/ketidaktersediaan hewan, dan perubahan spesifikasi **harus mempunyai aturan tertulis**.

**Ilustrasi semata:** paket Rp18.000.000 selama 12 bulan = Rp1.500.000/bulan sebelum biaya lain. Bukan tarif, akad, atau janji harga SBA.

**Jangan menjadikan "saldo tabungan" sebagai wallet yang dapat ditransfer atau ditarik bebas** sebelum ada model hukum, akad, dan penyedia layanan berizin yang sesuai. Tampilan awal sebaiknya menggunakan istilah **total pembayaran terverifikasi** dan **sisa kewajiban**.

## 5. Hewan spesifik vs paket spesifikasi

| Variasi | Kondisi | Hal yang harus diatur |
| --- | --- | --- |
| Hewan spesifik | Hewan individual sudah teridentifikasi | Siapa pemilik saat akad, siapa yang merawat, perubahan bobot, penyakit/kematian, penggantian |
| Paket spesifikasi | Hewan akhir belum ditetapkan saat pelanggan mendaftar | Jenis, batas usia/bobot, standar kesehatan, mutu, harga, tenggat penyerahan, siapa menjamin pemenuhan |

Kecenderungan eksplorasi: paket spesifikasi lebih fleksibel untuk horizon panjang, sementara hewan spesifik untuk booking dekat hari pelaksanaan. **Ini belum keputusan final dan belum menjawab keabsahan akadnya.**

## 6. Peternak mitra dan reseller

### Peternak mitra

Pertanyaan bisnis yang harus dijawab:

- Apakah SBA **membeli dan memiliki hewan** untuk dijual kembali, atau **menjadi agen/perantara** milik peternak?
- Siapa nama pihak penjual yang dicantumkan di perjanjian pelanggan?
- Siapa menetapkan harga dan menanggung risiko kenaikan harga saat tenor panjang?
- Bagaimana pemasok menyatakan kuota/ketersediaan dan kemampuan menyediakan paket?
- Kapan SBA harus membayar peternak; siapa menanggung risiko penggantian dan pengiriman?

Tidak boleh menampilkan janji stok, harga, atau status kepemilikan yang tidak bisa dibuktikan.

### Reseller

- Reseller adalah mitra pemasaran; program referral/komisi **masih rencana**.
- Usulan alur: link/kode referral → pelanggan registrasi/pesan → pembayaran pelanggan melalui kanal resmi → atribusi penjualan → komisi dihitung berdasar ketentuan → pembayaran komisi setelah syarat terpenuhi.
- Tentukan tarif, sumber komisi, kapan komisi menjadi hak reseller, konsekuensi refund/cancel, dan mitigasi self-referral/penipuan.
- Reseller tidak menerima setoran ke rekening pribadinya sebagai pola default, dan tidak diberikan akses data sensitif yang tidak diperlukan.
- Hindari skema bonus yang semata-mata dibayar karena merekrut reseller lain tanpa transaksi riil.

## 7. Pembayaran dan pencatatan

**Pilihan yang dibahas (belum dipilih provider):**
- Integrasi gateway seperti Midtrans Snap; bandingkan Xendit/DOKU berdasarkan onboarding merchant, metode VA/QRIS/e-wallet, settlement, refund, webhook, dan biaya terkini.
- Transfer manual ke rekening usaha; pengunggahan bukti bersifat **permintaan verifikasi**, bukan bukti uang sudah diterima.

Kebutuhan minimum:
- Setiap invoice/setoran punya identitas unik dan keterkaitan ke pesanan.
- Backend menjadi sumber harga/nominal yang sah; klien tidak boleh menentukan jumlah final sepihak.
- Webhook diverifikasi, idempotent, aman dari replay; pembayaran ganda/lebih bayar perlu prosedur.
- Rekonsiliasi provider/VA/bank dengan catatan internal; audit trail siapa memverifikasi.
- Pisahkan pembayaran `pending/confirmed/failed/refunded`, pesanan `draft/confirmed/cancelled/completed`, dan pemenuhan `unallocated/allocated/delivered/slaughtered` (nama status final TBD).
- Dana pelanggan yang belum menjadi hak usaha dan kewajiban refund **harus dibukukan secara tepat**; cara penampungan/penggunaan dana tetap menunggu penilaian hukum dan syariah.

## 8. Kebutuhan fungsional awal (draft)

| ID | Kebutuhan | Status |
| --- | --- | --- |
| FR-01 | Registrasi, login, verifikasi kontak pelanggan | Proposed |
| FR-02 | Katalog dan paket kurban transparan | Perlu perluasan |
| FR-03 | Pemesanan dengan kesepakatan harga, spesifikasi, dan tenggat | Proposed |
| FR-04 | Pembuatan jadwal pembayaran mingguan/bulanan | Proposed |
| FR-05 | Setoran via provider pembayaran | Proposed |
| FR-06 | Pengajuan transfer manual dan rekonsiliasi admin | Proposed |
| FR-07 | Dashboard progres pembayaran dan riwayat terverifikasi | Proposed |
| FR-08 | Pembatalan, perubahan, refund dan penanganan keterlambatan | Proposed |
| FR-09 | Pengelolaan peternak, penawaran dan alokasi hewan | Proposed |
| FR-10 | Akun reseller, atribusi, perhitungan komisi | Proposed |
| FR-11 | Monitoring pemenuhan dan dokumentasi kurban | Proposed |
| FR-12 | Audit trail, notifikasi, kontrol akses dan laporan | Proposed |

## 9. Non-goals untuk MVP

- Bukan e-wallet, bank, atau investasi yang menawarkan imbal hasil.
- Bukan pembiayaan berbunga.
- Bukan marketplace peternak terbuka tanpa kurasi.
- Bukan auto-debit wajib sejak versi pertama.
- Bukan distribusi komisi multi-level berdasarkan rekrutmen.
- Tidak perlu mengganti total stack Vue + Laravel yang sudah digunakan.

## 10. Keterkaitan dokumen

- [Roadmap dan keputusan](ROADMAP_AND_DECISIONS.md)
- [Kajian awal syariah dan hukum](SYARIAH_AND_COMPLIANCE_REVIEW.md)

> Dokumen ini menangkap arah diskusi tim, **bukan persetujuan untuk menerima setoran masyarakat**. Desain kontrak/akad dan penerimaan uang harus menunggu validasi relevan.
