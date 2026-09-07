<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $sections = [
            'hero' => [
                'title' => 'Tempat kecil untuk cerita tumbuh yang besar.',
                'subtitle' => 'Moms bisa melangkah lebih tenang, sementara si kecil bermain, belajar, dan tumbuh di lingkungan yang hangat sesuai tahap usianya.',
                'content' => null,
                'cta_label' => 'Amankan Priority Slot',
                'cta_url' => '/minat',
                'sort_order' => 10,
            ],
            'daily_rhythm' => [
                'title' => 'Banyak bergerak, cukup beristirahat.',
                'subtitle' => 'Ritme yang seimbang membuat si kecil menikmati harinya, dan Moms tetap tenang mengikuti ceritanya.',
                'content' => 'Hari yang terarah, tanpa kehilangan serunya bermain.',
                'cta_label' => null,
                'cta_url' => null,
                'sort_order' => 30,
            ],
            'parent_updates' => [
                'title' => 'Kamu tetap jadi bagian dari hari mereka.',
                'subtitle' => 'Momen penting, aktivitas, makan, tidur, dan catatan hariannya dirangkum agar Moms tidak merasa kehilangan cerita.',
                'content' => null,
                'cta_label' => null,
                'cta_url' => null,
                'sort_order' => 60,
            ],
            'pricing' => [
                'title' => 'Care lengkap, mulai dari Rp1,6 juta.',
                'subtitle' => 'Pilih ritme yang cocok untuk keluarga Kamu. Moms akan mendapat rincian paket sesuai usia anak, jadwal, dan ketersediaan slot.',
                'content' => 'Rp1,6 juta | Semua yang si kecil butuhkan untuk menjalani hari dengan nyaman.',
                'cta_label' => 'Cek Paket untuk Si Kecil',
                'cta_url' => '/minat',
                'sort_order' => 70,
            ],
            'facilities' => [
                'title' => 'Yang Moms dapatkan di Temoe Tumbuh',
                'subtitle' => 'Fasilitas yang membuat hari anak lebih aman, nyaman, aktif, dan tetap terasa dekat dengan rumah.',
                'content' => implode("\n", [
                    'Lingkungan aman & child-friendly | Ruang disiapkan untuk aktivitas sesuai tahap usia.',
                    'Makan & snack bernutrisi | Menu harian untuk mendukung energi si kecil.',
                    'Program sesuai usia | Mulai dari bayi, toddler, hingga pre-school.',
                    'Daily update untuk Moms | Momen, aktivitas, makan, tidur, dan catatan harian.',
                    'Area istirahat nyaman | Ritme aktif dan tenang yang lebih seimbang.',
                    'Play-based learning | Eksplorasi sensori, seni, bahasa, dan gerak.',
                ]),
                'cta_label' => null,
                'cta_url' => null,
                'sort_order' => 71,
            ],
        ];

        foreach ($sections as $key => $section) {
            $query = DB::table('page_sections')->where('page', 'home')->where('section_key', $key);
            $payload = array_merge($section, ['is_active' => true, 'updated_at' => $now]);

            if ($query->exists()) {
                $query->update($payload);
            } else {
                DB::table('page_sections')->insert(array_merge(
                    ['page' => 'home', 'section_key' => $key],
                    $payload,
                    ['created_at' => $now]
                ));
            }
        }
    }

    public function down(): void
    {
        DB::table('page_sections')
            ->where('page', 'home')
            ->whereIn('section_key', ['pricing', 'facilities'])
            ->delete();
    }
};
