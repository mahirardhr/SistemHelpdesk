<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DepartemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departemens = [
            'Bagian secretariat & Hukum',
            'Direktorat Komersil',
            'Direktorat Operasional',
            'Bagian Akuntansi & Keuangan',
            'Bagian Satuan Pengawasan Internal',
            'Bagian Sekretariat & Hukum',
            'Bagian Pengadaan & Teknologi Informasi',
            'Bagian SDM & Sistem Manajemen',
            'Bagian Teknik & Pengolahan',
            'Divisi Investasi Tanaman',
            'Bagian Tanaman',
            'Sub Bagian Kesejahteraan & HI',
            'Sub Bagian Logistik',
            'Sub Bag. Sistem Manajemen & Sustainability',
            'Sub Bagian Keuangan & HPS',
            'Sub Bagian Pajak & Asuransi',
            'Sub Bagian Hukum & Perizinan',
            'Sub Bagian Traksi & Infrastruktur Kebun',
            'Sub Bagian Produksi Tanaman',
            'Sub Bagian TJSL',
            'Ketua Tim 3 Pengawasan Bid.Tep',
            'Sub Bagian Pengolahan',
            'Sub Bagian Investasi & Ekploitasi Pabrik',
            'Sub Bagian QC & Administrasi Tanaman',
            'Tim Pengadaan 2',
            'Tim Pengadaan 1',
            'Sub Bagian Sekretariatan & Humas',
            'Sub Bagian Anggaran & Verivikasi',
            'Sub Bagian Pengembangan SDM & Talenta',
            'Sub Bagian Investasi & Pemetaan Tanaman',
            'Sub Bagian Akuntansi',
            'Sub Bagian Personalia Manajemen Kinerja SDM',
            'Ketua Tim 5 Pengawasan Wilayah Timur',
            'Ketua Tim 1 Pengawasan Admi, Pemasaran, SDM',
            'Tim Pengadaan 3',
            'Ketua Tim 2 Pengawasan Bid.Tnm',
            'Sub Bagian TI Operasional',
            'Ketua Tim 6 Manajemen Risiko',
            'CO Head PMO',
            'Sub Bagian Pemupukan & Proteksi Tanaman',
            'SUb Bag. Kantor Perwakilan Jakarta',
            'Distrik Barat',
            'Distrik Timur',
            'Distrik Petani Mitra',
            'Kebun Sei Galuh',
            'Kebun Sei Garo',
            'Kebun Sei Pagar',
            'Kebun Tanjung Medan',
            'Kebun Tanah Putih',
            'Kebun Kemitraan SGH/SGO/SPA',
            'Kebun Kemitraan SBT/LDA/AMO',
            'Kebun Tandun',
            'Kebun Terantam',
            'Kebun Sei Kencana',
            'Kebun Sei Lindai',
            'Kebun Tamora',
            'Kebun Sei Batulangkah',
            'Kebun Sei Rokan',
            'Kebun Sei Intan',
            'Kebun Sei Siasam',
            'Kebun Sei Tapung',
            'Kebun Sei Berlian',
            'Kebun Kemitraan STA/SIN/SSI',
            'Pabrik Lubuk Dalam',
            'Pabrik Tandun',
            'Pabrik Terantam',
            'Pabrik Sei Tapung',
            'Parik Sei Rokan',
            'Pabrik Tanah Putih',
            'Pabrik Tanjung Medan',
            'Pabrik Sei Pagar',
            'Pabrik Sei Garo',
            'Pabrik Sei Buatan',
            'Parik Sei Intan',
            'PPIS Tandun',
            'Pabrik Karet Lindai',
        ];

        $data = array_map(function ($nama) {
            return ['nama_departemen' => $nama];
        }, $departemens);

        DB::table('departemens')->insert($data);
    }
}
