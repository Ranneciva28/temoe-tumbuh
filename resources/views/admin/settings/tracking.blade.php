@extends('layouts.admin')
@section('title','Tracking')
@section('topbar','Marketing Tracking')
@section('content')
@php
    $test = session('tracking_test_result');
@endphp
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

<div class="card card-pad" style="margin-top:18px;background:#edf3e9">
    <div class="actions" style="justify-content:space-between;align-items:flex-start">
        <div><h2 style="margin:0 0 7px;font-size:21px">Meta Event Mapper</h2><p class="help" style="margin:0;max-width:760px">Pilih event Meta, kapan event dipicu, dan tombol atau halaman yang menjadi target. Hanya mapping berstatus aktif yang dikirim ke Meta Pixel.</p></div>
        <span class="badge {{ filled($settings['meta_pixel_id'] ?? null) ? 'badge-qualified' : '' }}">{{ filled($settings['meta_pixel_id'] ?? null) ? 'Pixel siap' : 'Pixel ID belum diisi' }}</span>
    </div>
</div>

<div class="grid grid-2" style="margin-top:18px;align-items:start">
    <form class="card card-pad meta-mapping-form" method="post" action="{{ route('admin.tracking.meta-mappings.store') }}">
        @csrf
        <h3 class="section-title">Tempel Event ke Target</h3>
        <div class="stack">
            <div class="field"><label>Event Meta</label><select class="select" name="event_name" required>@foreach($metaEvents as $name=>$description)<option value="{{ $name }}" @selected(old('event_name')===$name)>{{ $name }} — {{ $description }}</option>@endforeach</select></div>
            <div class="field"><label>Jenis pemicu</label><select class="select meta-trigger" name="trigger_type" required>@foreach($metaTriggers as $key=>$label)<option value="{{ $key }}" @selected(old('trigger_type')===$key)>{{ $label }}</option>@endforeach</select></div>
            <div class="field"><label>Halaman, tombol, atau aksi</label><select class="select meta-target" name="target_key" required>@foreach($metaTargets as $target)<option value="{{ $target['key'] }}" data-trigger="{{ $target['trigger'] }}" @selected(old('target_key')===$target['key'])>{{ $target['label'] }}</option>@endforeach</select></div>
            <label class="help"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', true))> Langsung aktif</label>
            <button class="btn btn-primary">Tambahkan Mapping</button>
        </div>
    </form>

    <div class="card card-pad">
        <h3 class="section-title">Standard Event Meta yang Tersedia</h3>
        <p class="help" style="margin-top:-7px">Gunakan event yang paling dekat dengan aksi pengunjung agar optimasi campaign tetap terbaca jelas.</p>
        <p class="help"><strong>Saran untuk Temoe:</strong> PageView untuk halaman, ViewContent untuk konten/FAQ, Contact untuk tombol daftar minat, SubmitApplication saat form dikirim, dan Lead setelah data berhasil tersimpan.</p>
        <div class="grid grid-2" style="margin-top:16px">
            @foreach($metaEvents as $name=>$description)
                <div style="border:1px solid var(--line);border-radius:11px;padding:11px"><strong style="font-size:13px">{{ $name }}</strong><div class="help" style="margin-top:4px">{{ $description }}</div></div>
            @endforeach
        </div>
    </div>
</div>

<div class="heading" style="margin-top:26px;margin-bottom:15px"><div><h2 style="margin:0;font-size:20px">Mapping Aktif & Tersimpan</h2><p>Mapping dapat diubah, dimatikan sementara, atau dihapus tanpa menyentuh kode website.</p></div></div>
<div class="stack">
    @forelse($metaMappings as $mapping)
        <div class="card card-pad">
            <form class="meta-mapping-form" method="post" action="{{ route('admin.tracking.meta-mappings.update', $mapping) }}">
                @csrf @method('PUT')
                <div class="actions" style="justify-content:space-between;margin-bottom:14px"><div><strong>{{ $mapping->event_name }}</strong><div class="help">{{ $metaTargetLabels[$mapping->target_key] ?? $mapping->target_key }}</div></div><label class="help"><input type="checkbox" name="is_active" value="1" @checked($mapping->is_active)> Aktif</label></div>
                <div class="grid grid-3">
                    <div class="field"><label>Event Meta</label><select class="select" name="event_name" required>@foreach($metaEvents as $name=>$description)<option value="{{ $name }}" @selected($mapping->event_name===$name)>{{ $name }}</option>@endforeach</select></div>
                    <div class="field"><label>Pemicu</label><select class="select meta-trigger" name="trigger_type" required>@foreach($metaTriggers as $key=>$label)<option value="{{ $key }}" @selected($mapping->trigger_type===$key)>{{ $label }}</option>@endforeach</select></div>
                    <div class="field"><label>Target</label><select class="select meta-target" name="target_key" required>@foreach($metaTargets as $target)<option value="{{ $target['key'] }}" data-trigger="{{ $target['trigger'] }}" @selected($mapping->target_key===$target['key'])>{{ $target['label'] }}</option>@endforeach</select></div>
                </div>
                <button class="btn btn-primary" style="margin-top:14px">Simpan Mapping</button>
            </form>
            <form method="post" action="{{ route('admin.tracking.meta-mappings.destroy', $mapping) }}" style="margin-top:9px" onsubmit="return confirm('Hapus mapping ini? Event tidak akan dikirim lagi dari target tersebut.')">@csrf @method('DELETE')<button class="btn btn-danger">Hapus Mapping</button></form>
        </div>
    @empty
        <div class="card empty">Belum ada mapping. Meta Pixel tidak akan mengirim event website sampai mapping dibuat.</div>
    @endforelse
</div>

<div class="card" style="margin-top:26px">
    <div class="card-pad"><h3 class="section-title">100 Event Meta Terakhir</h3><p class="help">Browser berarti Pixel sudah dipanggil dari perangkat pengunjung. Server berarti Conversions API sudah mendapat respons dari Meta.</p></div>
    <div class="table-wrap"><table class="table"><thead><tr><th>Waktu</th><th>Event</th><th>Target</th><th>Channel</th><th>Status</th><th>Event ID</th></tr></thead><tbody>
        @forelse($metaLogs as $log)
            <tr><td>{{ $log->created_at->format('d M Y H:i:s') }}</td><td><strong>{{ $log->event_name }}</strong><div class="help">{{ $metaTriggers[$log->trigger_type] ?? $log->trigger_type }}</div></td><td>{{ $metaTargetLabels[$log->target_key] ?? $log->target_key }}</td><td><span class="badge">{{ $log->channel === 'server' ? 'CAPI / Server' : 'Pixel / Browser' }}</span></td><td><span class="badge {{ in_array($log->status, ['accepted','dispatched'], true) ? 'badge-qualified' : 'badge-lost' }}">{{ $log->status }}</span></td><td><code style="font-size:11px;word-break:break-all">{{ $log->event_id }}</code></td></tr>
        @empty
            <tr><td colspan="6" class="empty">Belum ada event yang didispatch dari mapping aktif.</td></tr>
        @endforelse
    </tbody></table></div>
</div>

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
@push('scripts')
<script>
document.querySelectorAll('.meta-mapping-form').forEach(function(form){
    var trigger=form.querySelector('.meta-trigger');
    var target=form.querySelector('.meta-target');
    if(!trigger||!target)return;
    function filterTargets(){
        var firstVisible=null;
        var selectedVisible=false;
        Array.from(target.options).forEach(function(option){
            var visible=option.dataset.trigger===trigger.value;
            option.hidden=!visible;
            option.disabled=!visible;
            if(visible&&!firstVisible)firstVisible=option;
            if(visible&&option.selected)selectedVisible=true;
        });
        if(!selectedVisible&&firstVisible)firstVisible.selected=true;
    }
    trigger.addEventListener('change',filterTargets);
    filterTargets();
});
</script>
@endpush
@endsection
