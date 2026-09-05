<?php

namespace Database\Seeders;

use App\Models\FormField;
use App\Models\PageSection;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (env('ADMIN_EMAIL') && env('ADMIN_PASSWORD')) {
            User::query()->updateOrCreate(
                ['email' => env('ADMIN_EMAIL')],
                ['name' => env('ADMIN_NAME', 'Temoe Tumbuh Owner'), 'password' => Hash::make(env('ADMIN_PASSWORD'))]
            );
        }

        PageSection::query()->firstOrCreate(
            ['page' => 'home', 'section_key' => 'hero'],
            [
                'title' => 'Tempat kecil untuk tumbuh dengan besar.',
                'subtitle' => 'Temoe Tumbuh sedang mempersiapkan daycare yang hangat, aman, dan dirancang mengikuti kebutuhan keluarga di Cilegon dan Serang.',
                'cta_label' => 'Isi Form Minat',
                'cta_url' => '/minat',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        $defaults = [
            ['field_key'=>'parent_work_pattern','label'=>'Bagaimana pola kerja orang tua?','type'=>'select','options'=>['WFO','Hybrid','WFH / dari rumah','Lainnya'],'sort_order'=>10],
            ['field_key'=>'important_daycare_factor','label'=>'Apa yang paling penting saat memilih daycare?','type'=>'select','options'=>['Keamanan & pengawasan','Kualitas caregiver','Aktivitas perkembangan','Lokasi','Harga','Jam operasional'],'sort_order'=>20],
            ['field_key'=>'current_childcare','label'=>'Saat ini anak biasanya diasuh oleh siapa?','type'=>'select','options'=>['Orang tua','Kakek/nenek atau keluarga','Nanny / ART','Daycare lain','Lainnya'],'sort_order'=>30],
        ];

        foreach ($defaults as $field) {
            FormField::query()->firstOrCreate(
                ['form_key' => 'interest', 'field_key' => $field['field_key']],
                array_merge($field, ['form_key'=>'interest','is_required'=>false,'is_active'=>true])
            );
        }
    }
}
