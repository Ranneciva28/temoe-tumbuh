@extends('layouts.admin')
@section('title','Branding')
@section('topbar','Branding Website')
@section('content')
@php
$assetUrl = function (?string $path): ?string {
    if (!$path) return null;
    return str_starts_with($path, 'http') ? $path : asset(ltrim($path, '/'));
};
@endphp
<div class="heading">
    <div><h1>Logo & Icon</h1><p>Upload identitas visual yang dipakai di homepage, tab browser, dan shortcut perangkat.</p></div>
    <a class="btn btn-outline" target="_blank" href="{{ route('home') }}">Preview Website ↗</a>
</div>
<form class="card card-pad" method="post" enctype="multipart/form-data" action="{{ route('admin.branding.update') }}">
    @csrf @method('PUT')
    <div class="grid grid-3">
        @foreach([
            ['field'=>'logo','key'=>'logo_url','title'=>'Logo Website','hint'=>'PNG/WebP/SVG transparan. Rekomendasi rasio 1:1 atau horizontal.','accept'=>'image/png,image/jpeg,image/webp,image/svg+xml'],
            ['field'=>'favicon','key'=>'favicon_url','title'=>'Favicon Browser','hint'=>'PNG/ICO/SVG persegi. Rekomendasi minimal 512 × 512 px.','accept'=>'image/png,image/webp,image/svg+xml,image/x-icon'],
            ['field'=>'app_icon','key'=>'app_icon_url','title'=>'App / Shortcut Icon','hint'=>'PNG persegi minimal 512 × 512 px untuk icon perangkat.','accept'=>'image/png,image/jpeg,image/webp'],
        ] as $asset)
            <section style="border:1px solid var(--line);border-radius:15px;padding:18px">
                <strong>{{ $asset['title'] }}</strong>
                <div style="height:150px;margin:14px 0;border-radius:13px;background:#f3f0e8;display:grid;place-items:center;overflow:hidden">
                    @if($assetUrl($settings[$asset['key']] ?? null))
                        <img src="{{ $assetUrl($settings[$asset['key']] ?? null) }}" alt="" style="max-width:100%;max-height:150px;object-fit:contain">
                    @else
                        <span style="font-size:42px">🌱</span>
                    @endif
                </div>
                <div class="field"><label>Upload file baru</label><input class="input" type="file" name="{{ $asset['field'] }}" accept="{{ $asset['accept'] }}"><div class="help">{{ $asset['hint'] }}</div></div>
                <div class="field" style="margin-top:12px"><label>Atau URL / path</label><input class="input" name="{{ $asset['key'] }}" value="{{ $settings[$asset['key']] ?? '' }}" placeholder="/storage/... atau https://..."></div>
            </section>
        @endforeach
    </div>
    <div class="actions" style="margin-top:20px"><button class="btn btn-primary">Simpan Branding</button></div>
</form>
@endsection
