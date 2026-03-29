# IMPLEMENTATION CODE SNIPPETS

## Ready-to-Use Code for Fixing Issues

---

## 1. ADD ROLE SUPPORT TO USER MODEL

**File:** `app/Models/User.php`

Replace the current User model with:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Role checking methods
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isEditor(): bool
    {
        return in_array($this->role, ['admin', 'editor']);
    }

    public function isViewer(): bool
    {
        return in_array($this->role, ['admin', 'editor', 'viewer']);
    }

    public function can($action, $model = null): bool
    {
        if ($this->isAdmin()) {
            return true; // Admin can do anything
        }

        if ($action === 'edit' && $this->isEditor()) {
            if ($model && method_exists($model, 'getTable')) {
                $editableTables = ['news', 'pages', 'sliders', 'settings'];
                return in_array($model->getTable(), $editableTables);
            }
            return true;
        }

        return false;
    }
}
```

---

## 2. CREATE MIGRATION TO ADD ROLE COLUMN

**File:** `database/migrations/2026_03_29_000000_add_role_to_users_table.php`

Create new file with:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'editor', 'viewer'])
                ->default('viewer')
                ->after('is_active');
        });

        // Set existing users as admin (they must be admin if already in system)
        DB::table('users')
            ->where('id', '>', 0)
            ->update(['role' => 'admin']);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
```

---

## 3. CREATE ADMIN MIDDLEWARE

**File:** `app/Http/Middleware/RequireAdmin.php`

Create new file with:

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if (!$user->is_active) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')
                ->with('error', 'Akun Anda telah dinonaktifkan.');
        }

        if (!$user->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
```

---

## 4. CREATE EDITOR MIDDLEWARE

**File:** `app/Http/Middleware/RequireEditor.php`

Create new file with:

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireEditor
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if (!$user->is_active) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')
                ->with('error', 'Akun Anda telah dinonaktifkan.');
        }

        if (!$user->isEditor()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
```

---

## 5. UPDATE HTTP KERNEL

**File:** `app/Http/Kernel.php`

Update `$middlewareAliases` array to include:

```php
protected $middlewareAliases = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
    'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
    'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
    'can' => \Illuminate\Auth\Middleware\Authorize::class,
    'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
    'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
    'signed' => \App\Http\Middleware\ValidateSignature::class,
    'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
    'require.admin' => \App\Http\Middleware\RequireAdmin::class,        // ADD THIS
    'require.editor' => \App\Http\Middleware\RequireEditor::class,      // ADD THIS
];
```

---

## 6. UPDATE ROUTES WITH AUTHORIZATION

**File:** `routes/web.php`

Replace the admin routes section with:

```php
// Admin Routes - Require Admin Role
Route::prefix('admin')
    ->middleware(['auth', 'require.admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Settings (special - no create/delete)
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

        // Resources
        Route::resource('sliders', SliderController::class);
        Route::resource('statistics', StatisticController::class);
        Route::resource('galleries', GalleryController::class);
        Route::resource('news-categories', NewsCategoryController::class);
        Route::resource('news', AdminNewsController::class);
        Route::resource('pages', PageController::class);
        Route::resource('divisions', DivisionController::class);
        Route::resource('officials', OfficialController::class);
        Route::resource('service-categories', ServiceCategoryController::class);
        Route::resource('services', ServiceController::class);
        Route::resource('service-hours', ServiceHourController::class);
        Route::resource('agendas', AgendaController::class);
        Route::resource('achievements', AchievementController::class);
        Route::resource('information-categories', InformationCategoryController::class);
        Route::resource('infographics', InfographicController::class);
        Route::resource('potentials', PotentialController::class);
        Route::resource('complaint-categories', ComplaintCategoryController::class);
        Route::resource('complaints', ComplaintController::class)->except(['create', 'store']);
        Route::resource('periodic-informations', PeriodicInformationController::class);
        Route::resource('ppid-categories', PpidCategoryController::class);
        Route::resource('ppid-documents', PpidDocumentController::class);
        Route::resource('ppid-requests', PpidRequestController::class)->except(['create', 'store', 'edit']);
        Route::resource('contacts', ContactController::class)->only(['index', 'show', 'destroy']);
        Route::put('contacts/{contact}/respond', [ContactController::class, 'respond'])->name('contacts.respond');

        // Admin Users Management (Admin only)
        Route::resource('users', UserController::class)->except(['show']);

        // Profile
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    });

// Optional: Editor Routes (Content management only)
Route::prefix('editor')
    ->middleware(['auth', 'require.editor'])
    ->name('editor.')
    ->group(function () {
        Route::resource('news', AdminNewsController::class);
        Route::resource('pages', PageController::class);
        Route::resource('galleries', GalleryController::class);
        Route::resource('sliders', SliderController::class);
    });
```

---

## 7. CREATE FILE VALIDATOR HELPER

**File:** `app/Helpers/FileValidator.php`

Create new file with:

```php
<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Exception;

class FileValidator
{
    public const MAX_FILE_SIZE = 5120 * 1024; // 5MB in bytes

    private static array $allowedMimes = [
        'jpeg' => ['image/jpeg'],
        'jpg' => ['image/jpeg'],
        'png' => ['image/png'],
        'webp' => ['image/webp'],
        'gif' => ['image/gif'],
        'pdf' => ['application/pdf'],
        'doc' => ['application/msword'],
        'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
        'txt' => ['text/plain'],
    ];

    private static array $dangerousMimes = [
        'application/x-msdownload',
        'application/x-msdos-program',
        'application/x-executable',
        'application/x-elf',
        'application/x-sharedlib',
        'application/x-sh',
        'application/x-bash',
    ];

    /**
     * Validate uploaded file
     */
    public static function validate(
        UploadedFile $file,
        array $allowedExtensions = ['jpeg', 'jpg', 'png'],
        int $maxSize = self::MAX_FILE_SIZE
    ): bool {
        try {
            // Check file size
            if ($file->getSize() > $maxSize) {
                $maxSizeMB = round($maxSize / (1024 * 1024));
                throw new Exception("Ukuran file melebihi limit {$maxSizeMB}MB.");
            }

            // Get actual MIME type
            $mime = mime_content_type($file->getRealPath());

            // Check for dangerous MIME types
            if (in_array($mime, self::$dangerousMimes)) {
                throw new Exception('Tipe file tidak diizinkan.');
            }

            // Get extension
            $ext = strtolower($file->getClientOriginalExtension());

            // Check if extension is allowed
            if (!in_array($ext, $allowedExtensions)) {
                throw new Exception('Ekstensi file tidak diizinkan. Izinkan: ' . implode(', ', $allowedExtensions));
            }

            // Verify MIME matches declared extension
            if (!isset(self::$allowedMimes[$ext])) {
                throw new Exception('Ekstensi file tidak valid.');
            }

            if (!in_array($mime, self::$allowedMimes[$ext])) {
                throw new Exception('Tipe MIME file tidak sesuai dengan ekstensi.');
            }

            // Additional check: validate file magic bytes
            $this->validateMagicBytes($file->getRealPath(), $ext);

            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Validate magic bytes (file signatures)
     */
    private static function validateMagicBytes(string $filePath, string $ext): void
    {
        $handle = fopen($filePath, 'r');
        $header = fread($handle, 12);
        fclose($handle);

        $checks = [
            'jpg' => ['FFD8FF'],
            'jpeg' => ['FFD8FF'],
            'png' => ['89504E47'],
            'gif' => ['474946'],
            'pdf' => ['25504446'],
            'webp' => ['RIFF'],
        ];

        if (!isset($checks[$ext])) {
            return; // No magic byte check for this type
        }

        $hex = bin2hex($header);
        $validSignature = false;

        foreach ($checks[$ext] as $signature) {
            if (stripos($hex, $signature) === 0) {
                $validSignature = true;
                break;
            }
        }

        if (!$validSignature) {
            throw new Exception('File signature tidak valid.');
        }
    }
}
```

---

## 8. UPDATE NEWS CONTROLLER WITH VALIDATION

**File:** `app/Http/Controllers/Admin/NewsController.php`

Update `store()` method:

```php
use App\Helpers\FileValidator;
use Exception;

public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|max:255',
        'slug' => 'nullable|max:255|unique:news',
        'category_id' => 'required|exists:news_categories,id',
        'content' => 'required',
        'excerpt' => 'nullable|max:500',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'nullable|date',
    ]);

    // Additional file validation
    if ($request->hasFile('image')) {
        try {
            FileValidator::validate(
                $request->file('image'),
                ['jpg', 'jpeg', 'png', 'webp'],
                2048 * 1024 // 2MB
            );
        } catch (Exception $e) {
            return back()->withErrors(['image' => $e->getMessage()]);
        }
    }

    $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);

    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('news', 'public');
    }

    $validated['is_published'] = $request->boolean('is_published');
    $validated['is_featured'] = $request->boolean('is_featured');

    if ($validated['is_published'] && !$validated['published_at']) {
        $validated['published_at'] = now();
    }

    News::create($validated);

    return redirect()->route('admin.news.index')
        ->with('success', 'Berita berhasil ditambahkan.');
}
```

---

## 9. ADD PAGINATION TO ADMIN CONTROLLERS

**File:** `app/Http/Controllers/Admin/NewsController.php`

Update `index()` method:

```php
public function index()
{
    $news = News::with('category')
        ->latest()
        ->paginate(25);

    return view('admin.news.index', compact('news'));
}
```

---

## 10. ADD RATE LIMITING TO ROUTES

**File:** `routes/web.php`

Update form submission routes:

```php
// Public form submissions with rate limiting
Route::post('/pengaduan', [PengaduanController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('pengaduan.store');

Route::post('/ppid/permohonan', [PpidController::class, 'storeRequest'])
    ->middleware('throttle:5,1')
    ->name('ppid.request');

Route::post('/ppid/keberatan', [PpidController::class, 'storeKeberatan'])
    ->middleware('throttle:5,1')
    ->name('ppid.keberatan');

Route::post('/kontak', [KontakController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('kontak.store');
```

---

## 11. CREATE MIGRATION FOR DATABASE INDEXES

**File:** `database/migrations/2026_03_29_000001_add_indexes_to_tables.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add indexes to foreign keys
        Schema::table('news', function (Blueprint $table) {
            if (!$this->hasIndex('news', 'news_category_id')) {
                $table->index('news_category_id');
            }
            if (!$this->hasIndex('news', 'user_id')) {
                $table->index('user_id');
            }
            if (!$this->hasIndex('news', 'created_at')) {
                $table->index('created_at');
            }
        });

        Schema::table('services', function (Blueprint $table) {
            if (!$this->hasIndex('services', 'service_category_id')) {
                $table->index('service_category_id');
            }
            if (!$this->hasIndex('services', 'is_active')) {
                $table->index('is_active');
            }
        });

        Schema::table('officials', function (Blueprint $table) {
            if (!$this->hasIndex('officials', 'division_id')) {
                $table->index('division_id');
            }
            if (!$this->hasIndex('officials', 'level')) {
                $table->index('level');
            }
        });

        Schema::table('complaints', function (Blueprint $table) {
            if (!$this->hasIndex('complaints', 'complaint_category_id')) {
                $table->index('complaint_category_id');
            }
            if (!$this->hasIndex('complaints', 'responded_by')) {
                $table->index('responded_by');
            }
            if (!$this->hasIndex('complaints', 'status')) {
                $table->index('status');
            }
            if (!$this->hasIndex('complaints', 'created_at')) {
                $table->index('created_at');
            }
        });

        Schema::table('ppid_requests', function (Blueprint $table) {
            if (!$this->hasIndex('ppid_requests', 'responded_by')) {
                $table->index('responded_by');
            }
            if (!$this->hasIndex('ppid_requests', 'status')) {
                $table->index('status');
            }
            if (!$this->hasIndex('ppid_requests', 'created_at')) {
                $table->index('created_at');
            }
        });

        Schema::table('contacts', function (Blueprint $table) {
            if (!$this->hasIndex('contacts', 'responded_by')) {
                $table->index('responded_by');
            }
            if (!$this->hasIndex('contacts', 'is_read')) {
                $table->index('is_read');
            }
            if (!$this->hasIndex('contacts', 'created_at')) {
                $table->index('created_at');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (!$this->hasIndex('users', 'is_active')) {
                $table->index('is_active');
            }
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropIndex(['news_category_id']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropIndex(['service_category_id']);
            $table->dropIndex(['is_active']);
        });

        Schema::table('officials', function (Blueprint $table) {
            $table->dropIndex(['division_id']);
            $table->dropIndex(['level']);
        });

        Schema::table('complaints', function (Blueprint $table) {
            $table->dropIndex(['complaint_category_id']);
            $table->dropIndex(['responded_by']);
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('ppid_requests', function (Blueprint $table) {
            $table->dropIndex(['responded_by']);
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropIndex(['responded_by']);
            $table->dropIndex(['is_read']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
        });
    }

    private function hasIndex(string $table, string $column): bool
    {
        return collect(\DB::select(
            \DB::raw(
                "SHOW INDEX FROM {$table} WHERE Column_name = '{$column}'"
            )
        ))->count() > 0;
    }
};
```

---

## 12. IMPROVE DOWNLOAD WITH PATH VALIDATION

**File:** `app/Http/Controllers/PpidController.php`

Update `download()` method:

```php
use Illuminate\Support\Facades\File;

public function download(PpidDocument $document)
{
    $filePath = storage_path('app/public/' . $document->file);

    // Validate file exists
    if (!File::exists($filePath)) {
        abort(404, 'File not found.');
    }

    // Prevent directory traversal attacks
    $realPath = realpath($filePath);
    $storagePath = realpath(storage_path('app/public'));

    if (!$realPath || !str_starts_with($realPath, $storagePath)) {
        abort(403, 'Unauthorized file access.');
    }

    // Log download for audit trail
    \Log::info('File downloaded', [
        'file' => $document->file,
        'user_id' => auth()->id() ?? null,
        'ip' => request()->ip(),
    ]);

    $document->incrementDownloads();

    return response()->download($filePath, basename($filePath));
}
```

---

## USAGE

Copy and paste each section into the appropriate file. Remember to:

1. Update namespaces if needed
2. Add use statements at the top
3. Test each change before deploying
4. Run migrations: `php artisan migrate`
5. Clear cache: `php artisan cache:clear`

---

Generated: March 29, 2026
