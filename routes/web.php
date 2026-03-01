<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PerangkatController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PpidController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\AgendaController as FrontendAgendaController;
use App\Http\Controllers\Auth\LoginController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\NewsCategoryController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\OfficialController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ServiceHourController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\InfographicController;
use App\Http\Controllers\Admin\PotentialController;
use App\Http\Controllers\Admin\ComplaintCategoryController;
use App\Http\Controllers\Admin\ComplaintController;
use App\Http\Controllers\Admin\PpidCategoryController;
use App\Http\Controllers\Admin\PpidDocumentController;
use App\Http\Controllers\Admin\PpidRequestController;
use App\Http\Controllers\Admin\PeriodicInformationController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Language Switch
Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['id', 'en'])) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/perangkat', [PerangkatController::class, 'index'])->name('perangkat');
Route::get('/layanan', [LayananController::class, 'index'])->name('layanan');
Route::get('/informasi', [InformasiController::class, 'index'])->name('informasi');

// Agenda
Route::get('/agenda', [FrontendAgendaController::class, 'index'])->name('agenda');

// Berita
Route::get('/berita', [BeritaController::class, 'index'])->name('berita');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');

// Pengaduan
Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan');
Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
Route::get('/pengaduan/tracking', [PengaduanController::class, 'tracking'])->name('pengaduan.tracking');

// PPID
Route::get('/ppid', [PpidController::class, 'index'])->name('ppid');
Route::post('/ppid/permohonan', [PpidController::class, 'storeRequest'])->name('ppid.request');
Route::post('/ppid/keberatan', [PpidController::class, 'storeKeberatan'])->name('ppid.keberatan');
Route::get('/ppid/tracking', [PpidController::class, 'tracking'])->name('ppid.tracking');
Route::get('/ppid/download/{document}', [PpidController::class, 'download'])->name('ppid.download');

// Kontak
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');
Route::post('/kontak', [KontakController::class, 'store'])->name('kontak.store');
Route::get('/kontak/tracking', [KontakController::class, 'tracking'])->name('kontak.tracking');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->middleware('admin')->name('admin.')->group(function () {
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

    // Admin Users
    Route::resource('users', UserController::class)->except(['show']);

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});
