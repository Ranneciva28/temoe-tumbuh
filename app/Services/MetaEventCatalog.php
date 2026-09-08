<?php

namespace App\Services;

use App\Models\PageSection;
use Illuminate\Support\Facades\Schema;
use Throwable;

class MetaEventCatalog
{
    public const EVENTS = [
        'PageView' => 'Halaman dibuka',
        'ViewContent' => 'Konten penting dilihat',
        'Search' => 'Pencarian dilakukan',
        'Contact' => 'Pengunjung memulai kontak',
        'Lead' => 'Lead berhasil diperoleh',
        'CompleteRegistration' => 'Pendaftaran selesai',
        'SubmitApplication' => 'Formulir pendaftaran dikirim',
        'Schedule' => 'Jadwal dibuat',
        'FindLocation' => 'Lokasi dicari',
        'InitiateCheckout' => 'Proses checkout dimulai',
        'AddPaymentInfo' => 'Informasi pembayaran ditambahkan',
        'Purchase' => 'Pembelian selesai',
        'Subscribe' => 'Langganan dimulai',
        'StartTrial' => 'Masa percobaan dimulai',
        'AddToCart' => 'Produk dimasukkan ke keranjang',
        'AddToWishlist' => 'Produk disimpan ke wishlist',
        'Donate' => 'Donasi dilakukan',
        'CustomizeProduct' => 'Produk dikustomisasi',
    ];

    public const TRIGGERS = [
        'page_view' => 'Page view',
        'click' => 'Klik / buka elemen',
        'form_submit' => 'Form mulai dikirim',
        'form_success' => 'Form berhasil tersimpan',
    ];

    public function targets(): array
    {
        $targets = [
            ['key' => 'page_home', 'label' => 'Homepage dibuka', 'trigger' => 'page_view'],
            ['key' => 'page_interest', 'label' => 'Halaman Form Minat dibuka', 'trigger' => 'page_view'],
            ['key' => 'page_thank_you', 'label' => 'Halaman Terima Kasih dibuka', 'trigger' => 'page_view'],
            ['key' => 'page_privacy', 'label' => 'Halaman Privasi dibuka', 'trigger' => 'page_view'],
            ['key' => 'home', 'label' => 'Logo / brand homepage', 'trigger' => 'click'],
            ['key' => 'program', 'label' => 'Menu Program', 'trigger' => 'click'],
            ['key' => 'experience', 'label' => 'Menu Pengalaman', 'trigger' => 'click'],
            ['key' => 'pricing', 'label' => 'Menu Harga', 'trigger' => 'click'],
            ['key' => 'parents', 'label' => 'Menu Untuk Moms', 'trigger' => 'click'],
            ['key' => 'faq', 'label' => 'Menu FAQ', 'trigger' => 'click'],
            ['key' => 'sticky_nav_interest', 'label' => 'CTA sticky: Daftar Minat', 'trigger' => 'click'],
            ['key' => 'hero_priority_slot', 'label' => 'CTA hero: Priority Slot', 'trigger' => 'click'],
            ['key' => 'hero_daily_experience', 'label' => 'CTA hero: Lihat keseharian', 'trigger' => 'click'],
            ['key' => 'pricing_interest', 'label' => 'CTA harga: Cek Paket', 'trigger' => 'click'],
            ['key' => 'family_fit_interest', 'label' => 'CTA kecocokan keluarga', 'trigger' => 'click'],
            ['key' => 'location', 'label' => 'FAQ lokasi dibuka', 'trigger' => 'click'],
            ['key' => 'age', 'label' => 'FAQ usia dibuka', 'trigger' => 'click'],
            ['key' => 'schedule', 'label' => 'FAQ jadwal dibuka', 'trigger' => 'click'],
            ['key' => 'price', 'label' => 'FAQ harga dibuka', 'trigger' => 'click'],
            ['key' => 'commitment', 'label' => 'FAQ komitmen dibuka', 'trigger' => 'click'],
            ['key' => 'final_interest', 'label' => 'CTA penutup: Daftar Minat', 'trigger' => 'click'],
            ['key' => 'interest_back_home', 'label' => 'Form Minat: Kembali ke homepage', 'trigger' => 'click'],
            ['key' => 'thank_you_home', 'label' => 'Terima Kasih: Kembali ke homepage', 'trigger' => 'click'],
            ['key' => 'interest_form_submit', 'label' => 'Form Minat mulai dikirim', 'trigger' => 'form_submit'],
            ['key' => 'interest_form_success', 'label' => 'Lead Form Minat berhasil tersimpan', 'trigger' => 'form_success'],
        ];

        try {
            if (Schema::hasTable('page_sections')) {
                $customTargets = PageSection::query()
                    ->where('page', 'home')
                    ->where('is_active', true)
                    ->whereNotNull('cta_label')
                    ->whereNotIn('section_key', ['hero', 'pricing', 'programs', 'facilities', 'experience', 'parents', 'faq'])
                    ->get()
                    ->map(fn ($section) => [
                        'key' => 'custom_'.$section->section_key,
                        'label' => 'CTA section: '.$section->cta_label,
                        'trigger' => 'click',
                    ])
                    ->all();
                $targets = array_merge($targets, $customTargets);
            }
        } catch (Throwable) {
            // The fixed catalog remains available while the database is unavailable.
        }

        return $targets;
    }

    public function target(string $key): ?array
    {
        foreach ($this->targets() as $target) {
            if ($target['key'] === $key) return $target;
        }

        return null;
    }

    public function pageTarget(?string $routeName): ?string
    {
        return match ($routeName) {
            'home' => 'page_home',
            'interest.create' => 'page_interest',
            'interest.thank-you' => 'page_thank_you',
            'privacy' => 'page_privacy',
            default => null,
        };
    }
}
