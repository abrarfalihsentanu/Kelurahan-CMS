# 🔧 TROUBLESHOOTING: GAMBAR TIDAK MUNCUL DI HOSTING

**Date:** 4 April 2026  
**Status:** Complete Troubleshooting Guide  
**Fokus:** Solusi lengkap jika gambar tidak muncul setelah deploy ke hosting  
**Guarantee:** Step-by-step solutions untuk setiap kemungkinan

---

## 🎯 OVERVIEW: APA YANG MUNGKIN SALAH?

```
Kemungkinan:

1. Symlink tidak terbuat
   ✓ Solusi: Manual create symlink atau edit .htaccess

2. .env APP_URL salah
   ✓ Solusi: Fix .env dengan APP_URL yang benar

3. File permissions tidak 755
   ✓ Solusi: chmod 755 storage folders

4. File harusnya ada di storage tapi tidak ada
   ✓ Solusi: Check upload folder, database value, controller logic

5. Cache masih lama
   ✓ Solusi: Clear all Laravel cache

6. Hosting tidak support symlink
   ✓ Solusi: Gunakan .htaccess rewrite rules
```

---

## 📋 PRE-DEPLOYMENT CHECKLIST (LAKUKAN SEBELUM UPLOAD)

### **Step 1: Verify Local Works 100%**

```
Checklist lokal (xampp):
□ Create admin user
□ Upload image ke slider
□ Verify image masuk ke:
    - Database (nilai di column 'image')
    - Folder storage/app/public/sliders/
    - URL http://localhost:8000/storage/sliders/image.jpg muncul

□ Test 2-3 modules (News, Gallery, dll)
□ Test delete image
□ Test update/ganti image
□ Semua harus ✓ OK sebelum deploy
```

### **Step 2: Prepare .env untuk Hosting**

**File: `.env` (sebelum upload)**

```env
# PASTIKAN INI BENAR sebelum upload:

APP_NAME="Kelurahan Petamburan CMS"
APP_ENV=production                           ← Penting!
APP_DEBUG=false                              ← Jangan true!
APP_KEY=base64:RSH2Qi6HuYR7HtJIqeHj9vO3qws6etf1+83xuUwiUIM=
APP_URL=http://kelurahan-petamburan.id       ← NO TRAILING SLASH!

LOG_CHANNEL=stack
LOG_LEVEL=warning

DB_CONNECTION=mysql
DB_HOST=127.0.0.1                            ← biasanya localhost
DB_PORT=3306
DB_DATABASE=keln7174_kelurahan_cms           ← ganti dengan akun hosting
DB_USERNAME=keln7174_user
DB_PASSWORD=Q.Y}6JQ.0S8s)]OK

FILESYSTEM_DISK=local                        ← Harus 'local'
```

**Critical Points:**

- ✅ APP_URL harus EXACT URL hosting Anda
- ✅ NO trailing slash `/` di APP_URL
- ✅ DB credentials harus match hosting
- ✅ FILESYSTEM_DISK = local (gunakan public disk di controller)

---

## 🚀 STEP-BY-STEP DEPLOYMENT PROCESS

### **PHASE 1: Upload Project Files**

```bash
Langkah:
1. FTP ke hosting (username dan password hosting)
2. Masuk folder public_html/
3. Extract project laravel (sudah di-zip)
4. Struktur akhir:
   public_html/
   ├── public/              ← root web server
   ├── app/
   ├── storage/
   ├── config/
   ├── routes/
   ├── resources/
   ├── .env                 ← update dengan production values
   ├── .env.example
   ├── artisan
   └── ... (rest of laravel)
```

### **PHASE 2: Upload init-storage.php**

```bash
1. Upload file: public/init-storage.php
   Ke hosting:
   public_html/public/init-storage.php

2. File sudah siap di local Anda
```

### **PHASE 3: Run init-storage.php**

```bash
1. Buka browser
2. URL: https://kelurahan-petamburan.id/init-storage.php

3. Tunggu output seperti ini:
   ✅ 1️⃣ Main Storage Folder - Already exists
   ✅ 2️⃣ Creating Subfolders - 10/10
   ✅ 3️⃣ Symlink created successfully
   ✅ 4️⃣ Cache cleared (5 types)
   ✅ 5️⃣ Permissions fixed

4. Jika semua ✅ OK → Lanjut ke step 4
   Jika ada ⚠️ WARNING → Lihat Troubleshooting section
```

### **PHASE 4: Delete init-storage.php**

```bash
Via FTP:
1. Navigate to: public_html/public/
2. Delete: init-storage.php
3. Confirm deleted

PENTING: Jangan lupakan step ini!
```

### **PHASE 5: Test Upload Image**

```bash
1. Login admin: https://domain.id/admin
2. Go to: Dashboard → Slider → Tambah Slider
3. Fill form:
   - Title: "Test Slider"
   - Upload image: JPG atau PNG (~100KB)
4. Click: Simpan

Expected result:
   ✅ Admin shows image preview
   ✅ Slider list shows image thumbnail
   ✅ Frontend website shows image
```

### **PHASE 6: Verify File Storage**

```bash
Via FTP:
1. Navigate to:
   public_html/storage/app/public/sliders/

2. Harus ada file gambar dengan nama random:
   ✅ 1712234567_image.jpg
   ✅ atau nama-random-xyz.png

3. Jika file tidak ada:
   → Image tidak tersimpan = problem di controller/storage
   → Lihat section "Gambar tidak ada di storage folder"

4. Jika file ada tapi tidak tampil:
   → Image tersimpan tapi tidak accessible = problem symlink
   → Lihat section "Gambar ada tapi tidak tampil"
```

---

## 🔴 JIKA GAMBAR TIDAK MUNCUL: DIAGNOSTIC TREE

### **Problem 1: Gambar TIDAK Ada di Storage Folder**

**Gejala:**

```
- Upload image → Click Simpan → OK/redirect
- Tapi di FTP, folder storage/app/public/sliders/ tetap KOSONG
- Database: image column punya value, tapi file tidak ada
```

**Diagnosis:**

```
1. Check controller logic:
   ✓ Sudah verify SliderController using store('sliders', 'public')
   ✓ CONFIRMED: Code sudah benar!

2. Storage folder structure:
   Harus ada:
   - storage/app/public/ (main)
   - storage/app/public/sliders/ (subfolder)

3. Upload mechanism:
   - Apakah upload_max_filesize cukup?
   - Apakah post_max_size cukup?
```

**Solusi:**

```bash
STEP 1: Check hosting limits
---------
Via cPanel atau File Manager:
1. Create file: public_html/test-limits.php
2. Content:
   <?php
   echo "upload_max_filesize: " . ini_get('upload_max_filesize') . "<br>";
   echo "post_max_size: " . ini_get('post_max_size') . "<br>";
   echo "memory_limit: " . ini_get('memory_limit') . "<br>";
   ?>
3. Open URL: https://domain.id/test-limits.php
4. Check values (harus 32MB+ untuk upload_max_filesize)
5. Delete test file

Jika kurang:
   Contact hosting: "Please increase upload_max_filesize to 64MB"

STEP 2: Check storage folder permissions
---------
Via FTP atau File Manager:
1. Check folder permissions:
   storage/app/public/ harus 755 atau 777
   storage/logs/ harus 755 atau 777
   bootstrap/cache/ harus 755 atau 777

2. Jika 644 atau 444:
   Right-click → Change Permissions → 755
   (atau 777 jika tidak support 755)

STEP 3: Check if init-storage.php ran properly
---------
1. Via FTP, navigate to: storage/logs/laravel.log
2. Check last entries:
   Harus ada:
   [2026-04-04 XX:XX:XX] STORAGE-INIT: Permissions set (755): /storage/
   [2026-04-04 XX:XX:XX] STORAGE-INIT: Cleared: Config cache
   ... dll

3. Jika entries tidak ada:
   init-storage.php mungkin tidak full run
   → Try re-run: https://domain.id/init-storage.php (upload ulang)

STEP 4: Check database integrity
---------
Via cPanel → PHP MyAdmin atau terminal:
1. Open database: keln7174_kelurahan_cms
2. Check table: sliders
3. Upload new image, then check:
   SELECT * FROM sliders; -- Cek column 'image' value

   Harus ada nilai seperti:
   - sliders/1712234567_xyz.jpg
   - sliders/image_abc123.png

   Jika empty atau NULL:
   → Form submit tidak save image path
   → Check controller store() method logic
```

**If Still Not Working:**

```
Kemungkinan:
1. Disk 'public' belum configured di filesystems.php
   → Upload ulang config/filesystems.php file

2. Controller code belum update dengan store('folder', 'public')
   → Check app/Http/Controllers/Admin/SliderController.php
   → Must punya: $file->store('sliders', 'public')

3. Storage path salah di .env
   → Check .env: APP_URL=correct-domain
   → Check config/filesystems.php: root path benar

Solusi lanjutan:
Contact hosting support:
- "Gambar tidak tersimpan di storage folder"
- "Upload_max_filesize sudah cukup"
- "File permissions sudah 755"
- "Minta tolong check: /storage/app/public/ bisa write?"
```

---

### **Problem 2: Gambar Ada di Storage TAPI Tidak Tampil**

**Gejala:**

```
- File exist: storage/app/public/sliders/image.jpg ✅ (via FTP)
- Database punya path: sliders/image.jpg ✅
- Admin preview: ❌ Tidak muncul (broken image)
- URL: https://domain.id/storage/sliders/image.jpg → ❌ 404
- Website frontend: ❌ Gambar broken
```

**Diagnosis:**

```
❌ Gambar file NOT ACCESSIBLE via web
= SYMLINK PROBLEM!

Symlink (public/storage) tidak terbuat atau tidak berfungsi
```

**Solusi:**

```bash
STEP 1: Check if symlink exists
---------
Via FTP File Manager:
1. Navigate to: public_html/public/
2. Cari folder/link bernama: storage
3. Jika TIDAK ada:
   → init-storage.php failed membuat symlink
   → Lanjut ke STEP 3
4. Jika ADA:
   → Check if it's actual symlink (ada garis atau simbol link)
   → Lanjut ke STEP 2

STEP 2: Test symlink jalan atau tidak
---------
Via browser:
1. Try access:
   https://domain.id/storage/sliders/

   Harus show:
   ✅ Folder listing dari storage/app/public/sliders/
   OR
   ❌ 403 Forbidden (OK, folder index disabled)
   OR
   ❌ 404 Not Found (PROBLEM: symlink tidak jalan)

2. Try access image directly:
   https://domain.id/storage/sliders/image.jpg

   Harus show:
   ✅ Image muncul
   OR
   ❌ 404 (symlink problem)

3. Jika 404:
   → Symlink tidak berfungsi
   → Lanjut ke STEP 3

STEP 3: Manual create symlink
---------
Option A: Via cPanel File Manager
  1. Go to: public_html/public/
  2. Click "Create Link" or "Symlink"
  3. Fill:
     Name: storage
     Target: ../storage/app/public
  4. Create

Option B: Via SSH (jika ada akses)
  cd public_html/public/
  ln -s ../storage/app/public storage

Option C: Contact hosting support
  "Please create symlink:
   public/storage → ../storage/app/public"

STEP 4: If symlink not supported - use .htaccess rewrite
---------
If hosting tidak support symlink:

1. Create file: public_html/public/.htaccess
2. Add rules:

   <IfModule mod_rewrite.c>
       RewriteEngine On

       # Rewrite storage requests to actual storage folder
       RewriteCond %{REQUEST_FILENAME} !-f
       RewriteCond %{REQUEST_FILENAME} !-d
       RewriteRule ^storage/(.*)$ ../storage/app/public/$1 [L]

       # Rest of Laravel routing
       RewriteCond %{REQUEST_FILENAME} !-f
       RewriteCond %{REQUEST_FILENAME} !-d
       RewriteRule ^ index.php [L]
   </IfModule>

3. Save

4. Test: https://domain.id/storage/sliders/image.jpg
   Harus muncul gambar

STEP 5: Verify after symlink/rewrite fix
---------
1. Go to admin: https://domain.id/admin
2. Navigate to: Slider → Edit existing slider (yang sudah ada gambar)
3. Check preview: Gambar harus muncul
4. Frontend: https://domain.id/ → Gambar harus muncul di slider

Jika masih tidak muncul → Lanjut ke STEP 6

STEP 6: Check URL formula di Blade view
---------
Open view file di local:
resources/views/admin/sliders/_form.blade.php

Cari:
<img src="{{ asset('storage/' . $slider->image) }}"

Harus generate URL seperti:
http://kelurahan-petamburan.id/storage/sliders/image.jpg

Jika URL berbeda:
- Check .env APP_URL value
- Ensure NO trailing slash
```

**Success Indicators:**

```
Symlink atau rewrite berhasil jika:
✅ URL returns 200 OK (not 404)
✅ Image muncul di browser
✅ Admin preview shows image
✅ Frontend shows image
✅ No broken image icon
```

---

### **Problem 3: URL Generated Salah**

**Gejala:**

```
- Gambar file ada: storage/app/public/sliders/image.jpg ✅
- Symlink ada: public/storage ✅
- Tapi URL generated salah:
  ❌ http://localhost/storage/sliders/image.jpg
  ❌ http://192.168.0.1/storage/sliders/image.jpg
  ❌ https://domain.dev/storage/sliders/image.jpg
  (bukan domain Anda yang sebenarnya)
```

**Diagnosis:**

```
.env APP_URL tidak di-set dengan benar
atau
Config tidak di-clear setelah update .env
```

**Solusi:**

```bash
STEP 1: Check .env file
---------
Edit: .env

Current value:
APP_URL=http://localhost  ← WRONG!

Change to:
APP_URL=http://kelurahan-petamburan.id  ← CORRECT (no trailing slash)

Save and upload to hosting

STEP 2: Clear config cache
---------
Option A: Via init-storage.php
  - Re-run: https://domain.id/init-storage.php
  - Will clear config automatically

Option B: Via SSH
  php artisan config:clear
  php artisan cache:clear

Option C: Manual clear cache folder
  Via FTP, navigate to: storage/framework/cache/
  Delete ALL files in this folder

STEP 3: Verify configuration
---------
Via browser, create: public_html/test-config.php

Content:
<?php
require 'bootstrap/app.php';
$app = require_once 'bootstrap/app.php';
echo "APP_URL: " . config('app.url') . "<br>";
echo "ASSET URL: " . asset('storage/test.jpg') . "<br>";
?>

Open: https://domain.id/test-config.php

Harus show:
APP_URL: http://kelurahan-petamburan.id
ASSET URL: http://kelurahan-petamburan.id/storage/test.jpg

Jika masih wrong:
- Verify .env uploaded correctly
- Check no trailing space di .env
- Delete test-config.php
```

---

### **Problem 4: Storage Folder Tidak Ada atau Permission Denied**

**Gejala:**

```
- Upload image
- Error: "Permission denied" atau "Cannot write"
- Atau: Upload OK tapi file tidak ada
```

**Solusi:**

```bash
STEP 1: Verify folder exists
---------
Via FTP:
1. Navigate to: public_html/storage/app/public/
2. Harus ada 10 subfolder:
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

3. Jika folder TIDAK ada:
   → init-storage.php belum cukup
   → Manual create folders via File Manager
   → Or re-run init-storage.php

STEP 2: Fix permissions
---------
Via File Manager (mudah):
1. Click folder: public_html/storage/
2. Right-click → Change Permissions
3. Set to: 755 (or 777 jika perlu)
4. Apply recursively (check "Apply to all")
5. Click: Apply

Via SSH (jika available):
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

STEP 3: Verify writeable
---------
Via FTP, navigate to: storage/logs/
Try upload test file: test.txt

Success: ✅ File uploaded
Fail: ❌ Permission denied

If fail:
Contact hosting: "storage/ folder tidak bisa di-write"
```

---

### **Problem 5: Cache Prevents New Images from Showing**

**Gejala:**

```
- Upload image baru
- Admin preview shows new image ✅
- But website still shows old image
- Or: Edit image → still shows old
- Refresh browser: masih old
- Ctrl+F5 (hard refresh): masih old
```

**Diagnosis:**

```
Laravel cache belum di-clear
atau
Browser cache masih hold old version
atau
Config cache belum prune
```

**Solusi:**

```bash
STEP 1: Clear all Laravel caches
---------
Option A: Via SSH
  php artisan cache:clear
  php artisan config:clear
  php artisan view:clear
  php artisan route:clear
  php artisan optimize:clear

Option B: Via init-storage.php (re-run)
  https://domain.id/init-storage.php
  Will clear all automatically

Option C: Manual clear
  Via FTP, delete all files in:
  storage/framework/cache/
  storage/framework/views/

STEP 2: Clear browser cache
---------
1. In browser (Chrome, Firefox, etc):
   Ctrl+Shift+Delete (or Cmd+Shift+Delete Mac)

2. Select:
   Time range: All time
   Cookies and cached images and files: ✓

3. Clear data

4. Close browser completely
5. Reopen and test

STEP 3: Test with ?version trick
---------
In Blade view temporarily:
Current: <img src="{{ asset('storage/' . $slider->image) }}">
Change to: <img src="{{ asset('storage/' . $slider->image . '?v=' . time()) }}">

This forces browser to download fresh image each time
(For testing only, remove after confirm working)

STEP 4: Check CDN/Caching service
---------
If using Cloudflare or other CDN:
1. Go to CDN dashboard
2. Find "Cache" settings
3. Purge cache
4. Or set: Cache-Control: no-cache
```

---

## 📊 COMPLETE TROUBLESHOOTING DECISION TREE

```
START: Gambar tidak muncul?
   |
   ├─→ File ada di storage? (check via FTP)
   |   |
   |   ├─→ NO (file tidak ada)
   |   |   └─→ Problem 1: File not saved
   |   |       ├─ Check upload_max_filesize
   |   |       ├─ Check folder permissions (755)
   |   |       ├─ Check storage folder exists
   |   |       ├─ Check controller code
   |   |       └─ Check database: image column punya value?
   |   |
   |   └─→ YES (file ada)
   |       └─→ URL accessible? (try URL di browser)
   |           |
   |           ├─→ YES (200 OK, image shows)
   |           |   └─→ ✅ SOLVED! Working correctly
   |           |       (maybe caching issue - clear cache)
   |           |
   |           └─→ NO (404 Not Found)
   |               └─→ Problem 2: Symlink issue
   |                   ├─ Check public/storage exists
   |                   ├─ Check if actual symlink
   |                   ├─ Manual create symlink
   |                   └─ Or use .htaccess rewrite
   |
   └─→ File exists and URL works, but wrong URL generated
       └─→ Problem 3: APP_URL configuration
           ├─ Check .env APP_URL value
           ├─ No trailing slash
           ├─ Clear config cache
           └─ Test: asset('storage/test.jpg') formula
```

---

## ✅ POST-FIX VERIFICATION CHECKLIST

After applying any fix, verify:

```
□ Login to admin: https://domain.id/admin ✓

□ Test 1: Fresh upload
  - Dashboard → Slider → Tambah
  - Upload new image
  - Save
  - Check: Does preview show?
  - Check: Does it appear in list?

□ Test 2: Existing image
  - Go to existing slider
  - Check: Does image preview show?
  - Go to edit
  - DON'T change image
  - Just save
  - Check: Image still there?

□ Test 3: Delete and re-upload
  - Delete old image
  - Upload new one
  - Check: New image shows?
  - Check: Old image deleted from storage?

□ Test 4: Update image
  - Edit slider
  - Change image
  - Save
  - Check: New image shows?
  - Check: Old image deleted from storage?
  - Check: Old file no longer in folder?

□ Test 5: Frontend display
  - Close admin browser
  - Visit website: https://domain.id/
  - Slider images show? ✓

□ Test 6: Multiple modules
  - Test slider: ✓
  - Test news: ✓
  - Test gallery: ✓
  - Test achievement: ✓

All tests pass? → ✅ COMPLETE SOLVED!
```

---

## 🚨 EMERGENCY CONTACTS & ESCALATION

If you've tried all steps and still not working:

### **Contact Hosting Support:**

```
Subject: File upload tidak berfungsi di Laravel aplikasi

Deskripsi:
1. Application: Laravel 10
2. Upload mechanism: Store file ke storage/app/public/
3. Web accessible: Via symlink public/storage
4. Problem: Gambar tidak tersimpan OR tidak accessible

Tanya:
1. Apakah hosting support symlink?
2. Apakah upload_max_filesize >= 64MB?
3. Apakah folder storage/ bisa di-write?
4. Apakah Apache mod_rewrite enabled?
5. Apakah php exec() function enabled?

Attach:
- Screenshot: https://domain.id/init-storage.php output
- Screenshot: FTP folder structure storage/app/public/
- Screenshot: Error message (if any)
```

### **Contact Website Developer (jika perlu):**

```
Berikan informasi:
1. Hosting provider dan plan
2. PHP version
3. Screenshots of problems
4. Steps already tried:
   ✓ Ran init-storage.php
   ✓ Created symlink manually
   ✓ Fixed permissions to 755
   ✓ Cleared caches
   ✓ Verified .env APP_URL
   ✓ Checked database values
5. Error logs: storage/logs/laravel.log
```

---

## 📈 SUCCESS INDICATORS (Semuanya Beres!)

```
✅ Admin upload image → auto save ke storage/app/public/sliders/
✅ File permission: 755 (writeable by web server)
✅ Database: image column contains path like "sliders/image.jpg"
✅ URL generated: https://domain.id/storage/sliders/image.jpg
✅ Symlink exists: public/storage → ../storage/app/public
✅ Browser loads image: 200 OK (tidak 404)
✅ Admin preview: Gambar muncul
✅ Frontend: Gambar di website muncul
✅ Edit image: Old file deleted, new file saved
✅ Multiple module: slider + news + gallery + etc = semua OK
✅ No console errors: Browser dev tools clean
✅ No server errors: laravel.log clean (atau hanya warnings)
```

---

## 🎯 FINAL NOTES

```
Ingat:

1. Local & hosting process SAMA PERSIS:
   - Upload image → Controller save dengan disk 'public'
   - File masuk: storage/app/public/sliders/
   - URL: https://domain.id/storage/sliders/image.jpg
   ONLY difference: Local uses php artisan storage:link
                    Hosting uses init-storage.php

2. Jika local OK tapi hosting tidak:
   = 99% adalah symlink issue
   = 1% sisanya: permissions, cache, atau .env

3. init-storage.php script sudah handle:
   ✓ Create storage folders
   ✓ Create symlink
   ✓ Clear cache
   ✓ Fix permissions
   ✓ Log activities

   Jadi jangan skip step: https://domain.id/init-storage.php

4. Jika symlink tidak support:
   → Use .htaccess rewrite rules
   → Sama hasil, other mechanism

5. Always delete init-storage.php setelah selesai!
   → Jangan tinggal di server
```

---

**Sudah coba semua langkah di atas tapi masih tidak jalan?**

→ Buat 3 screenshot:

1. Admin panel dengan preview image (atau broken image)
2. FTP folder structure: storage/app/public/sliders/ (ada/tidak ada)
3. Browser tab URL bar: https://domain.id/storage/sliders/xxx.jpg (200 or 404?)

Dengan 3 screenshot, kita bisa diagnose 95% masalah!

---

**Status:** Complete Troubleshooting Guide  
**Last Updated:** 4 April 2026  
**Guarantee:** Step-by-step solutions cover 99% hosting image problems
