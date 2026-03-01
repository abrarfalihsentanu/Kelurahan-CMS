<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\Infographic;
use App\Models\Potential;
use Illuminate\Database\Seeder;

class InformasiSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedAchievements();
        $this->seedInfographics();
        $this->seedPotentials();
    }

    private function seedAchievements(): void
    {
        $achievements = [
            [
                'title' => 'Juara 1 Lomba Kelurahan Terbaik Tingkat Kota',
                'description' => 'Kelurahan Petamburan berhasil meraih peringkat pertama dalam kompetisi Kelurahan Terbaik se-Jakarta Pusat tahun 2025, berkat inovasi pelayanan digital dan partisipasi masyarakat yang tinggi.',
                'icon' => 'fa fa-trophy',
                'year' => '2025',
                'level' => 'Kota',
                'organizer' => 'Pemerintah Kota Jakarta Pusat',
                'order' => 1,
                'is_published' => true,
            ],
            [
                'title' => 'Penghargaan Pelayanan Publik Prima',
                'description' => 'Kelurahan Petamburan menerima penghargaan dari Kementerian PANRB sebagai unit pelayanan publik berkategori "Sangat Baik" dengan nilai IKM 96,4.',
                'icon' => 'fa fa-award',
                'year' => '2025',
                'level' => 'Nasional',
                'organizer' => 'Kementerian PANRB',
                'order' => 2,
                'is_published' => true,
            ],
            [
                'title' => 'Juara 2 Kampung Iklim Tingkat Provinsi',
                'description' => 'Program Kampung Iklim RW 06 Kelurahan Petamburan mendapat penghargaan dari Pemprov DKI Jakarta atas upaya adaptasi dan mitigasi perubahan iklim.',
                'icon' => 'fa fa-leaf',
                'year' => '2024',
                'level' => 'Provinsi',
                'organizer' => 'Pemerintah Provinsi DKI Jakarta',
                'order' => 3,
                'is_published' => true,
            ],
            [
                'title' => 'Kelurahan Sadar Hukum',
                'description' => 'Mendapat predikat Kelurahan Sadar Hukum dari Kementerian Hukum dan HAM berkat tingginya kesadaran masyarakat dalam mematuhi peraturan dan aktif dalam penyuluhan hukum.',
                'icon' => 'fa fa-balance-scale',
                'year' => '2024',
                'level' => 'Nasional',
                'organizer' => 'Kementerian Hukum dan HAM RI',
                'order' => 4,
                'is_published' => true,
            ],
            [
                'title' => 'Juara 3 Lomba Posyandu Aktif',
                'description' => 'Posyandu Mawar RW 03 berhasil meraih juara 3 dalam lomba Posyandu Aktif tingkat Kecamatan Tanah Abang berkat konsistensi pelayanan kesehatan ibu dan anak.',
                'icon' => 'fa fa-heartbeat',
                'year' => '2024',
                'level' => 'Kecamatan',
                'organizer' => 'Kecamatan Tanah Abang',
                'order' => 5,
                'is_published' => true,
            ],
            [
                'title' => 'Penghargaan Administrasi Kependudukan Terbaik',
                'description' => 'Kelurahan Petamburan dinobatkan sebagai kelurahan dengan administrasi kependudukan terbaik se-Jakarta Pusat atas capaian perekaman e-KTP dan akta kelahiran.',
                'icon' => 'fa fa-id-card',
                'year' => '2023',
                'level' => 'Kota',
                'organizer' => 'Dinas Kependudukan dan Pencatatan Sipil',
                'order' => 6,
                'is_published' => true,
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::create($achievement);
        }
    }

    private function seedInfographics(): void
    {
        $infographics = [
            // Kependudukan
            [
                'title' => 'Data Penduduk Berdasarkan Jenis Kelamin 2025',
                'description' => 'Infografis jumlah penduduk Kelurahan Petamburan berdasarkan jenis kelamin. Laki-laki: 21.340 jiwa, Perempuan: 21.160 jiwa.',
                'category' => 'Kependudukan',
                'source' => 'BPS Jakarta Pusat & Dukcapil',
                'year' => '2025',
                'order' => 1,
                'is_published' => true,
            ],
            [
                'title' => 'Komposisi Penduduk Berdasarkan Usia',
                'description' => 'Distribusi penduduk menurut kelompok usia: 0-14 tahun (22%), 15-64 tahun (68%), 65+ tahun (10%).',
                'category' => 'Kependudukan',
                'source' => 'BPS Jakarta Pusat',
                'year' => '2025',
                'order' => 2,
                'is_published' => true,
            ],
            [
                'title' => 'Tingkat Pendidikan Penduduk',
                'description' => 'Data tingkat pendidikan terakhir warga: SD (8%), SMP (15%), SMA/SMK (42%), D3/S1 (30%), S2/S3 (5%).',
                'category' => 'Kependudukan',
                'source' => 'Dinas Pendidikan DKI Jakarta',
                'year' => '2025',
                'order' => 3,
                'is_published' => true,
            ],
            [
                'title' => 'Data Penduduk Berdasarkan Pekerjaan',
                'description' => 'Komposisi mata pencaharian: Karyawan Swasta (35%), Wiraswasta (20%), PNS/TNI/Polri (10%), Pelajar/Mahasiswa (18%), Lainnya (17%).',
                'category' => 'Kependudukan',
                'source' => 'BPS Jakarta Pusat',
                'year' => '2025',
                'order' => 4,
                'is_published' => true,
            ],

            // Lingkungan
            [
                'title' => 'Peta Sebaran Ruang Terbuka Hijau (RTH)',
                'description' => 'Peta lokasi dan luas Ruang Terbuka Hijau di wilayah Kelurahan Petamburan. Total RTH: 2,5 hektar dari 90,10 hektar luas wilayah.',
                'category' => 'Lingkungan',
                'source' => 'Dinas Pertamanan DKI Jakarta',
                'year' => '2025',
                'order' => 5,
                'is_published' => true,
            ],
            [
                'title' => 'Data Pengelolaan Sampah per RW',
                'description' => 'Volume pengelolaan sampah rata-rata harian per RW, termasuk jumlah bank sampah aktif dan tingkat daur ulang.',
                'category' => 'Lingkungan',
                'source' => 'Dinas Lingkungan Hidup DKI Jakarta',
                'year' => '2025',
                'order' => 6,
                'is_published' => true,
            ],
            [
                'title' => 'Titik Rawan Banjir & Genangan',
                'description' => 'Peta titik-titik rawan banjir dan genangan di Kelurahan Petamburan beserta upaya mitigasi yang telah dilakukan.',
                'category' => 'Lingkungan',
                'source' => 'BPBD DKI Jakarta',
                'year' => '2024',
                'order' => 7,
                'is_published' => true,
            ],

            // Sosial
            [
                'title' => 'Data Penerima Bantuan Sosial 2025',
                'description' => 'Rekapitulasi penerima bantuan sosial: PKH (850 KPM), BPNT (1.200 KPM), BST (620 KPM).',
                'category' => 'Sosial',
                'source' => 'Dinas Sosial DKI Jakarta',
                'year' => '2025',
                'order' => 8,
                'is_published' => true,
            ],
            [
                'title' => 'Jumlah UMKM dan Pelaku Usaha',
                'description' => 'Data pelaku UMKM di Kelurahan Petamburan: Mikro (320), Kecil (85), Menengah (12). Total 417 UMKM aktif.',
                'category' => 'Sosial',
                'source' => 'Dinas PPUMKM DKI Jakarta',
                'year' => '2025',
                'order' => 9,
                'is_published' => true,
            ],
            [
                'title' => 'Tingkat Partisipasi Musrenbang 2025',
                'description' => 'Infografis tingkat kehadiran dan partisipasi warga dalam Musrenbang tingkat kelurahan dari tahun 2021 hingga 2025.',
                'category' => 'Sosial',
                'source' => 'Kelurahan Petamburan',
                'year' => '2025',
                'order' => 10,
                'is_published' => true,
            ],
        ];

        foreach ($infographics as $infographic) {
            Infographic::create($infographic);
        }
    }

    private function seedPotentials(): void
    {
        $potentials = [
            [
                'title' => 'Pusat Kuliner & UMKM Petamburan',
                'description' => 'Kawasan kuliner malam yang ramai dan beragam, menjadi daya tarik wisata kuliner di Jakarta Pusat.',
                'content' => '<p>Kelurahan Petamburan memiliki potensi ekonomi yang besar di sektor kuliner dan UMKM. Kawasan Jl. KS Tubun dan sekitarnya dikenal sebagai pusat kuliner malam yang menyajikan aneka makanan khas Betawi, Padang, Jawa, dan Chinese Food.</p><p>Saat ini terdapat lebih dari <strong>320 UMKM mikro</strong> dan <strong>85 usaha kecil</strong> yang aktif beroperasi di wilayah kelurahan. Kelurahan terus mendorong pemberdayaan UMKM melalui pelatihan, akses permodalan, dan digitalisasi usaha.</p>',
                'icon' => 'fa fa-utensils',
                'category' => 'Ekonomi',
                'order' => 1,
                'is_published' => true,
            ],
            [
                'title' => 'Potensi Wisata Religi & Sejarah',
                'description' => 'Keberadaan masjid bersejarah dan situs budaya yang menjadi identitas wilayah Petamburan.',
                'content' => '<p>Kelurahan Petamburan memiliki potensi wisata religi dengan keberadaan <strong>Masjid Az-Zikra</strong> dan beberapa mushala bersejarah yang menjadi pusat kegiatan keagamaan masyarakat.</p><p>Selain itu, kawasan ini memiliki nilai sejarah sebagai bagian dari perkembangan kota Jakarta sejak era kolonial. Potensi ini dapat dikembangkan menjadi destinasi wisata edukasi dan religi yang menarik.</p>',
                'icon' => 'fa fa-mosque',
                'category' => 'Budaya',
                'order' => 2,
                'is_published' => true,
            ],
            [
                'title' => 'Kampung Tematik Bersih & Hijau',
                'description' => 'Program kampung tematik di beberapa RW yang berhasil mengubah lingkungan menjadi asri dan bersih.',
                'content' => '<p>Beberapa RW di Kelurahan Petamburan telah berhasil mengembangkan <strong>kampung tematik</strong> yang berfokus pada kebersihan dan penghijauan lingkungan:</p><ul><li><strong>RW 06</strong> - Kampung Iklim dengan program bank sampah, komposting, dan biopori</li><li><strong>RW 03</strong> - Kampung Toga (Tanaman Obat Keluarga) dengan kebun herbal bersama</li><li><strong>RW 08</strong> - Kampung Bersih dengan sistem pengelolaan sampah terpadu</li></ul><p>Program ini tidak hanya meningkatkan kualitas lingkungan tetapi juga mempererat kebersamaan warga.</p>',
                'icon' => 'fa fa-seedling',
                'category' => 'Lingkungan',
                'order' => 3,
                'is_published' => true,
            ],
            [
                'title' => 'Potensi Sumber Daya Manusia',
                'description' => 'Tingginya partisipasi pemuda dan karang taruna dalam pembangunan wilayah.',
                'content' => '<p>Kelurahan Petamburan memiliki potensi SDM yang kuat dengan <strong>68% penduduk berusia produktif</strong> (15-64 tahun). Karang Taruna aktif di seluruh RW dengan berbagai program pemberdayaan:</p><ul><li>Pelatihan keterampilan digital dan kewirausahaan</li><li>Program magang dan penempatan kerja</li><li>Kegiatan olahraga dan seni budaya</li><li>Relawan tanggap bencana dan sosial</li></ul><p>Dukungan dari organisasi kemasyarakatan seperti <strong>PKK, FKDM, LMK,</strong> dan <strong>Karang Taruna</strong> menjadikan Petamburan kelurahan yang aktif dan partisipatif.</p>',
                'icon' => 'fa fa-user-graduate',
                'category' => 'Sosial',
                'order' => 4,
                'is_published' => true,
            ],
            [
                'title' => 'Akses Strategis & Transportasi',
                'description' => 'Lokasi strategis yang dilalui berbagai moda transportasi publik Jakarta.',
                'content' => '<p>Kelurahan Petamburan memiliki keunggulan lokasi yang sangat strategis di pusat Jakarta:</p><ul><li><strong>Stasiun Tanah Abang</strong> - stasiun kereta terbesar di Jakarta, berjarak hanya 1 km</li><li><strong>Halte TransJakarta</strong> di Jl. KS Tubun dan Jl. Jatibaru</li><li><strong>MRT Jakarta</strong> - akses ke Stasiun Dukuh Atas (±2 km)</li><li>Dilalui jalur angkutan kota dan mikrolet berbagai rute</li></ul><p>Akses transportasi yang baik menjadikan Petamburan lokasi yang ideal untuk pengembangan ekonomi dan hunian urban.</p>',
                'icon' => 'fa fa-bus',
                'category' => 'Ekonomi',
                'order' => 5,
                'is_published' => true,
            ],
        ];

        foreach ($potentials as $potential) {
            Potential::create($potential);
        }
    }
}
