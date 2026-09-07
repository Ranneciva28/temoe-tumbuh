<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="Daftar minat Temoe Tumbuh untuk bayi, toddler, dan pre-school di Cilegon dan Serang.">
    <title>Daftar Minat — Temoe Tumbuh</title>
    @include('partials.branding-head')
    <style>
        :root{--ink:#17372d;--muted:#60736b;--green:#245845;--cream:#fffaf0;--line:#e5dfd3;--lime:#dcec88}
        *{box-sizing:border-box}body{margin:0;font-family:Inter,ui-sans-serif,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;background:linear-gradient(145deg,#f2f7dc,#fff8eb 48%,#f9e6de);color:var(--ink)}a{text-decoration:none;color:inherit}.wrap{max-width:900px;margin:auto;padding:27px 22px 70px}.nav{display:flex;align-items:center;justify-content:space-between;margin-bottom:52px}.brand{font-weight:850;font-size:21px;display:flex;align-items:center;gap:9px}.brand-mark{width:36px;height:36px;border-radius:12px;background:var(--lime);display:grid;place-items:center}.back{font-size:13px;color:var(--muted);font-weight:700}.intro{max-width:720px;margin-bottom:29px}.eyebrow{font-size:11px;font-weight:900;letter-spacing:1px;color:#547564}.intro h1{font-family:Georgia,serif;font-size:clamp(40px,6vw,57px);line-height:1.01;letter-spacing:-2px;margin:12px 0 16px}.intro p{font-size:17px;line-height:1.72;color:var(--muted)}.price-note{display:inline-flex;background:#fff;border:1px solid var(--line);border-radius:999px;padding:9px 13px;font-size:13px;font-weight:800;box-shadow:0 8px 22px rgba(36,88,69,.08)}.card{background:#fff;border:1px solid var(--line);border-radius:25px;padding:33px;box-shadow:0 20px 55px rgba(49,59,53,.08)}.section{padding:7px 0 21px;margin-bottom:19px;border-bottom:1px solid #eeeae2}.section:last-of-type{border:0}.section h2{font-size:18px;margin:0 0 17px}.grid{display:grid;grid-template-columns:1fr 1fr;gap:15px}.field{display:grid;gap:7px;margin-bottom:14px}.field label{font-size:13px;font-weight:750}.input,.select,.textarea{width:100%;font:inherit;padding:12px 13px;border:1px solid #d9d4c9;border-radius:11px;background:#fff;outline:0}.textarea{min-height:110px}.input:focus,.select:focus,.textarea:focus{border-color:#759989;box-shadow:0 0 0 3px rgba(65,104,85,.09)}.help{font-size:12px;color:var(--muted);line-height:1.5}.choice{display:flex;gap:9px;align-items:flex-start;padding:11px 12px;border:1px solid #e5e0d6;border-radius:11px;margin-bottom:8px}.choice input{margin-top:3px}.choice a{text-decoration:underline;color:#365d4c}.submit{width:100%;border:0;background:var(--green);color:#fff;padding:16px;border-radius:13px;font-size:15px;font-weight:850;cursor:pointer;box-shadow:0 12px 25px rgba(36,88,69,.2)}.privacy{text-align:center;color:var(--muted);font-size:11px;line-height:1.6;margin-top:12px}.error{background:#f4dfdc;color:#863f39;border-radius:12px;padding:12px 14px;margin-bottom:18px;font-size:13px}.error ul{margin:6px 0 0;padding-left:19px}@media(max-width:650px){.grid{grid-template-columns:1fr}.card{padding:24px 18px}.nav{margin-bottom:36px}.back{font-size:12px}}
    </style>
    @include('partials.tracking')
</head>
<body>
<div class="wrap">
    <nav class="nav"><a class="brand" href="{{ route('home') }}" data-meta-event="ViewContent" data-ga-event="navigation_click" data-event-name="interest_back_home"><span class="brand-mark">🌱</span> Temoe Tumbuh</a><a class="back" href="{{ route('home') }}" data-meta-event="ViewContent" data-ga-event="navigation_click" data-event-name="interest_back_home">← Kembali ke homepage</a></nav>
    <div class="intro"><div class="eyebrow">FOUNDING FAMILIES · CILEGON & SERANG</div><h1>Moms, ceritakan kebutuhan si kecil.</h1><p>Isi data singkat ini untuk mendapat informasi paket dan priority slot Temoe Tumbuh. Program tersedia mulai dari bayi, toddler, hingga pre-school.</p><span class="price-note">Paket mulai dari Rp1,6 juta / bulan</span></div>
    <div class="card">
        @if($errors->any())<div class="error"><strong>Ada beberapa data yang perlu dicek.</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <form method="post" action="{{ route('interest.store') }}" data-track-form data-meta-event="SubmitApplication" data-ga-event="form_submit" data-event-name="interest_form_submit">
            @csrf
            <div class="section"><h2>1. Tentang Moms</h2><div class="grid"><div class="field"><label>Nama Moms / orang tua *</label><input class="input" name="parent_name" value="{{ old('parent_name') }}" required></div><div class="field"><label>Nomor WhatsApp *</label><input class="input" type="tel" name="whatsapp" value="{{ old('whatsapp') }}" required placeholder="08xxxxxxxxxx"></div></div><div class="field"><label>Email</label><input class="input" type="email" name="email" value="{{ old('email') }}"></div></div>
            <div class="section"><h2>2. Tentang si kecil & lokasi</h2><div class="grid"><div class="field"><label>Nama anak</label><input class="input" name="child_name" value="{{ old('child_name') }}"></div><div class="field"><label>Usia anak (tahun)</label><input class="input" type="number" min="0" max="12" name="child_age" value="{{ old('child_age') }}" placeholder="Isi 0 untuk usia di bawah 1 tahun"></div><div class="field"><label>Kota</label><select class="select" name="city"><option value="">Pilih kota</option>@foreach(['Cilegon','Serang','Lainnya'] as $city)<option value="{{ $city }}" @selected(old('city')===$city)>{{ $city }}</option>@endforeach</select></div><div class="field"><label>Kecamatan / area tinggal</label><input class="input" name="district" value="{{ old('district') }}"></div></div><div class="field"><label>Area daycare yang paling nyaman</label><input class="input" name="preferred_location" value="{{ old('preferred_location') }}" placeholder="Contoh: Cilegon Kota, Cibeber, dekat kantor..."></div></div>
            <div class="section"><h2>3. Kebutuhan daycare</h2><div class="grid"><div class="field"><label>Kebutuhan jadwal</label><select class="select" name="preferred_schedule"><option value="">Pilih</option>@foreach(['Senin–Jumat full day','Beberapa hari per minggu','Half day','Fleksibel / insidental'] as $schedule)<option value="{{ $schedule }}" @selected(old('preferred_schedule')===$schedule)>{{ $schedule }}</option>@endforeach</select></div><div class="field"><label>Kapan ingin mulai?</label><input class="input" type="date" name="preferred_start_date" value="{{ old('preferred_start_date') }}"></div></div><div class="field"><label>Budget daycare per bulan</label><select class="select" name="budget_range"><option value="">Pilih range</option>@foreach(['< Rp1,5 juta','Rp1,5–2 juta','Rp2–2,5 juta','Rp2,5–3 juta','> Rp3 juta'] as $budget)<option value="{{ $budget }}" @selected(old('budget_range')===$budget)>{{ $budget }}</option>@endforeach</select></div></div>
            @if($fields->isNotEmpty())
                <div class="section"><h2>4. Sedikit lagi, Moms</h2>
                @foreach($fields as $field)
                    <div class="field"><label>{{ $field->label }} @if($field->is_required) * @endif</label>
                    @if($field->type === 'textarea')
                        <textarea class="textarea" name="custom[{{ $field->field_key }}]" @required($field->is_required) placeholder="{{ $field->placeholder }}">{{ old('custom.'.$field->field_key) }}</textarea>
                    @elseif(in_array($field->type, ['select', 'radio'], true))
                        @if($field->type === 'select')
                            <select class="select" name="custom[{{ $field->field_key }}]" @required($field->is_required)><option value="">Pilih</option>@foreach($field->options ?? [] as $option)<option value="{{ $option }}" @selected(old('custom.'.$field->field_key) === $option)>{{ $option }}</option>@endforeach</select>
                        @else
                            @foreach($field->options ?? [] as $option)<label class="choice"><input type="radio" name="custom[{{ $field->field_key }}]" value="{{ $option }}" @checked(old('custom.'.$field->field_key) === $option) @required($field->is_required)><span>{{ $option }}</span></label>@endforeach
                        @endif
                    @elseif($field->type === 'checkbox')
                        @foreach($field->options ?? [] as $option)<label class="choice"><input type="checkbox" name="custom[{{ $field->field_key }}][]" value="{{ $option }}" @checked(in_array($option, (array) old('custom.'.$field->field_key, []), true))><span>{{ $option }}</span></label>@endforeach
                    @else
                        <input class="input" type="{{ in_array($field->type, ['email', 'tel', 'number', 'date'], true) ? $field->type : 'text' }}" name="custom[{{ $field->field_key }}]" value="{{ old('custom.'.$field->field_key) }}" @required($field->is_required) placeholder="{{ $field->placeholder }}">
                    @endif
                    @if($field->help_text)<div class="help">{{ $field->help_text }}</div>@endif</div>
                @endforeach
                </div>
            @endif
            <div class="section"><label class="choice"><input type="checkbox" name="reservation_interest" value="1" @checked(old('reservation_interest'))><span><strong>Aku tertarik mendapat priority slot / Founding Families</strong><div class="help">Kami akan menghubungi Moms saat Temoe Tumbuh masuk tahap reservasi awal.</div></span></label><label class="choice"><input type="checkbox" name="privacy_consent" value="1" @checked(old('privacy_consent')) required><span>Aku sudah membaca <a target="_blank" href="{{ route('privacy') }}">Pemberitahuan Privasi</a> dan menyetujui penggunaan data untuk komunikasi Temoe Tumbuh. *</span></label></div>
            @foreach($attribution as $key=>$value)<input type="hidden" name="{{ $key }}" value="{{ $value }}">@endforeach
            <button class="submit" type="submit">Kirim Pendaftaran Minat →</button><div class="privacy">Belum ada kewajiban membeli. Data Kamu hanya digunakan untuk pendaftaran minat dan komunikasi terkait Temoe Tumbuh.</div>
        </form>
    </div>
</div>
</body>
</html>
