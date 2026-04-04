# ⚡ QUICK REFERENCE: JIKA GAMBAR TIDAK MUNCUL (3 KEMUNGKINAN)

**Jika sudah upload ke hosting tapi gambar tidak muncul, ikuti 1 dari 3 solusi ini:**

---

## ✅ SOLUSI 1: Symlink (99% Kasus)

**Gejala:**

- File ada di storage/app/public/sliders/ (✓ cek via FTP)
- Tapi URL `https://domain.id/storage/sliders/image.jpg` = **404**
- Gambar broken/tidak muncul

**Solusi:**

### **Cara A: Re-run init-storage.php (PALING MUDAH)**

```bash
1. Upload ulang: public/init-storage.php ke hosting
2. Buka: https://kelurahan-petamburan.id/init-storage.php
3. Tunggu sampai semua ✅ selesai
4. Delete: public/init-storage.php via FTP
5. Test upload gambar lagi
```

**Expected Output:**

```
✅ 1️⃣ Main Storage Folder - created
✅ 2️⃣ 10 subfolders - created
✅ 3️⃣ Symlink created successfully         ← YANG PENTING!
✅ 4️⃣ Cache cleared
✅ 5️⃣ Permissions fixed
```

---

### **Cara B: Manual Create Symlink (Jika A tidak bisa)**

**Via cPanel File Manager:**

```
1. Login cPanel
2. File Manager
3. Navigate: public_html/public/
4. Click: "Create Link" atau "Symlink"
5. Fill:
   Name: storage
   Target: ../storage/app/public
6. Click Create
7. Test: https://domain.id/storage/sliders/test.jpg
```

**Via SSH (jika ada akses):**

```bash
cd public_html/public/
ln -s ../storage/app/public storage
```

---

### **Cara C: .htaccess Rewrite (Jika Symlink Tidak Support)**

**File:** `public_html/public/.htaccess`

**Tambahkan:**

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On

    # Storage rewrite
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^storage/(.*)$ ../storage/app/public/$1 [L]

    # Laravel routing
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^ index.php [L]
</IfModule>
```

---

## ⚠️ SOLUSI 2: APP_URL Wrong

**Gejala:**

- Gambar file ada ✓
- Symlink ada ✓
- Tapi URL generated salah:
    - `http://localhost/storage/...` (instead of domain)
    - `http://192.168.0.1/storage/...` (instead of domain)

**Solusi:**

```bash
1. Edit file: .env

CHANGE:
APP_URL=http://localhost

TO:
APP_URL=http://kelurahan-petamburan.id
(NO trailing slash!)

2. Upload ke hosting

3. Clear cache:
   https://domain.id/init-storage.php
   (Will auto clear config cache)

4. Test gambar
```

---

## 🔴 SOLUSI 3: File Tdk Ada di Storage

**Gejala:**

- Upload image → Simpan OK
- Tapi file TIDAK ada di storage/app/public/sliders/ (via FTP)
- Database punya value tapi file tidak ada

**Solusi:**

```bash
STEP 1: Check hosting limits
---------
Create: public_html/test-limits.php

Content:
<?php
echo "upload_max_filesize: " . ini_get('upload_max_filesize') . "<br>";
echo "post_max_size: " . ini_get('post_max_size') . "<br>";
?>

Open: https://domain.id/test-limits.php
Harus ≥ 32MB

Jika kurang: Contact hosting untuk increase


STEP 2: Check folder permissions
---------
Via File Manager:
1. Right-click: storage/ folder
2. Change Permissions → 755 (atau 777)
3. Apply recursively ✓
4. Save

Via SSH:
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/


STEP 3: Verify folder structure
---------
Via FTP navigate to: public_html/storage/app/public/

Harus ada 10 subfolder:
✓ sliders/
✓ news/
✓ galleries/
✓ achievements/
✓ services/
✓ infographics/
✓ pages/
✓ potentials/
✓ officials/
✓ complaints/

Jika tidak ada:
1. Manual create via File Manager
2. Or re-run: https://domain.id/init-storage.php


STEP 4: Test upload
---------
Admin → Slider → Tambah
Upload image & Simpan
Check via FTP: file ada atau tidak?

Jika masih tidak ada:
Contact hosting support:
"File upload tidak tersimpan di storage folder"
```

---

## 🎯 DECISION: MANA SOLUSI?

**Cek pertanyaan ini:**

```
1. File ADA di storage? (cek via FTP: storage/app/public/sliders/)

   ✅ YES → URL bisa diakses?
   ❌ NO → SOLUSI 3 (file tidak tersimpan)


2. URL bisa diakses? (buka: https://domain.id/storage/sliders/image.jpg)

   ✅ 200 OK (gambar muncul) → ✅ SOLVED!
   ❌ 404 Not Found → SOLUSI 1 (symlink problem)
   ❌ 403 Forbidden → SOLUSI 1 atau permissions


3. URL generated salah?

   Check: URL formula di Blade
   asset('storage/' . $image)

   Jika generate: http://localhost/storage/...
   → SOLUSI 2 (.env APP_URL salah)
```

---

## 🆘 JIKA TETAP TIDAK BISA

**Kumpulkan 3 info ini dan tanya support:**

```
1. Screenshot: https://domain.id/init-storage.php output
   (Apakah ada ⚠️ warning?)

2. FTP folder check:
   - Apakah storage/app/public/sliders/ ada?
   - Apakah ada file gambar di dalamnya?
   - Permissions berapa? (755? 644?)

3. URL test:
   - Coba buka: https://domain.id/storage/sliders/image.jpg
   - Apa hasilnya? (200? 404? 403? 500?)
```

---

## 📋 CHECKLIST DEPLOYMENT FINAL

Sebelum declare "selesai", pastikan ini OK:

```
✓ Upload project ke hosting
✓ Run: https://domain.id/init-storage.php
✓ Delete: public/init-storage.php via FTP
✓ Login admin: https://domain.id/admin
✓ Upload image slider → save
✓ Check FTP: file ada di storage/app/public/sliders/
✓ Check URL: https://domain.id/storage/sliders/image.jpg works
✓ Admin preview: gambar muncul
✓ Frontend: https://domain.id/ gambar di halaman muncul
✓ Test 2-3 modules: news, gallery, etc semua OK
✓ Test delete image: image dihapus dari storage
✓ Test update image: old file deleted, new file saved
✓ No errors di: storage/logs/laravel.log

All ✓? → SELESAI! 🎉
```

---

**📖 Untuk detail lengkap & troubleshooting mendalam: Baca `JIKA_GAMBAR_TIDAK_MUNCUL_DI_HOSTING.md`**
