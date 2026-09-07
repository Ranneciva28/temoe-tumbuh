@extends('layouts.admin')
@section('title','Homepage CMS')
@section('topbar','Homepage CMS')
@section('content')
@php
$slots = [
    'hero' => ['label' => 'Foto Utama / Hero', 'ratio' => 'Potret 4:5', 'tip' => 'Pilih foto anak sedang bermain dengan ruang kosong di sisi kiri atau tengah.'],
    'daily_rhythm' => ['label' => 'Aktivitas Harian', 'ratio' => 'Potret 4:5', 'tip' => 'Gunakan momen aktivitas, eksplorasi, atau bermain bersama.'],
    'space_play' => ['label' => 'Ruang Bermain', 'ratio' => 'Landscape 4:3', 'tip' => 'Tampilkan area utama yang terang, rapi, dan terasa luas.'],
    'space_rest' => ['label' => 'Sudut Tenang', 'ratio' => 'Landscape 4:3', 'tip' => 'Tampilkan area tidur, membaca, atau sudut untuk menenangkan diri.'],
    'parent_updates' => ['label' => 'Update untuk Moms', 'ratio' => 'Landscape 4:3', 'tip' => 'Foto aktivitas dekat atau hasil karya anak cocok untuk mockup update harian.'],
    'pricing' => ['label' => 'Penawaran & Harga', 'ratio' => 'Tanpa foto', 'tip' => 'Edit judul, deskripsi, isi kartu harga, dan CTA. Angka mulai Rp1,6 juta tetap ditampilkan sebagai anchor harga.'],
    'facilities' => ['label' => 'Highlight Fasilitas', 'ratio' => 'Tanpa foto', 'tip' => 'Isi satu fasilitas per baris dengan format: Nama fasilitas | Penjelasan singkat.'],
];
@endphp

<div class="heading">
    <div><h1>Homepage</h1><p>Atur copy, lima slot foto, penawaran harga, dan highlight fasilitas tanpa menyentuh source code.</p></div>
    <a class="btn btn-outline" target="_blank" href="{{ route('home') }}">Preview Website ↗</a>
</div>

<div class="card card-pad" style="margin-bottom:18px;background:#edf3e9">
    <strong>Alur upload foto</strong>
    <div class="help" style="margin-top:6px">Buka section sesuai nama slot, pilih file pada “Upload gambar baru”, lalu Simpan. Foto langsung menggantikan placeholder di homepage.</div>
</div>

<div class="grid grid-2" style="align-items:start">
    <div class="stack">
        @forelse($sections as $section)
            @php($slot = $slots[$section->section_key] ?? ['label' => $section->title ?: 'Section Tambahan', 'ratio' => 'Landscape', 'tip' => 'Gunakan foto yang paling sesuai dengan isi section.'])
            <form class="card card-pad" method="post" enctype="multipart/form-data" action="{{ route('admin.cms.update',$section) }}">
                @csrf
                @method('PUT')

                <div class="actions" style="justify-content:space-between;align-items:flex-start">
                    <div><strong style="font-size:16px">{{ $slot['label'] }}</strong><div class="help" style="margin-top:4px">{{ $slot['ratio'] }} · Urutan {{ $section->sort_order }} · <code>{{ $section->section_key }}</code></div></div>
                    <label class="help"><input type="checkbox" name="is_active" value="1" @checked($section->is_active)> Aktif</label>
                </div>

                @unless(in_array($section->section_key, ['pricing','facilities'], true))
                <div style="margin-top:14px;border-radius:14px;overflow:hidden;height:240px;background:linear-gradient(135deg,#dfeadf,#f1e2c4);display:grid;place-items:center">
                    @if($section->image_path)
                        <img src="{{ str_starts_with($section->image_path,'http') ? $section->image_path : asset(ltrim($section->image_path,'/')) }}" alt="" style="width:100%;height:240px;object-fit:cover">
                    @else
                        <div style="text-align:center;color:#60736b"><div style="font-size:34px">📷</div><strong>Belum ada foto</strong><div class="help" style="margin-top:5px">{{ $slot['tip'] }}</div></div>
                    @endif
                </div>
                @endunless

                <div class="grid grid-2" style="margin-top:16px">
                    <div class="field"><label>Judul</label><input class="input" name="title" value="{{ $section->title }}"></div>
                    <div class="field"><label>Subjudul</label><input class="input" name="subtitle" value="{{ $section->subtitle }}"></div>
                </div>
                <div class="field" style="margin-top:12px"><label>{{ $section->section_key === 'facilities' ? 'Daftar fasilitas' : ($section->section_key === 'pricing' ? 'Harga & highlight paket' : 'Konten tambahan') }}</label><textarea class="textarea" name="content">{{ $section->content }}</textarea>@if($section->section_key === 'facilities')<div class="help">Satu baris per fasilitas. Format: <code>Nama fasilitas | Penjelasan singkat</code></div>@elseif($section->section_key === 'pricing')<div class="help">Format: <code>Rp1,6 juta | Kalimat highlight paket</code>. Harga di sebelah kiri tanda | dapat Kamu ubah kapan saja.</div>@endif</div>
                <div class="grid grid-2" style="margin-top:12px">
                    @unless(in_array($section->section_key, ['pricing','facilities'], true))
                        <div class="field"><label>Upload gambar baru</label><input class="input" type="file" name="image" accept="image/*"><div class="help">JPG, PNG, atau WebP. Maksimal 8 MB.</div></div>
                        <div class="field"><label>Atau Image path / URL</label><input class="input" name="image_path" value="{{ $section->image_path }}" placeholder="/storage/... atau https://..."></div>
                    @endunless
                    <div class="field"><label>CTA Label</label><input class="input" name="cta_label" value="{{ $section->cta_label }}"></div>
                    <div class="field"><label>CTA URL</label><input class="input" name="cta_url" value="{{ $section->cta_url }}"></div>
                    <div class="field"><label>Urutan</label><input class="input" type="number" name="sort_order" value="{{ $section->sort_order }}"></div>
                </div>
                <div class="actions" style="margin-top:15px"><button class="btn btn-primary">Simpan Perubahan</button></div>
            </form>

            @unless(array_key_exists($section->section_key, $slots))
                <form method="post" action="{{ route('admin.cms.destroy',$section) }}" onsubmit="return confirm('Hapus section ini?')">@csrf @method('DELETE')<button class="btn btn-danger">Hapus {{ $section->section_key }}</button></form>
            @endunless
        @empty
            <div class="card empty">Belum ada section. Jalankan deployment terbaru untuk memasang konten awal.</div>
        @endforelse
    </div>

    <form class="card card-pad" method="post" enctype="multipart/form-data" action="{{ route('admin.cms.store') }}">
        @csrf
        <h3 class="section-title">Tambah Section Bebas</h3>
        <div class="help" style="margin-bottom:15px">Dipakai bila nanti Kamu ingin menambah promo, pengumuman, atau konten khusus di bawah homepage.</div>
        <div class="stack">
            <div class="field"><label>Section Key</label><input class="input" name="section_key" required placeholder="contoh: promo_opening"><div class="help">Gunakan huruf kecil tanpa spasi.</div></div>
            <div class="field"><label>Judul</label><input class="input" name="title"></div>
            <div class="field"><label>Subjudul</label><input class="input" name="subtitle"></div>
            <div class="field"><label>Konten</label><textarea class="textarea" name="content"></textarea></div>
            <div class="field"><label>Upload gambar</label><input class="input" type="file" name="image" accept="image/*"></div>
            <div class="field"><label>Atau Image path / URL</label><input class="input" name="image_path"></div>
            <div class="grid grid-2"><div class="field"><label>CTA Label</label><input class="input" name="cta_label"></div><div class="field"><label>CTA URL</label><input class="input" name="cta_url"></div></div>
            <div class="field"><label>Urutan</label><input class="input" type="number" name="sort_order" value="100"></div>
            <label class="help"><input type="checkbox" name="is_active" value="1" checked> Tampilkan section</label>
            <button class="btn btn-primary">Tambah Section</button>
        </div>
    </form>
</div>
@endsection
