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
                'subtitle' => 'Hari-hari yang penuh bermain, rasa aman, dan stimulasi bermakna—supaya anak tumbuh bahagia dan orang tua melangkah lebih tenang.',
                'content' => null,
                'cta_label' => 'Amankan Priority Slot',
                'cta_url' => '/minat',
                'sort_order' => 10,
            ],
            'daily_rhythm' => [
                'title' => 'Banyak bergerak, cukup beristirahat.',
                'subtitle' => 'Ritme yang seimbang membuat anak menikmati harinya.',
                'content' => 'Hari yang terarah, tanpa kehilangan serunya bermain.',
                'cta_label' => null,
                'cta_url' => null,
                'sort_order' => 20,
            ],
            'space_play' => [
                'title' => 'Ruang bermain dan eksplorasi',
                'subtitle' => 'Area utama untuk bergerak, bermain, dan berteman.',
                'content' => null,
                'cta_label' => null,
                'cta_url' => null,
                'sort_order' => 30,
            ],
            'space_rest' => [
                'title' => 'Sudut tenang dan beristirahat',
                'subtitle' => 'Ruang nyaman saat anak perlu menurunkan energi.',
                'content' => null,
                'cta_label' => null,
                'cta_url' => null,
                'sort_order' => 40,
            ],
            'parent_updates' => [
                'title' => 'Lo tetap jadi bagian dari hari mereka.',
                'subtitle' => 'Momen penting, aktivitas, makan, tidur, dan catatan hariannya dirangkum agar orang tua tidak merasa kehilangan cerita.',
                'content' => null,
                'cta_label' => null,
                'cta_url' => null,
                'sort_order' => 50,
            ],
        ];

        foreach ($sections as $key => $data) {
            $query = DB::table('page_sections')
                ->where('page', 'home')
                ->where('section_key', $key);

            if ($query->exists()) {
                $query->update(array_merge($data, [
                    'is_active' => true,
                    'updated_at' => $now,
                ]));

                continue;
            }

            DB::table('page_sections')->insert(array_merge($data, [
                'page' => 'home',
                'section_key' => $key,
                'image_path' => null,
                'is_active' => true,
                'meta' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }

    public function down(): void
    {
        // Konten CMS tidak dihapus saat rollback agar upload dan edit pengguna tetap aman.
    }
};
