[ DONE ]
1. Hapus boilerplate auth tidak terpakai (Folder Auth/ & routes/auth.php dihapus)
2. Fix bug route double prefix (Fix pada routes/web.php bagian admin.hewan-kurban.photo.delete)
3. Pisah Web Controller & API Controller (Membuat Api\HewanKurbanController & Api\AuthController; logika CRUD dipindah ke Service Pattern)

[ FASE 1 ]
4. Migrasi: tambah jenis_hewan, rename jenis_sapi → nama, nullable berat/umur/kategori
5. Sesuaikan Controller + API untuk handle sapi & kambing
6. Update UI admin untuk tambah/edit kambing

[ FASE 2 ]
7. Migrasi: is_admin → role enum('admin', 'reseller')
8. Admin bisa CRUD akun reseller
9. Dashboard berbeda per role

[ FASE 3 — tunda sampai alur jelas ]
10. Sistem referral reseller
