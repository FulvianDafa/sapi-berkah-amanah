[ DONE ]
1. Hapus boilerplate auth tidak terpakai (Folder Auth/ & routes/auth.php dihapus)
2. Fix bug route double prefix (Fix pada routes/web.php bagian admin.hewan-kurban.photo.delete)
3. Pisah Web Controller & API Controller (Membuat Api\HewanKurbanController & Api\AuthController; logika CRUD dipindah ke Service Pattern)
4. Migrasi: tambah jenis_hewan, rename jenis_sapi → nama, nullable berat/umur/kategori (Selesai dengan MySQL modifier via doctrine)
5. Sesuaikan Controller + API untuk handle sapi & kambing (Validasi disesuaikan, kategori dibiarkan null untuk kambing)
6. Update UI admin untuk tambah/edit kambing (Dropdown enum, label constraint dinamis, UI badge pembeda di index)
7. [FASE 1.5] Revamp Admin Layout & Navbar — Sidebar dark green premium, toggle desktop (localStorage persist) + mobile (overlay). Hamburger button fixed.
8. [FASE 1.5] Redesign Dashboard — Clean stat cards, minimal table, font sizes adjusted.
9. [FASE 1.5] Redesign Hewan Kurban List — Kategori cards dihapus, dual filter (jenis_hewan + kategori), info column fallback "Belum diisi", AJAX pagination (table-only refresh), custom Indonesian pagination (Sebelumnya/Berikutnya).
10. [FASE 1.5] Redesign Hewan Kurban Form — Card-based form layout, green-focused inputs, improved dropzone, semua JS logic preserved.
11. [FASE 1.5] Redesign Reseller View — Clean table, avatar initials, WhatsApp link hardcoded 62 prefix, Indonesian badges.

[ FASE 2 ]
12. Migrasi: is_admin → role enum('admin', 'reseller')
13. Admin bisa CRUD akun reseller
14. Dashboard berbeda per role

[ FASE 3 — tunda sampai alur jelas ]
15. Sistem referral reseller
