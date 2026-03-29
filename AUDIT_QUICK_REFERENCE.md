# AUDIT FINDINGS SUMMARY

## Kelurahan Petamburan CMS - Priority & Action Plan

---

## 🔴 CRITICAL SECURITY ISSUES (ACTION REQUIRED BEFORE PRODUCTION)

### ❌ Issue #1: DEBUG MODE ENABLED

- **File:** `.env` line 4
- **Current:** `APP_DEBUG=true`
- **Risk:** Information disclosure, stack traces visible to attackers
- **Fix:** `APP_DEBUG=false` (1 line change)
- **Time:** 1 minute

### ❌ Issue #2: CORS OPEN TO ALL ORIGINS

- **File:** `config/cors.php` line 17
- **Current:** `'allowed_origins' => ['*']`
- **Risk:** Any website can access your API, CSRF attacks
- **Fix:** Replace `['*']` with specific domains
- **Time:** 10 minutes

### ❌ Issue #3: NO AUTHORIZATION ON ADMIN ROUTES

- **File:** `routes/web.php` + Admin Controllers
- **Current:** Only checks `is_active`, no role-based access
- **Risk:** Any logged-in user can access admin → delete users, modify data
- **Fix:** Implement role-based middleware (admin/editor/viewer)
- **Time:** 2-3 hours

---

## 🟡 MEDIUM PRIORITY ISSUES (Fix in Next Sprint)

### Issue #4: NO PAGINATION ON LISTINGS

- **Files:** Admin controllers (News, Complaints, PPID)
- **Current:** `->get()` loads all records at once
- **Risk:** Memory issues with large datasets
- **Fix:** Add `->paginate(25)`
- **Time:** 30 minutes

### Issue #5: WEAK FILE UPLOAD VALIDATION

- **Files:** NewsController, PengaduanController, GalleryController
- **Current:** Only checks MIME type (can be spoofed)
- **Risk:** Malicious file upload
- **Fix:** Validate actual file content + magic bytes
- **Time:** 1 hour

### Issue #6: NO RATE LIMITING ON PUBLIC FORMS

- **Files:** Contact form, Complaint form, PPID requests
- **Current:** No protection against spam/DoS
- **Risk:** Database flooded with spam entries
- **Fix:** Add `middleware('throttle:10,1')`
- **Time:** 30 minutes

### Issue #7: MISSING DATABASE INDEXES

- **Files:** Migration files
- **Current:** Foreign keys not indexed
- **Risk:** Slow queries when filtering
- **Fix:** Add new migration with indexes
- **Time:** 20 minutes

---

## 🟢 LOW PRIORITY ISSUES (Nice to Have)

- Issue #8: Empty AppServiceProvider
- Issue #9: Missing download file path validation
- Issue #10: Weak session security configuration
- Issue #11: Inconsistent status values (model vs controller)
- Other 13 minor issues...

---

## QUICK ACTION PLAN

### Phase 1: SECURITY HARDENING (1-2 hours) ⚠️ MUST DO BEFORE PRODUCTION

```
1. Change APP_DEBUG=false
2. Fix CORS configuration
3. Implement role-based authorization
4. Add HTTPS/SSL enforcement
```

### Phase 2: DATA INTEGRITY (1-2 hours)

```
5. Add pagination to listings
6. Create database indexes
7. Fix migration naming
```

### Phase 3: ROBUSTNESS (2-3 hours)

```
8. Enhance file validation
9. Add rate limiting
10. Improve error handling
```

---

## ESTIMATED EFFORT

| Category        | Count  | Time             |
| --------------- | ------ | ---------------- |
| HIGH (CRITICAL) | 3      | 2.5-3 hours      |
| MEDIUM          | 9      | 4-5 hours        |
| LOW             | 12     | 2-3 hours        |
| **TOTAL**       | **24** | **8.5-11 hours** |

**Recommended Timeline:**

- Day 1: Fix all HIGH issues
- Day 2-3: Fix MEDIUM issues
- Day 4: Fix LOW issues + Testing

---

## FILES TO MODIFY

**Configuration Files:**

- `.env`
- `config/cors.php`
- `config/session.php`

**Routes:**

- `routes/web.php`
- `routes/api.php`

**Middleware (Create New):**

- `app/Http/Middleware/RequireAdmin.php`
- `app/Http/Middleware/RequireEditor.php`
- `app/Http/Middleware/ForceHttps.php`

**Controllers (Update):**

- `app/Http/Controllers/Admin/NewsController.php`
- `app/Http/Controllers/Admin/ComplaintController.php`
- `app/Http/Controllers/Admin/PpidRequestController.php`
- `app/Http/Controllers/Admin/ContactController.php`
- `app/Http/Controllers/Admin/UserController.php`
- `app/Http/Controllers/Admin/GalleryController.php`
- `app/Http/Controllers/PengaduanController.php`
- `app/Http/Controllers/PpidController.php`

**Models (Update):**

- `app/Models/User.php`
- `app/Models/Complaint.php`
- `app/Models/PpidRequest.php`

**Migrations (Create New):**

- `2026_03_29_add_role_to_users.php`
- `2026_03_29_add_indexes_to_tables.php`

---

## DETAILED FIXES - COPY PASTE READY

### Fix #1: Change APP_DEBUG

**File:** `.env` (Line 4)

FROM:

```env
APP_DEBUG=true
```

TO:

```env
APP_DEBUG=false  # For production
```

---

### Fix #2: Fix CORS Configuration

**File:** `config/cors.php`

Replace lines 17-22 FROM:

```php
'paths' => ['api/*', 'sanctum/csrf-cookie'],

'allowed_methods' => ['*'],

'allowed_origins' => ['*'],

'allowed_origins_patterns' => [],

'allowed_headers' => ['*'],
```

TO:

```php
'paths' => ['api/*', 'sanctum/csrf-cookie'],

'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'OPTIONS'],

'allowed_origins' => [
    env('APP_URL', 'http://localhost'),
    'https://kelurahan-petamburan.go.id',
],

'allowed_origins_patterns' => [],

'allowed_headers' => ['Content-Type', 'Authorization', 'X-Requested-With'],

'exposed_headers' => ['X-Total-Count'],

'max_age' => 86400,

'supports_credentials' => true,
```

---

### Fix #3: Add Pagination

**File:** `app/Http/Controllers/Admin/NewsController.php` (Line 15)

FROM:

```php
public function index() {
    $news = News::with('category')->latest()->get();
    return view('admin.news.index', compact('news'));
}
```

TO:

```php
public function index() {
    $news = News::with('category')
        ->latest()
        ->paginate(25);
    return view('admin.news.index', compact('news'));
}
```

Apply same change to:

- `ComplaintController::index()`
- `PpidRequestController::index()`
- `ContactController::index()`

---

### Fix #4: Add Rate Limiting

**File:** `routes/web.php`

FROM:

```php
Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
```

TO:

```php
Route::post('/pengaduan', [PengaduanController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('pengaduan.store');
```

Apply to:

- PPID request (throttle:5,1)
- PPID keberatan (throttle:5,1)
- Contact form (throttle:10,1)

---

### Fix #5: Add Download Validation

**File:** `app/Http/Controllers/PpidController.php` (Line 73)

FROM:

```php
public function download(PpidDocument $document) {
    $document->incrementDownloads();
    return response()->download(storage_path('app/public/' . $document->file));
}
```

TO:

```php
public function download(PpidDocument $document) {
    use Illuminate\Support\Facades\File;

    $filePath = storage_path('app/public/' . $document->file);

    if (!File::exists($filePath)) {
        abort(404, 'File not found.');
    }

    if (!str_starts_with(realpath($filePath), realpath(storage_path('app/public')))) {
        abort(403, 'Unauthorized file access.');
    }

    $document->incrementDownloads();
    return response()->download($filePath);
}
```

---

## VERIFICATION CHECKLIST

After implementing fixes, verify:

- [ ] APP_DEBUG is false when APP_ENV=production
- [ ] CORS only allows specific origins
- [ ] All admin routes require login AND user->isAdmin()
- [ ] Admin listings have pagination (max 25 items per page)
- [ ] Rate limiting returns 429 status after threshold
- [ ] Database indexes created (`php artisan migrate`)
- [ ] File uploads validate magic bytes
- [ ] Download doesn't allow directory traversal
- [ ] No debug info in production error pages
- [ ] Authentication middleware is working
- [ ] HTTPS is enforced in .htaccess or middleware

---

## DEPLOYMENT COMMAND CHECKLIST

```bash
# Before deploying to production
composer update
php artisan config:cache
php artisan route:cache
php artisan migrate --force
php artisan optimize
php artisan view:cache

# Clear caches after deploy
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## REFERENCE LINKS

- Laravel Security: https://laravel.com/docs/security
- OWASP Top 10: https://owasp.org/www-project-top-ten/
- CWE-79 (XSS): https://cwe.mitre.org/data/definitions/79.html
- CWE-434 (File Upload): https://cwe.mitre.org/data/definitions/434.html

---

**Last Updated:** March 29, 2026  
**Next Review:** After implementing all HIGH priority fixes
