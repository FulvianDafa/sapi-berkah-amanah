[ DONE ]
1. Hapus boilerplate auth tidak terpakai (Folder Auth/ & routes/auth.php dihapus)
2. Fix bug route double prefix (Fix pada routes/web.php bagian admin.hewan-kurban.photo.delete)
3. Pisah Web Controller & API Controller (Membuat Api\HewanKurbanController & Api\AuthController; logika CRUD dipindah ke Service Pattern)
4. Migrasi: tambah jenis_hewan, rename jenis_sapi → nama, nullable berat/umur/kategori (Selesai dengan MySQL modifier via doctrine)
5. Sesuaikan Controller + API untuk handle sapi & kambing (Validasi disesuaikan, kategori dibiarkan null untuk kambing)
6. Update UI admin untuk tambah/edit kambing (Dropdown enum, label constraint dinamis, UI badge pembeda di index)

[ FASE 1.5 - UI/UX REVAMP ]
- [ ] Revamp Admin Layout & Navbar (Sidebar modern, navbar glassmorphism)
- [ ] Redesign Dashboard (Gradient stats cards, premium table look)
- [ ] Redesign Hewan Kurban List & Cards (Premium badge/gradients)
- [ ] Redesign Hewan Kurban Form (Clean card-based form groups, soft focus rings)
- [ ] Redesign Reseller View (Modern datatable styling, matching general list)

[ FASE 2 ]
7. Migrasi: is_admin → role enum('admin', 'reseller')
8. Admin bisa CRUD akun reseller
9. Dashboard berbeda per role

[ FASE 3 — tunda sampai alur jelas ]
10. Sistem referral reseller
