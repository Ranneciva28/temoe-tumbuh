@extends('layouts.admin')
@section('title','Tracking')
@section('topbar','Marketing Tracking')
@section('content')
@php($test = session('tracking_test_result'))
<div class="heading">
    <div><h1>Tracking, Pixels & Test Events</h1><p>Kelola ID/API, kirim dummy event, dan lihat tepatnya data apa yang diteruskan ke setiap platform.</p></div>
</div>

@if($test)
    <div class="{{ $test['success'] ? 'flash' : 'error' }}" style="margin-bottom:18px">
        <strong>{{ $test['platform'] }} · {{ $test['success'] ? 'Test terkirim' : 'Test gagal' }}</strong>
        <div style="margin-top:5px">{{ $test['message'] }}</div>
        @if(!empty($test['event_id']))<div class="help" style="margin-top:6px">Event ID: <code>{{ $test['event_id'] }}</code>@if(isset($test['http_status'])) · HTTP {{ $test['http_status'] }}@endif</div>@endif
    </div>
    @if(!empty($test['payload']) || !empty($test['response']))
        <div class="grid grid-2" style="margin-bottom:18px;align-items:start">
            <div class="card card-pad"><h3 class="section-title">Payload dummy yang dikirim</h3><pre style="margin:0;white-space:pre-wrap;word-break:break-word;font-size:12px;line-height:1.55;background:#f6f4ee;padding:14px;border-radius:11px;max-height:430px;overflow:auto">{{ json_encode($test['payload'], JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) }}</pre></div>
            <div class="card card-pad"><h3 class="section-title">Respons platform</h3><pre style="margin:0;white-space:pre-wrap;word-break:break-word;font-size:12px;line-height:1.55;background:#f6f4ee;padding:14px;border-radius:11px;max-height:430px;overflow:auto">{{ json_encode($test['response'], JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) }}</pre></div>
        </div>
    @endif
@endif

<form class="card card-pad" method="post" action="{{ route('admin.tracking.update') }}">
    @csrf @method('PUT')
    <div class="grid grid-3" style="align-items:start">
        <section style="border:1px solid var(--line);border-radius:15px;padding:18px">
            <h3 class="section-title">Meta</h3>
            <div class="stack">
                <div class="field"><label>Meta Pixel ID</label><input class="input" name="meta_pixel_id" value="{{ $settings['meta_pixel_id'] ?? '' }}" placeholder="123456789..."><div class="help">Mengaktifkan Meta Pixel di browser.</div></div>
                <div class="field"><label>Conversions API Token</label><input class="input" type="password" name="meta_capi_token" placeholder="Kosongkan untuk mempertahankan token lama"><div class="help">Secret. Dipakai server untuk CAPI.</div></div>
                <div class="field"><label>Test Event Code</label><input class="input" name="meta_test_event_code" value="{{ $settings['meta_test_event_code'] ?? '' }}" placeholder="TEST12345"><div class="help">Ambil dari Events Manager → Test Events. Wajib agar dummy tidak masuk data produksi.</div></div>
            </div>
        </section>
        <section style="border:1px solid var(--line);border-radius:15px;padding:18px">
            <h3 class="section-title">TikTok</h3>
            <div class="stack">
                <div class="field"><label>TikTok Pixel ID</label><input class="input" name="tiktok_pixel_id" value="{{ $settings['tiktok_pixel_id'] ?? '' }}" placeholder="CXXXXXXXXXXXX"><div class="help">Mengaktifkan TikTok Pixel di browser.</div></div>
                <div class="field"><label>Events API Access Token</label><input class="input" type="password" name="tiktok_events_api_token" placeholder="Kosongkan untuk mempertahankan token lama"><div class="help">Secret. Generate dari TikTok Events Manager.</div></div>
                <div class="field"><label>Test Event Code</label><input class="input" name="tiktok_test_event_code" value="{{ $settings['tiktok_test_event_code'] ?? '' }}" placeholder="TEST..."><div class="help">Ambil dari tab Test Events. Wajib untuk dummy server event.</div></div>
            </div>
        </section>
        <section style="border:1px solid var(--line);border-radius:15px;padding:18px">
            <h3 class="section-title">Google</h3>
            <div class="stack">
                <div class="field"><label>GA4 Measurement ID</label><input class="input" name="ga4_measurement_id" value="{{ $settings['ga4_measurement_id'] ?? '' }}" placeholder="G-XXXXXXXXXX"></div>
                <div class="field"><label>Google Ads Conversion ID</label><input class="input" name="google_ads_conversion_id" value="{{ $settings['google_ads_conversion_id'] ?? '' }}" placeholder="AW-XXXXXXXXX"></div>
                <div class="field"><label>Google Ads Conversion Label</label><input class="input" name="google_ads_conversion_label" value="{{ $settings['google_ads_conversion_label'] ?? '' }}" placeholder="AbCdEfGh..."></div>
                <div class="help">Google test dikirim oleh Google Tag sebagai conversion Rp0 dengan transaction ID khusus test.</div>
            </div>
        </section>
    </div>
    <div class="actions" style="margin-top:20px"><button class="btn btn-primary">Simpan Semua Konfigurasi</button></div>
</form>

<div class="grid grid-3" style="margin-top:18px;align-items:stretch">
    @foreach([
        ['key'=>'meta','name'=>'Meta','ready'=>filled($settings['meta_pixel_id'] ?? null) && filled($settings['meta_capi_token'] ?? null) && filled($settings['meta_test_event_code'] ?? null),'event'=>'Lead','note'=>'Dikirim via Conversions API menggunakan Test Event Code.'],
        ['key'=>'tiktok','name'=>'TikTok','ready'=>filled($settings['tiktok_pixel_id'] ?? null) && filled($settings['tiktok_events_api_token'] ?? null) && filled($settings['tiktok_test_event_code'] ?? null),'event'=>'SubmitForm','note'=>'Dikirim via Events API menggunakan Test Event Code.'],
        ['key'=>'google','name'=>'Google Ads','ready'=>filled($settings['google_ads_conversion_id'] ?? null) && filled($settings['google_ads_conversion_label'] ?? null),'event'=>'conversion','note'=>'Dikirim via Google Tag dengan value Rp0; dapat muncul pada laporan conversion.'],
    ] as $platform)
        <div class="card card-pad" style="display:flex;flex-direction:column">
            <div class="actions" style="justify-content:space-between"><strong>{{ $platform['name'] }}</strong><span class="badge {{ $platform['ready'] ? 'badge-qualified' : '' }}">{{ $platform['ready'] ? 'Siap dites' : 'Belum lengkap' }}</span></div>
            <div style="font-size:22px;font-weight:800;margin-top:17px">{{ $platform['event'] }}</div>
            <p class="help" style="min-height:38px">{{ $platform['note'] }}</p>
            <form method="post" action="{{ route('admin.tracking.test', $platform['key']) }}" style="margin-top:auto">@csrf<button class="btn {{ $platform['ready'] ? 'btn-primary' : 'btn-outline' }}" style="width:100%" @disabled(!$platform['ready'])>Kirim Dummy {{ $platform['name'] }}</button></form>
        </div>
    @endforeach
</div>

<div class="card" style="margin-top:18px">
    <div class="card-pad"><h3 class="section-title">Data yang seharusnya terkirim</h3><p class="help">Secret token tidak pernah dikirim ke browser dan tidak ditampilkan pada hasil test. Email, telepon, dan external ID untuk server event dikirim dalam bentuk hash SHA-256.</p></div>
    <div class="table-wrap"><table class="table"><thead><tr><th>Platform</th><th>Identitas & atribusi</th><th>Data event</th><th>Data halaman/perangkat</th></tr></thead><tbody>
        <tr><td><strong>Meta</strong></td><td>Email, telepon, external ID ter-hash; <code>_fbp</code>, <code>_fbc/fbclid</code> bila tersedia</td><td>event name/time/ID, source, content name/category, city, lead status, reservation interest</td><td>source URL, IP, browser user-agent</td></tr>
        <tr><td><strong>TikTok</strong></td><td>Email, telepon, external ID ter-hash; <code>ttclid</code> dan <code>_ttp</code> bila tersedia</td><td>event name/time/ID, content ID/name/type, currency, value</td><td>page URL, referrer, IP, browser user-agent</td></tr>
        <tr><td><strong>Google Ads / GA4</strong></td><td><code>gclid</code> dan client/cookie identifier yang dikelola Google Tag</td><td>event name, <code>send_to</code>, conversion label, value, currency, transaction ID, event label</td><td>page URL, referrer, browser/device signals yang dikelola Google Tag</td></tr>
    </tbody></table></div>
</div>

<div class="card" style="margin-top:18px">
    <div class="card-pad"><h3 class="section-title">Event website aktif</h3><p class="help">Meta dan TikTok menerima standard event; GA4 menerima nama event yang sesuai action.</p></div>
    <div class="table-wrap"><table class="table"><thead><tr><th>Action</th><th>Meta / TikTok</th><th>GA4</th><th>Event label</th></tr></thead><tbody>
        <tr><td>Page load</td><td>PageView</td><td>page_view</td><td>Halaman yang dibuka</td></tr>
        <tr><td>Klik menu sticky / buka FAQ</td><td>ViewContent</td><td>navigation_click / faq_open</td><td>program, experience, pricing, parents, FAQ topic</td></tr>
        <tr><td>Klik CTA daftar minat</td><td>Contact</td><td>begin_signup</td><td>Posisi CTA yang diklik</td></tr>
        <tr><td>Kirim formulir</td><td>SubmitApplication</td><td>form_submit</td><td>interest_form_submit</td></tr>
        <tr><td>Lead berhasil tersimpan</td><td>Meta: Lead via browser + CAPI</td><td>generate_lead + Google Ads conversion</td><td>interest_form</td></tr>
    </tbody></table></div>
</div>

@if($test && !empty($test['browser_dispatch']) && $test['success'])
    @php
        $googleTestPayload = [
            'send_to' => $test['payload']['send_to'],
            'currency' => 'IDR',
            'value' => 0,
            'transaction_id' => $test['event_id'],
            'event_category' => 'integration_test',
            'event_label' => 'temoe_dummy_conversion',
        ];
    @endphp
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ urlencode($settings['google_ads_conversion_id']) }}"></script>
    <script>
        window.dataLayer=window.dataLayer||[];
        function gtag(){dataLayer.push(arguments);}
        gtag('js',new Date());
        gtag('config',@json($settings['google_ads_conversion_id']));
        gtag('event','conversion',@json($googleTestPayload));
    </script>
@endif
@endsection
