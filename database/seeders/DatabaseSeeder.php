<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Statistic;
use App\Models\NewsCategory;
use App\Models\News;
use App\Models\Division;
use App\Models\Official;
use App\Models\ServiceCategory;
use App\Models\Service;
use App\Models\ServiceHour;
use App\Models\Agenda;
use App\Models\ComplaintCategory;
use App\Models\PpidCategory;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create or update admin user
        User::updateOrCreate(
            ['email' => 'admin@kelurahan-petamburan.go.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'is_active' => true,
                'is_admin' => true,
            ]
        );

        // Settings
        $this->seedSettings();

        // Sliders
        $this->seedSliders();

        // Statistics
        $this->seedStatistics();

        // News Categories & News
        $this->seedNews();

        // Officials & Divisions
        $this->seedOfficials();

        // Services
        $this->seedServices();

        // Service Hours
        $this->seedServiceHours();

        // Agendas
        $this->seedAgendas();

        // Complaint Categories
        $this->seedComplaintCategories();

        // PPID Categories
        $this->seedPpidCategories();

        // Achievements, Infographics, Potentials
        $this->call(InformasiSeeder::class);
    }

    private function seedSettings()
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'Kelurahan Petamburan', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Kecamatan Tanah Abang · Jakarta Pusat', 'group' => 'general'],
            ['key' => 'parent_org', 'value' => 'Pemerintah Provinsi DKI Jakarta', 'group' => 'general'],
            ['key' => 'province', 'value' => 'Provinsi DKI Jakarta', 'group' => 'general'],
            ['key' => 'phone', 'value' => '(021) 5303540', 'group' => 'contact'],
            ['key' => 'email', 'value' => 'kel.petamburan@jakarta.go.id', 'group' => 'contact'],
            ['key' => 'whatsapp', 'value' => '0812-1234-5678', 'group' => 'contact'],
            ['key' => 'address', 'value' => 'Jl. KS Tubun No.1, Petamburan, Tanah Abang, Jakarta Pusat 10260', 'group' => 'contact'],
            ['key' => 'address_short', 'value' => 'Jl. KS Tubun No.1, Jakarta Pusat', 'group' => 'contact'],
            ['key' => 'service_hours', 'value' => 'Senin–Jumat, 08.00–16.00 WIB', 'group' => 'contact'],
            ['key' => 'ikm_score', 'value' => '96.4', 'group' => 'general'],
            ['key' => 'ikm_period', 'value' => 'Semester I 2026', 'group' => 'general'],
            ['key' => 'instagram', 'value' => 'https://instagram.com/petamburan', 'group' => 'social'],
            ['key' => 'facebook', 'value' => 'https://facebook.com/petamburan', 'group' => 'social'],
            ['key' => 'youtube', 'value' => '', 'group' => 'social'],
            ['key' => 'twitter', 'value' => '', 'group' => 'social'],
            ['key' => 'footer_description', 'value' => 'Melayani masyarakat dengan sepenuh hati, transparan, akuntabel, dan berintegritas untuk Jakarta yang lebih baik.', 'group' => 'general'],
            ['key' => 'footer_credit', 'value' => 'Dibangun oleh Tim IT Pemprov DKI Jakarta', 'group' => 'general'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }

    private function seedSliders()
    {
        $sliders = [
            [
                'title' => 'Musrenbang 2026: 48 Usulan Warga Dibahas Bersama',
                'description' => 'Kelurahan Petamburan menggelar Forum Musrenbang untuk membahas prioritas pembangunan wilayah bersama seluruh elemen masyarakat.',
                'tag' => 'Berita Terkini',
                'tag_icon' => 'fa fa-star',
                'button_text' => 'Baca Selengkapnya',
                'button_link' => '/berita',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Sambut Ramadan, Kelurahan Gelar Bersih-Bersih Masjid',
                'description' => 'Jajaran Kelurahan Petamburan bersama 3 pilar melaksanakan kegiatan bersih-bersih Masjid Arrahman menyambut bulan suci Ramadan.',
                'tag' => 'Kegiatan',
                'tag_icon' => 'fa fa-mosque',
                'button_text' => 'Baca Selengkapnya',
                'button_link' => '/berita',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => '60 Kader PKK Ikuti Pelatihan Makanan Sehat & Bergizi',
                'description' => 'Program peningkatan kapasitas kader PKK Kelurahan Petamburan dalam bidang gizi dan ketahanan pangan keluarga.',
                'tag' => 'PKK',
                'tag_icon' => 'fa fa-users',
                'button_text' => 'Baca Selengkapnya',
                'button_link' => '/berita',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }
    }

    private function seedStatistics()
    {
        $stats = [
            ['icon' => 'fa fa-map-marked-alt', 'value' => '90,10', 'label' => 'Hektar Luas Wilayah', 'order' => 1, 'is_active' => true],
            ['icon' => 'fa fa-layer-group', 'value' => '11', 'label' => 'Rukun Warga (RW)', 'order' => 2, 'is_active' => true],
            ['icon' => 'fa fa-home', 'value' => '116', 'label' => 'Rukun Tetangga (RT)', 'order' => 3, 'is_active' => true],
            ['icon' => 'fa fa-users', 'value' => '42.500+', 'label' => 'Jiwa Penduduk', 'order' => 4, 'is_active' => true],
            ['icon' => 'fa fa-star', 'value' => '96,4', 'label' => 'Nilai IKM', 'order' => 5, 'is_active' => true],
        ];

        foreach ($stats as $stat) {
            Statistic::create($stat);
        }
    }

    private function seedNews()
    {
        $categories = [
            ['name' => 'Kegiatan', 'slug' => 'kegiatan', 'icon' => 'fa fa-tasks', 'description' => 'Kegiatan kelurahan', 'order' => 1, 'is_active' => true],
            ['name' => 'Sosial', 'slug' => 'sosial', 'icon' => 'fa fa-users', 'description' => 'Program sosial', 'order' => 2, 'is_active' => true],
            ['name' => 'PKK', 'slug' => 'pkk', 'icon' => 'fa fa-woman', 'description' => 'Program PKK', 'order' => 3, 'is_active' => true],
            ['name' => 'Pemerintahan', 'slug' => 'pemerintahan', 'icon' => 'fa fa-building', 'description' => 'Berita pemerintahan', 'order' => 4, 'is_active' => true],
        ];

        foreach ($categories as $cat) {
            NewsCategory::updateOrCreate(
                ['slug' => $cat['slug']],
                $cat
            );
        }

        $news = [
            [
                'news_category_id' => 1,
                'user_id' => 1,
                'title' => 'Kelurahan Petamburan Laksanakan Forum Musrenbang Membahas 48 Usulan Warga',
                'slug' => 'musrenbang-2026-48-usulan-warga',
                'excerpt' => 'Forum Musyawarah Perencanaan Pembangunan (Musrenbang) Kelurahan Petamburan tahun 2026 resmi diselenggarakan dengan membahas sebanyak 48 usulan prioritas dari warga...',
                'content' => '<p>Forum Musyawarah Perencanaan Pembangunan (Musrenbang) Kelurahan Petamburan tahun 2026 resmi diselenggarakan dengan membahas sebanyak 48 usulan prioritas dari warga.</p><p>Kegiatan ini dihadiri oleh seluruh perangkat kelurahan, ketua RT/RW, tokoh masyarakat, dan perwakilan warga dari 11 RW yang ada di Kelurahan Petamburan.</p>',
                'is_featured' => true,
                'is_published' => true,
                'published_at' => '2026-02-07 10:00:00',
            ],
            [
                'news_category_id' => 2,
                'user_id' => 1,
                'title' => 'Sambut Ramadan, Jajaran Kelurahan Bersih-Bersih Masjid Arrahman',
                'slug' => 'bersih-bersih-masjid-arrahman',
                'excerpt' => 'Kegiatan bersih-bersih masjid sebagai bentuk persiapan menyambut bulan suci Ramadan 1447H bersama 3 pilar kelurahan...',
                'content' => '<p>Kegiatan bersih-bersih masjid sebagai bentuk persiapan menyambut bulan suci Ramadan 1447H bersama 3 pilar kelurahan.</p>',
                'is_published' => true,
                'published_at' => '2026-02-06 09:00:00',
            ],
            [
                'news_category_id' => 3,
                'user_id' => 1,
                'title' => '60 Kader PKK Ikuti Pelatihan Membuat Makanan Sehat dan Bergizi',
                'slug' => 'pelatihan-kader-pkk-makanan-bergizi',
                'excerpt' => 'Program pelatihan intensif bagi kader PKK kelurahan dalam rangka meningkatkan pengetahuan gizi dan ketahanan pangan...',
                'content' => '<p>Program pelatihan intensif bagi kader PKK kelurahan dalam rangka meningkatkan pengetahuan gizi dan ketahanan pangan.</p>',
                'is_published' => true,
                'published_at' => '2026-01-27 14:00:00',
            ],
            [
                'news_category_id' => 4,
                'user_id' => 1,
                'title' => 'Sebanyak 14 Ketua TP PKK Kelurahan Resmi Dilantik',
                'slug' => 'pelantikan-ketua-tp-pkk',
                'excerpt' => 'Pelantikan Ketua Tim Penggerak PKK tingkat kelurahan se-Kecamatan Tanah Abang dilaksanakan secara resmi...',
                'content' => '<p>Pelantikan Ketua Tim Penggerak PKK tingkat kelurahan se-Kecamatan Tanah Abang dilaksanakan secara resmi.</p>',
                'is_published' => true,
                'published_at' => '2025-12-19 11:00:00',
            ],
        ];

        foreach ($news as $item) {
            News::updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }
    }

    private function seedOfficials()
    {
        $divisions = [
            ['name' => 'Seksi Pemerintahan', 'short_name' => 'Kasi Pemerintahan', 'order' => 1, 'is_active' => true],
            ['name' => 'Seksi Ekonomi dan Pembangunan', 'short_name' => 'Kasi Ekbang', 'order' => 2, 'is_active' => true],
            ['name' => 'Seksi Kesejahteraan Rakyat', 'short_name' => 'Kasi Kesra', 'order' => 3, 'is_active' => true],
            ['name' => 'Seksi Ketentraman dan Ketertiban', 'short_name' => 'Kasi Tramtib', 'order' => 4, 'is_active' => true],
        ];

        foreach ($divisions as $div) {
            Division::updateOrCreate(
                ['name' => $div['name']],
                $div
            );
        }

        $officials = [
            ['name' => 'Rian Hermanu', 'position' => 'Lurah', 'level' => 'lurah', 'order' => 1, 'is_active' => true],
            ['name' => 'Siti Rahayu, S.E.', 'position' => 'Sekretaris Kelurahan', 'level' => 'sekretaris', 'order' => 2, 'is_active' => true],
            ['name' => 'Ahmad Fauzi', 'position' => 'Kasi Pemerintahan', 'level' => 'kasi', 'division_id' => 1, 'order' => 3, 'is_active' => true],
            ['name' => 'Dewi Kurniasih', 'position' => 'Kasi Ekbang', 'level' => 'kasi', 'division_id' => 2, 'order' => 4, 'is_active' => true],
            ['name' => 'Budi Santoso', 'position' => 'Kasi Kesra', 'level' => 'kasi', 'division_id' => 3, 'order' => 5, 'is_active' => true],
            ['name' => 'Rini Wahyuni', 'position' => 'Kasi Tramtib', 'level' => 'kasi', 'division_id' => 4, 'order' => 6, 'is_active' => true],
        ];

        foreach ($officials as $official) {
            Official::updateOrCreate(
                ['name' => $official['name']],
                $official
            );
        }
    }

    private function seedServices()
    {
        $categories = [
            ['name' => 'Administrasi Kependudukan', 'slug' => 'administrasi-kependudukan', 'icon' => 'fa fa-id-card', 'is_active' => true],
            ['name' => 'Surat Keterangan', 'slug' => 'surat-keterangan', 'icon' => 'fa fa-file-alt', 'is_active' => true],
            ['name' => 'Perizinan', 'slug' => 'perizinan', 'icon' => 'fa fa-stamp', 'is_active' => true],
        ];

        foreach ($categories as $cat) {
            ServiceCategory::updateOrCreate(
                ['slug' => $cat['slug']],
                $cat
            );
        }

        $services = [
            [
                'service_category_id' => 1,
                'name' => 'Surat Pengantar KTP Elektronik',
                'slug' => 'ktp',
                'icon' => 'fa fa-id-card',
                'description' => 'Pengantar untuk pembuatan & perubahan data KTP elektronik',
                'requirements' => ['Surat Pengantar dari RT/RW', 'Fotokopi Kartu Keluarga (KK)', 'Akta Kelahiran (jika ada)', 'Formulir F-1.01 (tersedia di kelurahan)'],
                'duration' => '1 Hari Kerja',
                'cost' => 'Gratis',
                'schedule' => 'Senin–Jumat',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'service_category_id' => 1,
                'name' => 'Perubahan Data Kartu Keluarga',
                'slug' => 'kk',
                'icon' => 'fa fa-users',
                'description' => 'Penambahan anggota keluarga, perubahan data KK',
                'requirements' => ['Surat Pengantar dari RT/RW', 'KK Asli', 'KTP Kepala Keluarga', 'Dokumen Pendukung (Akta Nikah/Cerai/Kematian)'],
                'duration' => '1 Hari Kerja',
                'cost' => 'Gratis',
                'schedule' => 'Senin–Jumat',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'service_category_id' => 2,
                'name' => 'Surat Keterangan Domisili',
                'slug' => 'skd',
                'icon' => 'fa fa-file-alt',
                'description' => 'Surat keterangan tempat tinggal untuk berbagai keperluan',
                'requirements' => ['Surat Pengantar dari RT/RW', 'Fotokopi KTP', 'Fotokopi KK'],
                'duration' => '1 Hari Kerja',
                'cost' => 'Gratis',
                'schedule' => 'Senin–Jumat',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'service_category_id' => 2,
                'name' => 'Surat Keterangan Tidak Mampu',
                'slug' => 'sktm',
                'icon' => 'fa fa-file-signature',
                'description' => 'SKTM untuk keperluan bantuan sosial dan pendidikan',
                'requirements' => ['Surat Pengantar dari RT/RW', 'Fotokopi KTP', 'Fotokopi KK', 'Surat Pernyataan Tidak Mampu'],
                'duration' => '1 Hari Kerja',
                'cost' => 'Gratis',
                'schedule' => 'Senin–Jumat',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'service_category_id' => 1,
                'name' => 'Pengantar Akta Kelahiran',
                'slug' => 'akta',
                'icon' => 'fa fa-baby',
                'description' => 'Surat pengantar untuk penerbitan akta kelahiran',
                'requirements' => ['Surat Keterangan Lahir dari RS/Bidan', 'KK Orang Tua', 'KTP Orang Tua', 'Akta Nikah Orang Tua'],
                'duration' => '1 Hari Kerja',
                'cost' => 'Gratis',
                'schedule' => 'Senin–Jumat',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'service_category_id' => 3,
                'name' => 'Izin Usaha Mikro',
                'slug' => 'usaha',
                'icon' => 'fa fa-store',
                'description' => 'Pengantar penerbitan Nomor Induk Berusaha (NIB)',
                'requirements' => ['Surat Pengantar dari RT/RW', 'Fotokopi KTP', 'Fotokopi KK', 'Pas Foto 3x4'],
                'duration' => '1-3 Hari Kerja',
                'cost' => 'Gratis',
                'schedule' => 'Senin–Jumat',
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['slug' => $service['slug']],
                $service
            );
        }
    }

    private function seedServiceHours()
    {
        $hours = [
            ['day' => 'Senin', 'day_order' => 0, 'open_time' => '08:00', 'close_time' => '16:00', 'break_start' => '12:00', 'break_end' => '13:00'],
            ['day' => 'Selasa', 'day_order' => 1, 'open_time' => '08:00', 'close_time' => '16:00', 'break_start' => '12:00', 'break_end' => '13:00'],
            ['day' => 'Rabu', 'day_order' => 2, 'open_time' => '08:00', 'close_time' => '16:00', 'break_start' => '12:00', 'break_end' => '13:00'],
            ['day' => 'Kamis', 'day_order' => 3, 'open_time' => '08:00', 'close_time' => '16:00', 'break_start' => '12:00', 'break_end' => '13:00'],
            ['day' => 'Jumat', 'day_order' => 4, 'open_time' => '08:00', 'close_time' => '16:30', 'break_start' => '11:30', 'break_end' => '13:00'],
            ['day' => 'Sabtu', 'day_order' => 5, 'is_closed' => true],
            ['day' => 'Minggu', 'day_order' => 6, 'is_closed' => true],
        ];

        foreach ($hours as $hour) {
            ServiceHour::updateOrCreate(
                ['day' => $hour['day']],
                $hour
            );
        }
    }

    private function seedAgendas()
    {
        $agendas = [
            [
                'title' => 'Rapat Koordinasi Perangkat Kelurahan',
                'description' => 'Pembahasan evaluasi program kerja bulan Januari–Februari dan penyusunan rencana kegiatan bulan Maret 2026.',
                'event_date' => '2026-02-25',
                'start_time' => '09:00',
                'end_time' => '11:00',
                'location' => 'Aula Kelurahan Petamburan',
                'status' => 'upcoming',
            ],
            [
                'title' => 'Posyandu Balita RW 03 & RW 07',
                'description' => 'Penimbangan balita, pemberian imunisasi, dan konsultasi gizi bersama Puskesmas Petamburan.',
                'event_date' => '2026-02-27',
                'start_time' => '08:00',
                'end_time' => '12:00',
                'location' => 'Pos Kesehatan RW 03',
                'status' => 'upcoming',
            ],
            [
                'title' => 'Sosialisasi Program Bantuan Sosial 2026',
                'description' => 'Penjelasan mekanisme penyaluran bantuan sosial tahun 2026, verifikasi data penerima, dan tanya jawab dengan warga.',
                'event_date' => '2026-03-05',
                'start_time' => '13:00',
                'end_time' => '15:00',
                'location' => 'Balai Warga RW 05',
                'status' => 'upcoming',
            ],
            [
                'title' => 'Kegiatan Jumat Bersih – Gotong Royong Warga',
                'description' => 'Program rutin kebersihan lingkungan bersama perangkat kelurahan, tiga pilar, dan seluruh warga.',
                'event_date' => '2026-03-10',
                'start_time' => '07:00',
                'end_time' => '09:00',
                'location' => 'Seluruh Wilayah RT/RW',
                'status' => 'upcoming',
            ],
        ];

        foreach ($agendas as $agenda) {
            Agenda::updateOrCreate(
                ['title' => $agenda['title']],
                $agenda
            );
        }
    }

    private function seedComplaintCategories()
    {
        $categories = [
            ['name' => 'Infrastruktur', 'slug' => 'infrastruktur', 'icon' => 'fa fa-road', 'is_active' => true],
            ['name' => 'Kebersihan', 'slug' => 'kebersihan', 'icon' => 'fa fa-broom', 'is_active' => true],
            ['name' => 'Keamanan', 'slug' => 'keamanan', 'icon' => 'fa fa-shield-alt', 'is_active' => true],
            ['name' => 'Pelayanan', 'slug' => 'pelayanan', 'icon' => 'fa fa-headset', 'is_active' => true],
            ['name' => 'Lainnya', 'slug' => 'lainnya', 'icon' => 'fa fa-ellipsis-h', 'is_active' => true],
        ];

        foreach ($categories as $cat) {
            ComplaintCategory::updateOrCreate(
                ['slug' => $cat['slug']],
                $cat
            );
        }
    }

    private function seedPpidCategories()
    {
        $categories = [
            ['name' => 'Struktur PPID', 'slug' => 'struktur-ppid', 'icon' => 'fa fa-sitemap', 'description' => 'Susunan organisasi Pejabat Pengelola Informasi dan Dokumentasi Kelurahan Petamburan', 'order' => 1, 'is_active' => true],
            ['name' => 'Tugas dan Fungsi PPID', 'slug' => 'tugas-fungsi-ppid', 'icon' => 'fa fa-tasks', 'description' => 'Uraian tugas pokok dan fungsi PPID dalam pengelolaan informasi publik', 'order' => 2, 'is_active' => true],
            ['name' => 'Dokumen Informasi Publik', 'slug' => 'dokumen-informasi-publik', 'icon' => 'fa fa-folder-open', 'description' => 'Daftar dokumen informasi publik yang tersedia untuk diakses masyarakat', 'order' => 3, 'is_active' => true],
            ['name' => 'Waktu & Biaya Layanan', 'slug' => 'waktu-biaya-layanan', 'icon' => 'fa fa-clock', 'description' => 'Informasi mengenai standar waktu dan biaya dalam pelayanan informasi publik', 'order' => 4, 'is_active' => true],
            ['name' => 'Informasi Berkala', 'slug' => 'informasi-berkala', 'icon' => 'fa fa-calendar-alt', 'description' => 'Informasi yang wajib disediakan dan diumumkan secara berkala kepada publik', 'order' => 5, 'is_active' => true],
            ['name' => 'SOP PPID', 'slug' => 'sop-ppid', 'icon' => 'fa fa-project-diagram', 'description' => 'Standar Operasional Prosedur pelayanan informasi dan penanganan sengketa', 'order' => 6, 'is_active' => true],
        ];

        foreach ($categories as $cat) {
            PpidCategory::updateOrCreate(
                ['name' => $cat['name']],
                $cat
            );
        }
    }
}
