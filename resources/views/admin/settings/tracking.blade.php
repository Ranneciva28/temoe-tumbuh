@extends('layouts.admin')
@section('title','Tracking')
@section('topbar','Marketing Tracking')
@section('content')
<div class="heading"><div><h1>Tracking & Ads</h1><p>Kelola ID tracking tanpa edit source code. FBCLID/GCLID sendiri ditangkap otomatis dari URL pengunjung.</p></div></div>
<form class="card card-pad" method="post" action="{{ route('admin.tracking.update') }}">@csrf @method('PUT')<div class="grid grid-2"><div class="field"><label>Meta Pixel ID</label><input class="input" name="meta_pixel_id" value="{{ $settings['meta_pixel_id'] ?? '' }}" placeholder="123456789..."><div class="help">Digunakan untuk browser-side Meta Pixel.</div></div><div class="field"><label>Meta Conversions API Token</label><input class="input" type="password" name="meta_capi_token" placeholder="Kosongkan untuk mempertahankan token lama"><div class="help">Disimpan sebagai secret setting. Jangan dibagikan ke frontend.</div></div><div class="field"><label>GA4 Measurement ID</label><input class="input" name="ga4_measurement_id" value="{{ $settings['ga4_measurement_id'] ?? '' }}" placeholder="G-XXXXXXXXXX"></div><div class="field"><label>Google Ads Conversion ID</label><input class="input" name="google_ads_conversion_id" value="{{ $settings['google_ads_conversion_id'] ?? '' }}" placeholder="AW-XXXXXXXXX"></div><div class="field"><label>Google Ads Conversion Label</label><input class="input" name="google_ads_conversion_label" value="{{ $settings['google_ads_conversion_label'] ?? '' }}" placeholder="AbCdEfGh..."></div></div><div style="margin-top:20px" class="actions"><button class="btn btn-primary">Simpan Tracking</button></div></form>
<div class="grid grid-3" style="margin-top:18px"><div class="card card-pad"><strong>Meta Ads</strong><p class="help">Pixel ID memicu event browser. `fbclid` disimpan ke setiap lead bila tersedia.</p></div><div class="card card-pad"><strong>Google Ads</strong><p class="help">Conversion ID/Label dipakai pada thank-you event. `gclid` ikut tersimpan ke lead.</p></div><div class="card card-pad"><strong>Attribution</strong><p class="help">UTM source, medium, campaign, content, term, referrer, dan landing page ikut disimpan.</p></div></div>
<div class="card" style="margin-top:18px">
    <div class="card-pad"><h3 class="section-title">Event yang aktif di website</h3><p class="help">Setiap action memiliki nama sendiri supaya performa CTA dan minat pengunjung bisa dibandingkan di Meta Events Manager dan GA4.</p></div>
    <div class="table-wrap"><table class="table"><thead><tr><th>Action</th><th>Meta event</th><th>GA4 event</th><th>Event name / label</th></tr></thead><tbody>
        <tr><td>Klik menu sticky</td><td><span class="badge">ViewContent</span></td><td>navigation_click</td><td>program, experience, pricing, parents, faq</td></tr>
        <tr><td>Klik CTA daftar minat</td><td><span class="badge badge-high_intent">Contact</span></td><td>begin_signup</td><td>sticky_nav_interest, hero_priority_slot, pricing_interest, family_fit_interest, final_interest</td></tr>
        <tr><td>Buka pertanyaan FAQ</td><td><span class="badge">ViewContent</span></td><td>faq_open</td><td>location, age, schedule, price, commitment</td></tr>
        <tr><td>Kirim formulir</td><td><span class="badge badge-qualified">SubmitApplication</span></td><td>form_submit</td><td>interest_form_submit</td></tr>
        <tr><td>Form berhasil tersimpan</td><td><span class="badge badge-reserved">Lead</span></td><td>generate_lead + Google Ads conversion</td><td>interest_form</td></tr>
    </tbody></table></div>
</div>
@endsection
