<?php

namespace App\Services;

use App\Models\Setting;

class InterestFormContent
{
    public const DEFAULTS = [
        'seo_title' => 'Daftar Minat — Temoe Tumbuh',
        'seo_description' => 'Daftar minat Temoe Tumbuh untuk bayi, toddler, dan pre-school di Cilegon dan Serang.',
        'brand_label' => 'Temoe Tumbuh',
        'back_label' => '← Kembali ke homepage',
        'intro_eyebrow' => 'FOUNDING FAMILIES · CILEGON & SERANG',
        'intro_title' => 'Moms, ceritakan kebutuhan si kecil.',
        'intro_description' => 'Isi data singkat ini untuk mendapat informasi paket dan priority slot Temoe Tumbuh. Program tersedia mulai dari bayi, toddler, hingga pre-school.',
        'intro_price_note' => 'Paket mulai dari Rp1,6 juta / bulan',
        'validation_error_title' => 'Ada beberapa data yang perlu dicek.',
        'parent_section_title' => '1. Tentang Moms',
        'parent_name_label' => 'Nama Moms / orang tua',
        'parent_name_placeholder' => '',
        'whatsapp_label' => 'Nomor WhatsApp',
        'whatsapp_placeholder' => '08xxxxxxxxxx',
        'email_label' => 'Email',
        'email_placeholder' => '',
        'child_section_title' => '2. Tentang si kecil & lokasi',
        'child_name_label' => 'Nama anak',
        'child_name_placeholder' => '',
        'child_age_label' => 'Usia anak (tahun)',
        'child_age_placeholder' => 'Isi 0 untuk usia di bawah 1 tahun',
        'city_label' => 'Kota',
        'city_placeholder' => 'Pilih kota',
        'city_options' => "Cilegon\nSerang\nLainnya",
        'district_label' => 'Kecamatan / area tinggal',
        'district_placeholder' => '',
        'preferred_location_label' => 'Area daycare yang paling nyaman',
        'preferred_location_placeholder' => 'Contoh: Cilegon Kota, Cibeber, dekat kantor...',
        'daycare_section_title' => '3. Kebutuhan daycare',
        'preferred_schedule_label' => 'Kebutuhan jadwal',
        'preferred_schedule_placeholder' => 'Pilih',
        'preferred_schedule_options' => "Senin–Jumat full day\nBeberapa hari per minggu\nHalf day\nFleksibel / insidental",
        'preferred_start_date_label' => 'Kapan ingin mulai?',
        'budget_range_label' => 'Budget daycare per bulan',
        'budget_range_placeholder' => 'Pilih range',
        'budget_range_options' => "< Rp1,5 juta\nRp1,5–2 juta\nRp2–2,5 juta\nRp2,5–3 juta\n> Rp3 juta",
        'additional_section_title' => '4. Sedikit lagi, Moms',
        'reservation_label' => 'Aku tertarik mendapat priority slot / Founding Families',
        'reservation_help' => 'Kami akan menghubungi Moms saat Temoe Tumbuh masuk tahap reservasi awal.',
        'privacy_consent_prefix' => 'Aku sudah membaca',
        'privacy_link_label' => 'Pemberitahuan Privasi',
        'privacy_consent_suffix' => 'dan menyetujui penggunaan data untuk komunikasi Temoe Tumbuh.',
        'submit_label' => 'Kirim Pendaftaran Minat →',
        'footer_note' => 'Belum ada kewajiban membeli. Data Kamu hanya digunakan untuk pendaftaran minat dan komunikasi terkait Temoe Tumbuh.',
    ];

    public function values(): array
    {
        return array_replace(self::DEFAULTS, Setting::groupValues('interest_form'));
    }

    public function options(string $key, ?array $values = null): array
    {
        $content = $values ?? $this->values();

        return collect(preg_split('/\r\n|\r|\n/', (string) ($content[$key] ?? '')))
            ->map(fn ($value) => trim($value))
            ->filter()
            ->unique()
            ->take(100)
            ->values()
            ->all();
    }

    public function adminGroups(): array
    {
        return [
            ['title' => 'Identitas halaman', 'description' => 'Judul browser, deskripsi pencarian, brand, dan navigasi.', 'fields' => [
                ['key' => 'seo_title', 'label' => 'Judul halaman'],
                ['key' => 'seo_description', 'label' => 'Meta description', 'type' => 'textarea'],
                ['key' => 'brand_label', 'label' => 'Nama brand di navbar'],
                ['key' => 'back_label', 'label' => 'Teks kembali ke homepage'],
            ]],
            ['title' => 'Pembuka Form Minat', 'description' => 'Seluruh copy yang tampil sebelum kartu formulir.', 'fields' => [
                ['key' => 'intro_eyebrow', 'label' => 'Eyebrow / teks kecil'],
                ['key' => 'intro_title', 'label' => 'Judul utama'],
                ['key' => 'intro_description', 'label' => 'Deskripsi', 'type' => 'textarea'],
                ['key' => 'intro_price_note', 'label' => 'Highlight harga'],
                ['key' => 'validation_error_title', 'label' => 'Pesan saat data belum valid'],
            ]],
            ['title' => 'Section 1 · Orang tua', 'description' => 'Judul section, label, dan placeholder data Moms.', 'fields' => [
                ['key' => 'parent_section_title', 'label' => 'Judul section'],
                ['key' => 'parent_name_label', 'label' => 'Label nama orang tua'],
                ['key' => 'parent_name_placeholder', 'label' => 'Placeholder nama orang tua'],
                ['key' => 'whatsapp_label', 'label' => 'Label WhatsApp'],
                ['key' => 'whatsapp_placeholder', 'label' => 'Placeholder WhatsApp'],
                ['key' => 'email_label', 'label' => 'Label email'],
                ['key' => 'email_placeholder', 'label' => 'Placeholder email'],
            ]],
            ['title' => 'Section 2 · Anak & lokasi', 'description' => 'Semua label dan pilihan lokasi pada section kedua.', 'fields' => [
                ['key' => 'child_section_title', 'label' => 'Judul section'],
                ['key' => 'child_name_label', 'label' => 'Label nama anak'],
                ['key' => 'child_name_placeholder', 'label' => 'Placeholder nama anak'],
                ['key' => 'child_age_label', 'label' => 'Label usia anak'],
                ['key' => 'child_age_placeholder', 'label' => 'Placeholder usia anak'],
                ['key' => 'city_label', 'label' => 'Label kota'],
                ['key' => 'city_placeholder', 'label' => 'Pilihan kosong kota'],
                ['key' => 'city_options', 'label' => 'Pilihan kota', 'type' => 'options'],
                ['key' => 'district_label', 'label' => 'Label kecamatan / area'],
                ['key' => 'district_placeholder', 'label' => 'Placeholder kecamatan / area'],
                ['key' => 'preferred_location_label', 'label' => 'Label area daycare'],
                ['key' => 'preferred_location_placeholder', 'label' => 'Placeholder area daycare'],
            ]],
            ['title' => 'Section 3 · Kebutuhan daycare', 'description' => 'Copy jadwal, tanggal mulai, dan budget.', 'fields' => [
                ['key' => 'daycare_section_title', 'label' => 'Judul section'],
                ['key' => 'preferred_schedule_label', 'label' => 'Label jadwal'],
                ['key' => 'preferred_schedule_placeholder', 'label' => 'Pilihan kosong jadwal'],
                ['key' => 'preferred_schedule_options', 'label' => 'Pilihan jadwal', 'type' => 'options'],
                ['key' => 'preferred_start_date_label', 'label' => 'Label tanggal mulai'],
                ['key' => 'budget_range_label', 'label' => 'Label budget'],
                ['key' => 'budget_range_placeholder', 'label' => 'Pilihan kosong budget'],
                ['key' => 'budget_range_options', 'label' => 'Pilihan budget', 'type' => 'options'],
            ]],
            ['title' => 'Section tambahan, persetujuan & tombol', 'description' => 'Judul pertanyaan dinamis, priority slot, consent, tombol, dan catatan akhir.', 'fields' => [
                ['key' => 'additional_section_title', 'label' => 'Judul section pertanyaan tambahan'],
                ['key' => 'reservation_label', 'label' => 'Label priority slot'],
                ['key' => 'reservation_help', 'label' => 'Keterangan priority slot', 'type' => 'textarea'],
                ['key' => 'privacy_consent_prefix', 'label' => 'Teks consent sebelum link'],
                ['key' => 'privacy_link_label', 'label' => 'Label link privasi'],
                ['key' => 'privacy_consent_suffix', 'label' => 'Teks consent setelah link', 'type' => 'textarea'],
                ['key' => 'submit_label', 'label' => 'Teks tombol kirim'],
                ['key' => 'footer_note', 'label' => 'Catatan di bawah tombol', 'type' => 'textarea'],
            ]],
        ];
    }
}
