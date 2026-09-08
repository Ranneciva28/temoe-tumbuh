<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Terima kasih — Temoe Tumbuh</title>
    @include('partials.branding-head')
    <style>*{box-sizing:border-box}body{font-family:Inter,ui-sans-serif,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;background:linear-gradient(145deg,#edf3cd,#fff8eb,#f9dfd5);color:#26372f;margin:0;min-height:100vh;display:grid;place-items:center;padding:22px}.card{width:min(650px,100%);background:#fff;border:1px solid #e4dfd4;border-radius:27px;padding:50px;text-align:center;box-shadow:0 25px 70px rgba(48,60,53,.09)}.icon{width:70px;height:70px;border-radius:22px;background:#dfeadf;display:grid;place-items:center;margin:0 auto 22px;font-size:34px}.card h1{font-family:Georgia,serif;font-size:42px;letter-spacing:-1.3px;margin:0 0 12px}.card p{color:#68746d;line-height:1.7;font-size:16px}.btn{display:inline-block;margin-top:18px;background:#426957;color:white;padding:13px 18px;border-radius:12px;font-weight:750;text-decoration:none}@media(max-width:600px){.card{padding:36px 22px}.card h1{font-size:34px}}</style>
    @include('partials.tracking')
    @if(session('lead_submitted'))
        @if(!empty($tracking['google_ads_conversion_id']) && !empty($tracking['google_ads_conversion_label']))<script>if(typeof gtag==='function'){gtag('event','conversion',{'send_to':@json($tracking['google_ads_conversion_id'].'/'.$tracking['google_ads_conversion_label'])});}</script>@endif
        @if(!empty($tracking['ga4_measurement_id']))<script>if(typeof gtag==='function'){gtag('event','generate_lead',{'event_category':'market_validation','event_label':'interest_form'});}</script>@endif
    @endif
</head>
<body><div class="card"><div class="icon">🌱</div><h1>Terima kasih, Moms!</h1><p>Pendaftaran minat Kamu sudah tercatat. Kami akan mengabari informasi lokasi, program, harga, dan pembukaan slot Temoe Tumbuh untuk bayi hingga pre-school.</p><a class="btn" href="{{ route('home') }}" data-meta-event="ViewContent" data-ga-event="navigation_click" data-event-name="thank_you_home">Kembali ke Homepage</a></div></body>
</html>
