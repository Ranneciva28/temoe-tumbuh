<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="{{ $content['seo_description'] }}">
    <title>{{ $content['seo_title'] }}</title>
    @include('partials.branding-head')
    <style>
        :root{--ink:#17372d;--muted:#60736b;--green:#245845;--cream:#fffaf0;--line:#e5dfd3;--lime:#dcec88}
        *{box-sizing:border-box}body{margin:0;font-family:Inter,ui-sans-serif,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;background:linear-gradient(145deg,#f2f7dc,#fff8eb 48%,#f9e6de);color:var(--ink)}a{text-decoration:none;color:inherit}.wrap{max-width:900px;margin:auto;padding:27px 22px 70px}.nav{display:flex;align-items:center;justify-content:space-between;margin-bottom:52px}.brand{font-weight:850;font-size:21px;display:flex;align-items:center;gap:9px}.brand-mark{width:36px;height:36px;border-radius:12px;background:var(--lime);display:grid;place-items:center}.back{font-size:13px;color:var(--muted);font-weight:700}.intro{max-width:720px;margin-bottom:29px}.eyebrow{font-size:11px;font-weight:900;letter-spacing:1px;color:#547564}.intro h1{font-family:Georgia,serif;font-size:clamp(40px,6vw,57px);line-height:1.01;letter-spacing:-2px;margin:12px 0 16px}.intro p{font-size:17px;line-height:1.72;color:var(--muted)}.price-note{display:inline-flex;background:#fff;border:1px solid var(--line);border-radius:999px;padding:9px 13px;font-size:13px;font-weight:800;box-shadow:0 8px 22px rgba(36,88,69,.08)}.card{background:#fff;border:1px solid var(--line);border-radius:25px;padding:33px;box-shadow:0 20px 55px rgba(49,59,53,.08)}.section{padding:7px 0 21px;margin-bottom:19px;border-bottom:1px solid #eeeae2}.section:last-of-type{border:0}.section h2{font-size:18px;margin:0 0 7px}.section-description{font-size:13px;line-height:1.6;color:var(--muted);margin:0 0 17px}.grid{display:grid;grid-template-columns:1fr 1fr;gap:15px}.field{display:grid;gap:7px;margin-bottom:14px}.field-wide{grid-column:1/-1}.field label{font-size:13px;font-weight:750}.input,.select,.textarea{width:100%;font:inherit;padding:12px 13px;border:1px solid #d9d4c9;border-radius:11px;background:#fff;outline:0}.textarea{min-height:110px}.input:focus,.select:focus,.textarea:focus{border-color:#759989;box-shadow:0 0 0 3px rgba(65,104,85,.09)}.help{font-size:12px;color:var(--muted);line-height:1.5}.choice{display:flex;gap:9px;align-items:flex-start;padding:11px 12px;border:1px solid #e5e0d6;border-radius:11px;margin-bottom:8px}.choice input{margin-top:3px}.choice a{text-decoration:underline;color:#365d4c}.submit{width:100%;border:0;background:var(--green);color:#fff;padding:16px;border-radius:13px;font-size:15px;font-weight:850;cursor:pointer;box-shadow:0 12px 25px rgba(36,88,69,.2)}.privacy{text-align:center;color:var(--muted);font-size:11px;line-height:1.6;margin-top:12px}.error{background:#f4dfdc;color:#863f39;border-radius:12px;padding:12px 14px;margin-bottom:18px;font-size:13px}.error ul{margin:6px 0 0;padding-left:19px}@media(max-width:650px){.grid{grid-template-columns:1fr}.field-wide{grid-column:auto}.card{padding:24px 18px}.nav{margin-bottom:36px}.back{font-size:12px}}
    </style>
    @include('partials.tracking')
</head>
<body>
<div class="wrap">
    <nav class="nav"><a class="brand" href="{{ route('home') }}" data-meta-event="ViewContent" data-ga-event="navigation_click" data-event-name="interest_back_home"><span class="brand-mark">🌱</span> {{ $content['brand_label'] }}</a><a class="back" href="{{ route('home') }}" data-meta-event="ViewContent" data-ga-event="navigation_click" data-event-name="interest_back_home">{{ $content['back_label'] }}</a></nav>
    <div class="intro"><div class="eyebrow">{{ $content['intro_eyebrow'] }}</div><h1>{{ $content['intro_title'] }}</h1><p>{{ $content['intro_description'] }}</p>@if(filled($content['intro_price_note']))<span class="price-note">{{ $content['intro_price_note'] }}</span>@endif</div>
    <div class="card">
        @if($errors->any())<div class="error"><strong>{{ $content['validation_error_title'] }}</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <form method="post" action="{{ route('interest.store') }}" data-track-form data-meta-event="SubmitApplication" data-ga-event="form_submit" data-event-name="interest_form_submit">
            @csrf
            @foreach($sections as $section)
                <div class="section">
                    @if(filled($section->title))<h2>{{ $section->title }}</h2>@endif
                    @if(filled($section->description))<p class="section-description">{{ $section->description }}</p>@endif

                    @if($section->section_key === 'consent')
                        <label class="choice"><input type="checkbox" name="reservation_interest" value="1" @checked(old('reservation_interest'))><span><strong>{{ $content['reservation_label'] }}</strong>@if(filled($content['reservation_help']))<div class="help">{{ $content['reservation_help'] }}</div>@endif</span></label><label class="choice"><input type="checkbox" name="privacy_consent" value="1" @checked(old('privacy_consent')) required><span>{{ $content['privacy_consent_prefix'] }} <a target="_blank" href="{{ route('privacy') }}">{{ $content['privacy_link_label'] }}</a> {{ $content['privacy_consent_suffix'] }} *</span></label>
                    @endif
                    @if($fields->where('section_key', $section->section_key)->isNotEmpty())
                        <div class="grid">
                            @foreach($fields->where('section_key', $section->section_key) as $field)
                                @include('interest.partials.custom-field', ['field' => $field])
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
            @foreach($attribution as $key=>$value)<input type="hidden" name="{{ $key }}" value="{{ $value }}">@endforeach
            <button class="submit" type="submit">{{ $content['submit_label'] }}</button>@if(filled($content['footer_note']))<div class="privacy">{{ $content['footer_note'] }}</div>@endif
        </form>
    </div>
</div>
</body>
</html>
