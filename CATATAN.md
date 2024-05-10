1. no_ukg, replace format
  - @guruku.id
  - @guru.id
  - *
2. nama ada *
3. data final mateng
  - nama
  - nik
  - no_ukg
  - nuptk
  - npsn
  - instansi
  - mapel_bispar (dapodik)
  - propinsi (dapodik)
4. urutan peserta sesuai order dari atas ke bawah di excel

# CHECKLIST
[x] Replace format no_ukg (@guruku.id, @guru.id, *)
[x] Cleansing no_ukg kurang dari atau lebih dari 12 digit
[x] Cleansing no_ukg DATA MENTAH (naive bayes)
[x] Import DATA MENTAH hasil cleansing ke database
[x] Cleansing data mapel tidak sesuai di DATA PEMETAAN (Jasa Boga->Tata Boga, Kecantikan Kulit & Rambut->Kecantikan, Social Care->Pekerjaan Sosial)
[x] Cleansing "Prov. " dari nama propinsi di DATA DAPODIK
[x] Import DATA DAPODIK ke database
[] JOIN DATA MENTAH dengan DATA DAPODIK sesuai nik dan no_ukg
[] Import DATA FINAL ke database (nama, nik, no_ukg, nuptk, npsn, instansi, mapel_bispar, propinsi)
[x] Import DATA PEMETAAN
[] Grouping by propinsi dan ambil X data sesuai jumlah di DATA PEMETAAN
[] Tampilkan di tabel website
[] Export data ke .xlsx (grouping berdasarkan propinsi ke sheet masing-masing)
