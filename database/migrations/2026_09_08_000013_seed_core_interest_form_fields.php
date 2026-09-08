<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $settings = DB::table('settings')
            ->where('group', 'interest_form')
            ->pluck('value', 'key');

        $value = fn (string $key, string $default): string => (string) ($settings[$key] ?? $default);
        $options = function (string $key, string $default) use ($value): array {
            return collect(preg_split('/\r\n|\r|\n/', $value($key, $default)))
                ->map(fn ($item) => trim($item))
                ->filter()
                ->unique()
                ->values()
                ->all();
        };

        $now = now();
        $fields = [
            ['parent', 'parent_name', $value('parent_name_label', 'Nama Moms / orang tua'), 'text', $value('parent_name_placeholder', ''), null, true, 10],
            ['parent', 'whatsapp', $value('whatsapp_label', 'Nomor WhatsApp'), 'tel', $value('whatsapp_placeholder', '08xxxxxxxxxx'), null, true, 20],
            ['parent', 'email', $value('email_label', 'Email'), 'email', $value('email_placeholder', ''), null, false, 30],
            ['child', 'child_name', $value('child_name_label', 'Nama anak'), 'text', $value('child_name_placeholder', ''), null, false, 10],
            ['child', 'child_age', $value('child_age_label', 'Usia anak (tahun)'), 'number', $value('child_age_placeholder', 'Isi 0 untuk usia di bawah 1 tahun'), null, false, 20],
            ['child', 'city', $value('city_label', 'Kota'), 'select', $value('city_placeholder', 'Pilih kota'), $options('city_options', "Cilegon\nSerang\nLainnya"), false, 30],
            ['child', 'district', $value('district_label', 'Kecamatan / area tinggal'), 'text', $value('district_placeholder', ''), null, false, 40],
            ['child', 'preferred_location', $value('preferred_location_label', 'Area daycare yang paling nyaman'), 'text', $value('preferred_location_placeholder', 'Contoh: Cilegon Kota, Cibeber, dekat kantor...'), null, false, 50],
            ['daycare', 'preferred_schedule', $value('preferred_schedule_label', 'Kebutuhan jadwal'), 'select', $value('preferred_schedule_placeholder', 'Pilih'), $options('preferred_schedule_options', "Senin–Jumat full day\nBeberapa hari per minggu\nHalf day\nFleksibel / insidental"), false, 10],
            ['daycare', 'preferred_start_date', $value('preferred_start_date_label', 'Kapan ingin mulai?'), 'date', null, null, false, 20],
            ['daycare', 'budget_range', $value('budget_range_label', 'Budget daycare per bulan'), 'select', $value('budget_range_placeholder', 'Pilih range'), $options('budget_range_options', "< Rp1,5 juta\nRp1,5–2 juta\nRp2–2,5 juta\nRp2,5–3 juta\n> Rp3 juta"), false, 30],
        ];

        foreach ($fields as [$sectionKey, $fieldKey, $label, $type, $placeholder, $fieldOptions, $required, $sortOrder]) {
            DB::table('form_fields')->insertOrIgnore([
                'form_key' => 'interest',
                'section_key' => $sectionKey,
                'field_key' => $fieldKey,
                'label' => $label,
                'type' => $type,
                'placeholder' => $placeholder ?: null,
                'help_text' => null,
                'options' => $fieldOptions ? json_encode($fieldOptions, JSON_UNESCAPED_UNICODE) : null,
                'is_required' => $required,
                'is_active' => true,
                'sort_order' => $sortOrder,
                'validation_rules' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        DB::table('form_fields')
            ->where('form_key', 'interest')
            ->whereIn('field_key', [
                'parent_name', 'whatsapp', 'email', 'child_name', 'child_age', 'city',
                'district', 'preferred_location', 'preferred_schedule',
                'preferred_start_date', 'budget_range',
            ])
            ->delete();
    }
};
