<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="Temoe Tumbuh adalah daycare hangat untuk keluarga Cilegon dan Serang—ruang aman untuk anak bermain, belajar, dan bertumbuh dengan bahagia.">
    <title>Temoe Tumbuh — Daycare Hangat untuk Cerita Tumbuh Mereka</title>
    @include('partials.branding-head')
    <style>
        :root{
            --ink:#17372d;--muted:#60736b;--forest:#245845;--forest-deep:#173d31;
            --lime:#dcec88;--sun:#f6c959;--coral:#ee8f73;--sky:#a9d9e5;
            --cream:#fffaf0;--paper:#fffefb;--line:#e8e4d8;--white:#fff;
            --shadow:0 22px 70px rgba(29,72,56,.13);--soft-shadow:0 12px 34px rgba(29,72,56,.08)
        }
        *{box-sizing:border-box}html{scroll-behavior:smooth;scroll-padding-top:132px}body{margin:0;font-family:Inter,ui-sans-serif,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;color:var(--ink);background:var(--paper);font-size:16px;overflow-x:hidden}a{text-decoration:none;color:inherit}button,input{font:inherit}.wrap{width:min(1180px,calc(100% - 48px));margin:auto}.announcement{background:var(--forest-deep);color:#eef6ed;text-align:center;padding:10px 18px;font-size:13px;font-weight:700;letter-spacing:.15px}.announcement span{color:var(--lime)}.site-header{position:sticky;top:0;z-index:50;background:rgba(255,254,251,.9);backdrop-filter:blur(16px);border-bottom:1px solid rgba(232,228,216,.85);box-shadow:0 8px 28px rgba(23,55,45,.05)}.nav{height:76px;display:flex;align-items:center;justify-content:space-between;gap:24px}.brand{display:flex;align-items:center;gap:11px;font-size:22px;font-weight:850;letter-spacing:-.7px}.brand-mark{width:38px;height:38px;border-radius:13px 13px 18px 18px;background:var(--lime);display:grid;place-items:center;color:var(--forest-deep);font-size:21px;transform:rotate(-3deg);overflow:hidden}.brand-logo{width:100%;height:100%;object-fit:contain;background:#fff}.nav-links{display:flex;align-items:center;gap:23px;color:#496159;font-size:14px;font-weight:700}.nav-links a:hover{color:var(--forest)}.nav-cta,.btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;border-radius:14px;font-weight:800;transition:transform .2s ease,box-shadow .2s ease,background .2s ease}.nav-cta{padding:11px 16px;background:var(--forest);color:#fff;font-size:13px;box-shadow:0 8px 22px rgba(36,88,69,.18)}.nav-cta:hover,.btn:hover{transform:translateY(-2px)}
        .hero-shell{position:relative;background:linear-gradient(145deg,#f2f7dc 0%,#fff6df 52%,#fce9df 100%);border:1px solid #eee8d2;border-radius:38px;overflow:hidden}.hero-shell:before,.hero-shell:after{content:"";position:absolute;border-radius:999px;filter:blur(1px);opacity:.65}.hero-shell:before{width:260px;height:260px;background:var(--sky);right:-100px;top:-120px}.hero-shell:after{width:190px;height:190px;background:var(--coral);left:-110px;bottom:-110px}.hero{position:relative;z-index:1;padding:58px;display:grid;grid-template-columns:1.03fr .97fr;gap:52px;align-items:center;min-height:650px}.eyebrow{display:inline-flex;align-items:center;gap:9px;background:rgba(255,255,255,.78);border:1px solid rgba(36,88,69,.12);border-radius:999px;padding:9px 13px;font-size:12px;font-weight:850;letter-spacing:.5px;text-transform:uppercase}.eyebrow-dot{width:8px;height:8px;background:#56a36d;border-radius:50%;box-shadow:0 0 0 5px rgba(86,163,109,.14)}.hero h1{font-family:Georgia,"Times New Roman",serif;font-size:clamp(47px,5.7vw,76px);line-height:.98;letter-spacing:-3.3px;margin:23px 0 20px;max-width:680px}.hero h1 em{font-style:normal;color:var(--forest);position:relative}.hero p{font-size:18px;line-height:1.72;color:#536c62;max-width:610px;margin:0}.actions{display:flex;gap:11px;flex-wrap:wrap;margin-top:29px}.btn{padding:14px 20px}.btn-primary{background:var(--forest);color:#fff;box-shadow:0 13px 28px rgba(36,88,69,.2)}.btn-primary:hover{background:var(--forest-deep)}.btn-light{background:rgba(255,255,255,.75);border:1px solid rgba(36,88,69,.12);color:var(--forest)}.hero-notes{display:flex;gap:18px;flex-wrap:wrap;margin-top:28px;color:#4c645b;font-size:13px;font-weight:700}.hero-notes span{display:flex;align-items:center;gap:7px}.check{width:20px;height:20px;border-radius:50%;background:#dbe9a2;display:grid;place-items:center;font-size:11px}.hero-visual{position:relative;min-height:520px}.photo-frame{position:absolute;inset:0 20px 20px 0;border-radius:29px;overflow:hidden;background:linear-gradient(145deg,#cce3d8,#f6d9ad);box-shadow:var(--shadow);border:8px solid rgba(255,255,255,.84)}.photo-frame img{width:100%;height:100%;object-fit:cover}.photo-placeholder{width:100%;height:100%;min-height:500px;display:grid;place-items:center;text-align:center;padding:34px;color:#395f50;background:linear-gradient(140deg,#dceadf,#f6ebbf)}.photo-placeholder span{display:block;font-size:43px;margin-bottom:12px}.photo-placeholder strong{display:block;font-size:18px}.photo-placeholder small{display:block;margin-top:6px;color:#668075}.float-card{position:absolute;z-index:2;background:rgba(255,255,255,.94);backdrop-filter:blur(12px);border:1px solid rgba(23,55,45,.08);border-radius:18px;padding:15px 17px;box-shadow:var(--soft-shadow)}.float-card strong{display:block;font-size:15px}.float-card small{display:block;color:var(--muted);font-size:12px;margin-top:4px}.float-one{left:-24px;bottom:62px}.float-two{right:-10px;top:42px}.float-icon{width:35px;height:35px;border-radius:12px;display:grid;place-items:center;float:left;margin-right:10px;background:#f4d772}.scribble{position:absolute;right:10px;bottom:-12px;background:var(--coral);color:#fff;border-radius:50%;width:80px;height:80px;display:grid;place-items:center;text-align:center;font-size:11px;font-weight:900;line-height:1.15;transform:rotate(8deg);box-shadow:0 12px 26px rgba(144,74,54,.2)}
        .trust-strip{margin:24px 0 0;border:1px solid var(--line);border-radius:20px;background:#fff;box-shadow:var(--soft-shadow);display:grid;grid-template-columns:repeat(4,1fr);overflow:hidden}.trust-item{padding:19px 21px;display:flex;gap:11px;align-items:center;border-right:1px solid var(--line)}.trust-item:last-child{border:0}.trust-icon{font-size:24px}.trust-item strong{display:block;font-size:14px}.trust-item small{display:block;color:var(--muted);font-size:12px;margin-top:3px}
        .section{padding:96px 0}.section-kicker{display:inline-flex;color:var(--forest);font-size:12px;font-weight:900;letter-spacing:1.4px;text-transform:uppercase;margin-bottom:13px}.section-head{max-width:760px;margin-bottom:36px}.section-head.center{text-align:center;margin-left:auto;margin-right:auto}.section-head h2{font-family:Georgia,"Times New Roman",serif;font-size:clamp(37px,4.6vw,56px);line-height:1.06;letter-spacing:-2px;margin:0 0 15px}.section-head p{color:var(--muted);font-size:17px;line-height:1.75;margin:0}.promise-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}.promise{border-radius:25px;padding:29px;min-height:265px;position:relative;overflow:hidden}.promise:nth-child(1){background:#edf3cd}.promise:nth-child(2){background:#dceff3}.promise:nth-child(3){background:#f9dfd5}.promise-number{font-family:Georgia,serif;font-size:65px;line-height:1;color:rgba(23,55,45,.12);position:absolute;right:18px;top:13px}.promise-icon{width:48px;height:48px;border-radius:16px;background:rgba(255,255,255,.62);display:grid;place-items:center;font-size:24px;margin-bottom:38px}.promise h3{font-size:22px;letter-spacing:-.5px;margin:0 0 10px}.promise p{color:#536b62;line-height:1.68;margin:0}
        .program-bg{background:var(--forest-deep);color:#fff;position:relative;overflow:hidden}.program-bg:before{content:"";position:absolute;width:330px;height:330px;border-radius:50%;background:#2d654f;left:-130px;top:-140px}.program-bg .section-head p{color:#bcd0c7}.program-bg .section-kicker{color:var(--lime)}.program-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:17px;position:relative}.program{background:#fff;color:var(--ink);border-radius:24px;padding:26px;min-height:310px;display:flex;flex-direction:column}.program-age{display:inline-flex;align-self:flex-start;padding:7px 10px;border-radius:999px;background:#edf3cd;font-size:12px;font-weight:850}.program:nth-child(2) .program-age{background:#dceff3}.program:nth-child(3) .program-age{background:#f9dfd5}.program h3{font-family:Georgia,serif;font-size:28px;letter-spacing:-.7px;margin:25px 0 10px}.program p{color:var(--muted);line-height:1.65;margin:0}.program-list{margin:auto 0 0;padding:22px 0 0;display:grid;gap:9px;list-style:none;font-size:14px;font-weight:700;color:#425e53}.program-list li:before{content:"✓";margin-right:8px;color:#568462}
        .pricing-bg{background:#fff8eb}.pricing-shell{display:grid;grid-template-columns:.82fr 1.18fr;gap:22px;align-items:stretch}.price-card{background:var(--forest-deep);color:#fff;border-radius:31px;padding:38px;position:relative;overflow:hidden;box-shadow:var(--shadow)}.price-card:after{content:"";position:absolute;width:180px;height:180px;border-radius:50%;background:#2d654f;right:-65px;bottom:-80px}.price-label{font-size:13px;font-weight:850;color:var(--lime);letter-spacing:.8px;text-transform:uppercase}.price-value{font-family:Georgia,serif;font-size:clamp(48px,6vw,72px);letter-spacing:-3px;line-height:1;margin:18px 0 9px}.price-value small{font-family:Inter,sans-serif;font-size:15px;letter-spacing:0;color:#c7d9d1}.price-card h3{font-size:23px;margin:24px 0 10px}.price-card p{color:#c7d9d1;line-height:1.7;margin:0}.price-card .btn{position:relative;z-index:1;background:var(--lime);color:var(--forest-deep);margin-top:25px}.facility-card{background:#fff;border:1px solid var(--line);border-radius:31px;padding:38px;box-shadow:var(--soft-shadow)}.facility-card h3{font-family:Georgia,serif;font-size:35px;letter-spacing:-1px;margin:0 0 9px}.facility-card>p{color:var(--muted);line-height:1.65;margin:0}.facility-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:25px}.facility{display:flex;gap:11px;padding:15px;border-radius:16px;background:#f8f6ef;align-items:flex-start}.facility-icon{flex:0 0 35px;width:35px;height:35px;border-radius:11px;background:#edf3cd;display:grid;place-items:center}.facility strong{display:block;font-size:14px;line-height:1.35}.facility small{display:block;color:var(--muted);font-size:12px;line-height:1.45;margin-top:4px}
        .story-grid{display:grid;grid-template-columns:.93fr 1.07fr;gap:62px;align-items:center}.story-photo{position:relative;min-height:545px;border-radius:30px;overflow:hidden;background:linear-gradient(145deg,#dceadf,#efd7b1);box-shadow:var(--shadow)}.story-photo img{width:100%;height:100%;position:absolute;inset:0;object-fit:cover}.story-photo .photo-placeholder{min-height:545px}.story-stamp{position:absolute;right:20px;bottom:20px;background:#fff;border-radius:18px;padding:16px 18px;box-shadow:var(--soft-shadow);max-width:210px;font-size:13px;line-height:1.55}.timeline{display:grid;gap:6px;margin-top:28px}.timeline-row{display:grid;grid-template-columns:72px 1fr;gap:15px;padding:15px 0;border-bottom:1px solid var(--line)}.timeline-row:last-child{border-bottom:0}.timeline-time{font-size:13px;font-weight:900;color:var(--forest)}.timeline-row strong{display:block;font-size:16px}.timeline-row small{display:block;color:var(--muted);margin-top:5px;line-height:1.5}
        .gallery-bg{background:#fff8eb}.gallery-grid{display:grid;grid-template-columns:1.15fr .85fr;grid-template-rows:repeat(2,255px);gap:16px}.gallery-card{position:relative;border-radius:25px;overflow:hidden;background:linear-gradient(145deg,#dceadf,#f2dda9);min-height:255px}.gallery-card:first-child{grid-row:1/3}.gallery-card:nth-child(2){background:linear-gradient(145deg,#dceff3,#e8e5c9)}.gallery-card:nth-child(3){background:linear-gradient(145deg,#f9dfd5,#f5e8c3)}.gallery-card img{width:100%;height:100%;object-fit:cover}.gallery-label{position:absolute;left:16px;bottom:16px;background:rgba(255,255,255,.92);backdrop-filter:blur(10px);border-radius:13px;padding:10px 13px;font-size:13px;font-weight:850;box-shadow:0 8px 20px rgba(23,55,45,.1)}.gallery-placeholder{height:100%;display:grid;place-items:center;text-align:center;color:#4d6b5e;padding:30px}.gallery-placeholder span{display:block;font-size:34px;margin-bottom:8px}.gallery-placeholder small{display:block;margin-top:5px;color:#71857c}
        .parent-card{background:linear-gradient(145deg,#e5f0d1,#dceff3);border-radius:34px;padding:58px;display:grid;grid-template-columns:1fr .9fr;gap:48px;align-items:center;position:relative;overflow:hidden}.parent-card:after{content:"";width:170px;height:170px;border-radius:50%;background:rgba(255,255,255,.35);position:absolute;right:-55px;top:-55px}.parent-points{display:grid;grid-template-columns:1fr 1fr;gap:13px;margin-top:26px}.parent-point{background:rgba(255,255,255,.68);border:1px solid rgba(23,55,45,.08);border-radius:16px;padding:16px}.parent-point strong{display:block;font-size:14px}.parent-point small{display:block;color:var(--muted);margin-top:5px;line-height:1.45}.phone{width:min(315px,100%);margin:auto;background:#173d31;border:9px solid #173d31;border-radius:34px;box-shadow:var(--shadow);position:relative;z-index:1}.phone-screen{background:#fffefb;border-radius:25px;padding:22px 17px;min-height:410px}.phone-top{display:flex;align-items:center;gap:10px;padding-bottom:16px;border-bottom:1px solid var(--line)}.avatar{width:38px;height:38px;border-radius:13px;background:var(--lime);display:grid;place-items:center}.update-card{margin-top:14px;border:1px solid var(--line);border-radius:16px;padding:14px}.update-image{height:125px;border-radius:12px;background:linear-gradient(135deg,#dceadf,#f5dfb6);overflow:hidden}.update-image img{width:100%;height:100%;object-fit:cover}.update-card strong{display:block;font-size:13px;margin-top:11px}.update-card p{font-size:12px;color:var(--muted);line-height:1.5;margin:5px 0 0}
        .fit-grid{display:grid;grid-template-columns:1.05fr .95fr;gap:42px;align-items:start}.fit-card{border:1px solid var(--line);border-radius:25px;padding:29px;background:#fff;box-shadow:var(--soft-shadow)}.fit-card h3{font-size:21px;margin:0 0 18px}.fit-list{display:grid;gap:14px}.fit-row{display:flex;gap:12px;align-items:flex-start}.fit-check{flex:0 0 30px;width:30px;height:30px;border-radius:10px;background:#edf3cd;display:grid;place-items:center;font-weight:900;color:var(--forest)}.fit-row strong{display:block;font-size:14px}.fit-row small{display:block;color:var(--muted);line-height:1.5;margin-top:3px}.fit-highlight{background:var(--coral);color:#fff;border-radius:26px;padding:34px;transform:rotate(1deg);box-shadow:var(--soft-shadow)}.fit-highlight h3{font-family:Georgia,serif;font-size:32px;line-height:1.08;letter-spacing:-1px;margin:0 0 13px}.fit-highlight p{line-height:1.7;color:#fff4ef}.fit-highlight .btn{background:#fff;color:#7d3e2c;margin-top:10px}
        .faq-list{display:grid;gap:11px;max-width:860px;margin:auto}.faq-list details{background:#fff;border:1px solid var(--line);border-radius:17px;padding:0 20px;box-shadow:0 8px 25px rgba(29,72,56,.05)}.faq-list summary{cursor:pointer;list-style:none;padding:20px 35px 20px 0;font-weight:800;position:relative}.faq-list summary::-webkit-details-marker{display:none}.faq-list summary:after{content:"+";position:absolute;right:0;top:14px;width:30px;height:30px;border-radius:50%;background:#edf3cd;display:grid;place-items:center;font-size:20px}.faq-list details[open] summary:after{content:"–"}.faq-list p{color:var(--muted);line-height:1.7;margin:0;padding:0 25px 20px 0}
        .custom-section{padding:78px 0;border-top:1px solid var(--line)}.custom-inner{display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:center}.custom-section:nth-of-type(even) .custom-inner{direction:rtl}.custom-section:nth-of-type(even) .custom-inner>*{direction:ltr}.custom-copy h2{font-family:Georgia,serif;font-size:44px;letter-spacing:-1.5px;margin:0 0 12px}.custom-copy .sub{font-size:18px;font-weight:750;margin-bottom:10px}.custom-copy p{white-space:pre-line;color:var(--muted);line-height:1.75}.custom-image{border-radius:25px;min-height:350px;background:linear-gradient(135deg,#e5eee7,#f1e4cf);overflow:hidden}.custom-image img{width:100%;height:100%;min-height:350px;object-fit:cover}
        .final-wrap{padding:22px 0 88px}.final{position:relative;overflow:hidden;background:var(--forest-deep);color:#fff;border-radius:34px;padding:68px 48px;text-align:center}.final:before,.final:after{content:"";position:absolute;border-radius:50%}.final:before{width:220px;height:220px;background:#2b654f;left:-90px;bottom:-120px}.final:after{width:180px;height:180px;background:var(--sun);right:-85px;top:-80px}.final-content{position:relative;z-index:1}.final .section-kicker{color:var(--lime)}.final h2{font-family:Georgia,serif;font-size:clamp(39px,5vw,58px);line-height:1.03;letter-spacing:-2px;margin:0 auto 16px;max-width:820px}.final p{color:#c7d9d1;max-width:690px;margin:0 auto;line-height:1.75;font-size:17px}.final .btn{background:var(--lime);color:var(--forest-deep);margin-top:25px}.footer{padding:29px 0 40px;border-top:1px solid var(--line)}.footer-inner{display:flex;justify-content:space-between;gap:20px;align-items:center}.footer-brand small{display:block;color:var(--muted);margin-top:5px}.footer-links{display:flex;gap:18px;color:var(--muted);font-size:13px}
        @media(max-width:980px){.nav-links{display:none}.hero{padding:42px;grid-template-columns:1fr;min-height:auto}.hero-visual{min-height:470px}.trust-strip{grid-template-columns:1fr 1fr}.trust-item:nth-child(2){border-right:0}.trust-item:nth-child(-n+2){border-bottom:1px solid var(--line)}.promise-grid,.program-grid{grid-template-columns:1fr}.promise{min-height:auto}.program{min-height:275px}.pricing-shell,.story-grid,.parent-card,.fit-grid{grid-template-columns:1fr}.gallery-grid{grid-template-columns:1fr 1fr;grid-template-rows:330px 230px}.gallery-card:first-child{grid-column:1/3;grid-row:auto}.parent-card{padding:42px}.custom-inner,.custom-section:nth-of-type(even) .custom-inner{grid-template-columns:1fr;direction:ltr}}
        @media(max-width:640px){html{scroll-padding-top:105px}.wrap{width:calc(100% - 30px);max-width:1180px}.announcement{font-size:12px}.nav{height:65px}.brand{font-size:18px}.brand-mark{width:34px;height:34px}.nav-cta{padding:10px 12px;font-size:12px}.hero-shell{border-radius:25px}.hero{padding:29px 21px 35px;gap:34px}.hero h1{font-size:45px;letter-spacing:-2.2px}.hero p{font-size:16px}.hero-notes{display:grid;gap:10px}.hero-visual{min-height:390px}.photo-frame{inset:0 4px 10px}.photo-placeholder{min-height:375px}.float-one{left:-7px;bottom:30px}.float-two{right:-5px;top:22px}.scribble{width:68px;height:68px;right:1px}.trust-strip{grid-template-columns:1fr;margin-top:14px}.trust-item{border-right:0;border-bottom:1px solid var(--line)!important}.trust-item:last-child{border-bottom:0!important}.section{padding:70px 0}.section-head h2{font-size:37px;letter-spacing:-1.4px}.promise,.program,.price-card,.facility-card{padding:23px}.facility-grid{grid-template-columns:1fr}.story-grid{gap:36px}.story-photo,.story-photo .photo-placeholder{min-height:420px}.gallery-grid{display:grid;grid-template-columns:1fr;grid-template-rows:none}.gallery-card:first-child{grid-column:auto;min-height:360px}.gallery-card{min-height:230px}.parent-card{padding:30px 20px;border-radius:25px}.parent-points{grid-template-columns:1fr}.fit-highlight{transform:none}.custom-copy h2{font-size:36px}.final{padding:52px 23px;border-radius:25px}.footer-inner{display:block}.footer-links{margin-top:17px;flex-wrap:wrap}.actions .btn{width:100%}}
        .mobile-jumps{display:none}
        @media(max-width:980px){html{scroll-padding-top:140px}.mobile-jumps{display:flex;gap:20px;height:43px;align-items:center;overflow-x:auto;white-space:nowrap;color:#496159;font-size:13px;font-weight:800;scrollbar-width:none}.mobile-jumps::-webkit-scrollbar{display:none}}
        @media(prefers-reduced-motion:reduce){html{scroll-behavior:auto}.btn,.nav-cta{transition:none}}
    </style>
    @include('partials.tracking')
</head>
<body>
@php
$withAttribution = function (string $url): string {
    $query = request()->getQueryString();
    if (!$query) return $url;
    return $url.(str_contains($url, '?') ? '&' : '?').$query;
};
$sectionByKey = fn (string $key) => $sections->firstWhere('section_key', $key);
$imageUrl = function ($section): ?string {
    if (!$section?->image_path) return null;
    return str_starts_with($section->image_path, 'http')
        ? $section->image_path
        : asset(ltrim($section->image_path, '/'));
};
$interestUrl = $withAttribution(route('interest.create'));
$hero = $sectionByKey('hero');
$daily = $sectionByKey('daily_rhythm');
$spacePlay = $sectionByKey('space_play');
$spaceRest = $sectionByKey('space_rest');
$parentUpdates = $sectionByKey('parent_updates');
$pricing = $sectionByKey('pricing');
$facilities = $sectionByKey('facilities');
$priceParts = array_pad(array_map('trim', explode('|', (string) ($pricing?->content ?? ''), 2)), 2, '');
$priceValue = $priceParts[0] ?: 'Rp1,6 juta';
$priceDescription = $priceParts[1] ?: 'Semua yang si kecil butuhkan untuk menjalani hari dengan nyaman.';
$facilityItems = collect(preg_split('/\r\n|\r|\n/', (string) ($facilities?->content ?? '')))->filter()->values();
$knownKeys = ['hero','daily_rhythm','space_play','space_rest','parent_updates','pricing','facilities'];
$customSections = $sections->reject(fn ($section) => in_array($section->section_key, $knownKeys, true));
$logoUrl = !empty($branding['logo_url'])
    ? (str_starts_with($branding['logo_url'], 'http') ? $branding['logo_url'] : asset(ltrim($branding['logo_url'], '/')))
    : null;
@endphp

<div class="announcement"><span>Founding Families</span> · Moms, priority slot Cilegon & Serang sedang dibuka</div>
<header class="site-header">
    <nav class="nav wrap" aria-label="Navigasi utama">
        <a class="brand" href="{{ route('home') }}" data-meta-event="ViewContent" data-ga-event="navigation_click" data-event-name="home">
            <span class="brand-mark">@if($logoUrl)<img class="brand-logo" src="{{ $logoUrl }}" alt="Logo Temoe Tumbuh">@else 🌱 @endif</span><span>Temoe Tumbuh</span>
        </a>
        <div class="nav-links"><a href="#program" data-meta-event="ViewContent" data-ga-event="navigation_click" data-event-name="program">Program</a><a href="#pengalaman" data-meta-event="ViewContent" data-ga-event="navigation_click" data-event-name="experience">Pengalaman</a><a href="#harga" data-meta-event="ViewContent" data-ga-event="navigation_click" data-event-name="pricing">Harga</a><a href="#orang-tua" data-meta-event="ViewContent" data-ga-event="navigation_click" data-event-name="parents">Untuk Moms</a><a href="#faq" data-meta-event="ViewContent" data-ga-event="navigation_click" data-event-name="faq">FAQ</a></div>
        <a class="nav-cta" href="{{ $interestUrl }}" data-meta-event="Contact" data-ga-event="begin_signup" data-event-name="sticky_nav_interest">Daftar Minat <span>→</span></a>
    </nav>
    <nav class="mobile-jumps wrap" aria-label="Navigasi section">
        <a href="#program" data-meta-event="ViewContent" data-ga-event="navigation_click" data-event-name="program">Program</a>
        <a href="#pengalaman" data-meta-event="ViewContent" data-ga-event="navigation_click" data-event-name="experience">Pengalaman</a>
        <a href="#harga" data-meta-event="ViewContent" data-ga-event="navigation_click" data-event-name="pricing">Harga</a>
        <a href="#orang-tua" data-meta-event="ViewContent" data-ga-event="navigation_click" data-event-name="parents">Untuk Moms</a>
        <a href="#faq" data-meta-event="ViewContent" data-ga-event="navigation_click" data-event-name="faq">FAQ</a>
    </nav>
</header>

<main>
    <div class="wrap">
        <section class="hero-shell">
            <div class="hero">
                <div>
                    <span class="eyebrow"><span class="eyebrow-dot"></span> Daycare hangat untuk bayi hingga preschool</span>
                    <h1>{{ $hero?->title ?: 'Tempat kecil untuk cerita tumbuh yang besar.' }}</h1>
                    <p>{{ $hero?->subtitle ?: 'Moms bisa melangkah lebih tenang, sementara si kecil bermain, belajar, dan tumbuh di lingkungan yang hangat sesuai tahap usianya.' }}</p>
                    <div class="actions">
                        <a class="btn btn-primary" href="{{ $withAttribution($hero?->cta_url ?: route('interest.create')) }}" data-meta-event="Contact" data-ga-event="begin_signup" data-event-name="hero_priority_slot">{{ $hero?->cta_label ?: 'Amankan Priority Slot' }} <span>→</span></a>
                        <a class="btn btn-light" href="#pengalaman" data-meta-event="ViewContent" data-ga-event="select_content" data-event-name="hero_daily_experience">Lihat keseharian anak</a>
                    </div>
                    <div class="hero-notes"><span><i class="check">✓</i> Dari bayi, toddler, sampai preschool</span><span><i class="check">✓</i> Kabar harian untuk Moms</span></div>
                </div>
                <div class="hero-visual">
                    <div class="photo-frame">
                        @if($imageUrl($hero))<img src="{{ $imageUrl($hero) }}" alt="Anak bermain dan bertumbuh di Temoe Tumbuh">
                        @else<div class="photo-placeholder"><div><span>🌈</span><strong>Ruang hangat untuk bermain dan bertumbuh</strong><small>Tempat anak menemukan cerita baru setiap hari.</small></div></div>@endif
                    </div>
                    <div class="float-card float-one"><span class="float-icon">☀️</span><strong>Hari yang menyenangkan</strong><small>Bermain, belajar, dan beristirahat</small></div>
                    <div class="float-card float-two"><span class="float-icon">💬</span><strong>Moms tetap dekat</strong><small>Update momen penting setiap hari</small></div>
                    <div class="scribble">PLAY<br>LEARN<br>GROW</div>
                </div>
            </div>
        </section>
        <div class="trust-strip">
            <div class="trust-item"><span class="trust-icon">🧸</span><div><strong>Bayi–preschool</strong><small>Aktivitas mengikuti fase anak</small></div></div>
            <div class="trust-item"><span class="trust-icon">🕘</span><div><strong>Full day & half day</strong><small>Pilihan mengikuti ritme keluarga</small></div></div>
            <div class="trust-item"><span class="trust-icon">🧠</span><div><strong>Play-based learning</strong><small>Belajar alami lewat eksplorasi</small></div></div>
            <div class="trust-item"><span class="trust-icon">📍</span><div><strong>Cilegon & Serang</strong><small>Prioritas area dari keluarga</small></div></div>
        </div>
    </div>

    <section class="section" id="pengalaman">
        <div class="wrap">
            <div class="section-head"><span class="section-kicker">Rasa aman untuk tumbuh</span><h2>Bukan sekadar tempat menunggu Moms pulang.</h2><p>Setiap bagian hari dirancang supaya anak merasa dikenal, berani mencoba, dan pulang membawa cerita baru untuk Kamu dengarkan.</p></div>
            <div class="promise-grid">
                <article class="promise"><span class="promise-number">01</span><div class="promise-icon">🤍</div><h3>Hangat sejak datang</h3><p>Transisi pagi yang pelan, sapaan personal, dan ritme yang konsisten membantu anak merasa nyaman sejak membuka pintu.</p></article>
                <article class="promise"><span class="promise-number">02</span><div class="promise-icon">🎨</div><h3>Aktif tanpa dipaksa</h3><p>Eksplorasi sensori, gerak, seni, bahasa, dan permainan sosial hadir sebagai pengalaman yang menyenangkan.</p></article>
                <article class="promise"><span class="promise-number">03</span><div class="promise-icon">🌿</div><h3>Tumbuh dengan ritmenya</h3><p>Kami menghargai bahwa setiap anak punya tempo, minat, dan cara beradaptasi yang tidak selalu sama.</p></article>
            </div>
        </div>
    </section>

    <section class="section program-bg" id="program">
        <div class="wrap">
            <div class="section-head center"><span class="section-kicker">Dari bayi hingga preschool</span><h2>Ada ruang tumbuh untuk setiap fase si kecil.</h2><p>Moms, program kami mengikuti kebutuhan perkembangan anak—bukan sekadar membagi mereka berdasarkan umur.</p></div>
            <div class="program-grid">
                <article class="program"><span class="program-age">Bayi · Infant Care</span><h3>Tiny Beginnings</h3><p>Perawatan lembut, responsif, dan penuh perhatian untuk membangun rasa aman sejak hari-hari pertamanya.</p><ul class="program-list"><li>Responsive care & bonding</li><li>Tummy time dan stimulasi sensori</li><li>Rutinitas makan, tidur, dan kebersihan</li></ul></article>
                <article class="program"><span class="program-age">Toddler</span><h3>Little Explorer</h3><p>Ruang aman untuk bergerak, mencoba, mengenal emosi, dan menemukan dunia lewat seluruh indera.</p><ul class="program-list"><li>Sensory & messy play</li><li>Gerak, bahasa, dan kemandirian awal</li><li>Belajar berbagi lewat bermain</li></ul></article>
                <article class="program"><span class="program-age">Pre-school</span><h3>Growing Independent</h3><p>Persiapan lembut menuju sekolah dengan rasa ingin tahu, kemampuan sosial, dan percaya diri.</p><ul class="program-list"><li>Pre-literacy & numeracy</li><li>Daily life skills</li><li>Kolaborasi dan komunikasi</li></ul></article>
            </div>
        </div>
    </section>

    @if($pricing || $facilities)
    <section class="section pricing-bg" id="harga">
        <div class="wrap">
            <div class="section-head center"><span class="section-kicker">Paket yang tumbuh bersama keluarga</span><h2>{{ $pricing?->title ?: 'Care lengkap, mulai dari Rp1,6 juta.' }}</h2><p>{{ $pricing?->subtitle ?: 'Pilih ritme yang cocok untuk keluarga Kamu. Moms akan mendapat rincian paket sesuai usia anak, jadwal, dan ketersediaan slot.' }}</p></div>
            <div class="pricing-shell">
                <article class="price-card">
                    <span class="price-label">Start from</span>
                    <div class="price-value">{{ $priceValue }} <small>/ bulan*</small></div>
                    <h3>{{ $priceDescription }}</h3>
                    <p>*Harga awal dapat menyesuaikan usia, pilihan half day/full day, frekuensi kehadiran, dan kebutuhan perawatan.</p>
                    <a class="btn" href="{{ $withAttribution($pricing?->cta_url ?: route('interest.create')) }}" data-meta-event="Contact" data-ga-event="begin_signup" data-event-name="pricing_interest">{{ $pricing?->cta_label ?: 'Cek Paket untuk Si Kecil' }} →</a>
                </article>
                <article class="facility-card">
                    <h3>{{ $facilities?->title ?: 'Yang Moms dapatkan di Temoe Tumbuh' }}</h3>
                    <p>{{ $facilities?->subtitle ?: 'Fasilitas yang membuat hari anak lebih aman, nyaman, aktif, dan tetap terasa dekat dengan rumah.' }}</p>
                    <div class="facility-grid">
                        @forelse($facilityItems as $index => $item)
                            @php($facilityParts = array_pad(array_map('trim', explode('|', $item, 2)), 2, ''))
                            <div class="facility"><span class="facility-icon">{{ ['🛡️','🍱','🧸','💬','🌙','🎨'][$index % 6] }}</span><div><strong>{{ $facilityParts[0] }}</strong>@if($facilityParts[1])<small>{{ $facilityParts[1] }}</small>@endif</div></div>
                        @empty
                            <div class="facility"><span class="facility-icon">🛡️</span><div><strong>Lingkungan aman & child-friendly</strong><small>Ruang disiapkan untuk aktivitas sesuai tahap usia.</small></div></div>
                            <div class="facility"><span class="facility-icon">🍱</span><div><strong>Makan & snack bernutrisi</strong><small>Menu harian untuk mendukung energi si kecil.</small></div></div>
                            <div class="facility"><span class="facility-icon">🧸</span><div><strong>Program sesuai usia</strong><small>Mulai dari bayi, toddler, hingga pre-school.</small></div></div>
                            <div class="facility"><span class="facility-icon">💬</span><div><strong>Daily update untuk Moms</strong><small>Momen, aktivitas, makan, tidur, dan catatan harian.</small></div></div>
                            <div class="facility"><span class="facility-icon">🌙</span><div><strong>Area istirahat nyaman</strong><small>Ritme aktif dan tenang yang lebih seimbang.</small></div></div>
                            <div class="facility"><span class="facility-icon">🎨</span><div><strong>Play-based learning</strong><small>Eksplorasi sensori, seni, bahasa, dan gerak.</small></div></div>
                        @endforelse
                    </div>
                </article>
            </div>
        </div>
    </section>
    @endif

    <section class="section">
        <div class="wrap story-grid">
            <div class="story-photo">
                @if($imageUrl($daily))<img src="{{ $imageUrl($daily) }}" alt="Rutinitas harian anak di Temoe Tumbuh">
                @else<div class="photo-placeholder"><div><span>🧩</span><strong>Eksplorasi dalam setiap aktivitas</strong><small>Bergerak, berkarya, dan belajar bersama teman.</small></div></div>@endif
                <div class="story-stamp"><strong>{{ $daily?->title ?: 'Banyak bergerak, cukup beristirahat.' }}</strong><br><span style="color:var(--muted)">{{ $daily?->subtitle ?: 'Ritme yang seimbang membuat anak menikmati harinya.' }}</span></div>
            </div>
            <div>
                <span class="section-kicker">A day at Temoe</span>
                <div class="section-head" style="margin-bottom:0"><h2>{{ $daily?->content ?: 'Hari yang terarah, tanpa kehilangan serunya bermain.' }}</h2><p>Moms, jadwal si kecil akan menyesuaikan usia dan kebutuhannya, dengan alur yang membantu mereka merasa aman karena tahu apa yang terjadi selanjutnya.</p></div>
                <div class="timeline">
                    <div class="timeline-row"><div class="timeline-time">PAGI</div><div><strong>Warm welcome & free play</strong><small>Datang tanpa terburu-buru, beradaptasi, lalu mulai bermain bersama.</small></div></div>
                    <div class="timeline-row"><div class="timeline-time">TENGAH HARI</div><div><strong>Explore, eat & recharge</strong><small>Aktivitas tematik, makan bersama, kebersihan diri, dan waktu istirahat.</small></div></div>
                    <div class="timeline-row"><div class="timeline-time">SORE</div><div><strong>Create, reflect & go home</strong><small>Permainan ringan, merapikan karya, dan berbagi cerita sebelum pulang.</small></div></div>
                </div>
            </div>
        </div>
    </section>

    <section class="section gallery-bg">
        <div class="wrap">
            <div class="section-head center"><span class="section-kicker">Ruang yang terasa seperti rumah</span><h2>Nyaman untuk menetap. Seru untuk dijelajahi.</h2><p>Sudut-sudut yang mengundang anak bergerak, berkreasi, berinteraksi, sekaligus punya tempat tenang ketika membutuhkannya.</p></div>
            <div class="gallery-grid">
                <div class="gallery-card">@if($imageUrl($spacePlay))<img src="{{ $imageUrl($spacePlay) }}" alt="Ruang bermain Temoe Tumbuh">@else<div class="gallery-placeholder"><div><span>🏡</span><strong>Open play space</strong><small>Bebas bergerak, bertemu, dan mengeksplorasi.</small></div></div>@endif<div class="gallery-label">Open play & exploration</div></div>
                <div class="gallery-card">@if($imageUrl($spaceRest))<img src="{{ $imageUrl($spaceRest) }}" alt="Sudut tenang dan istirahat Temoe Tumbuh">@else<div class="gallery-placeholder"><div><span>🌙</span><strong>Calm corner</strong><small>Sudut nyaman untuk beristirahat dan menenangkan diri.</small></div></div>@endif<div class="gallery-label">Rest & quiet corner</div></div>
                <div class="gallery-card"><div class="gallery-placeholder"><div><span>🎨</span><strong>Creative corner</strong><small>Area berkarya, membaca, dan bercerita</small></div></div><div class="gallery-label">Create & imagine</div></div>
            </div>
        </div>
    </section>

    <section class="section" id="orang-tua">
        <div class="wrap parent-card">
            <div>
                <span class="section-kicker">Moms tetap terhubung</span>
                <div class="section-head" style="margin-bottom:0"><h2>{{ $parentUpdates?->title ?: 'Kamu tetap jadi bagian dari hari mereka.' }}</h2><p>{{ $parentUpdates?->subtitle ?: 'Momen penting, aktivitas, makan, tidur, dan catatan hariannya dirangkum agar Moms tidak merasa kehilangan cerita.' }}</p></div>
                <div class="parent-points">
                    <div class="parent-point"><strong>Daily moments</strong><small>Cuplikan aktivitas dan karya yang bermakna.</small></div>
                    <div class="parent-point"><strong>Routine notes</strong><small>Informasi makan, tidur, dan kebutuhan harian.</small></div>
                    <div class="parent-point"><strong>Open communication</strong><small>Ruang komunikasi dua arah yang jelas.</small></div>
                    <div class="parent-point"><strong>Growth stories</strong><small>Catatan kecil tentang proses dan perkembangan.</small></div>
                </div>
            </div>
            <div class="phone" aria-label="Contoh tampilan update harian">
                <div class="phone-screen"><div class="phone-top"><div class="avatar">🌱</div><div><strong style="font-size:14px">Hari ini di Temoe</strong><small style="display:block;color:var(--muted);margin-top:3px">Update untuk Moms</small></div></div><div class="update-card"><div class="update-image">@if($imageUrl($parentUpdates))<img src="{{ $imageUrl($parentUpdates) }}" alt="Update aktivitas anak">@endif</div><strong>Hari ini kami bereksplorasi 🌈</strong><p>Anak-anak bermain warna, mengenali tekstur, dan belajar bergantian menggunakan alat.</p></div><div class="update-card"><strong>Catatan singkat</strong><p>Aktif bermain · Makan baik · Istirahat cukup</p></div></div>
            </div>
        </div>
    </section>

    <section class="section" style="padding-top:15px">
        <div class="wrap fit-grid">
            <div class="fit-card"><span class="section-kicker">Cocok untuk keluarga Kamu?</span><h3>Temoe Tumbuh bisa jadi pilihan kalau…</h3><div class="fit-list"><div class="fit-row"><span class="fit-check">✓</span><div><strong>Moms mencari lingkungan yang hangat, bukan terasa institusional</strong><small>Anak dipandang sebagai pribadi dengan ritme dan kebutuhan yang berbeda.</small></div></div><div class="fit-row"><span class="fit-check">✓</span><div><strong>Kamu ingin kegiatan yang menyenangkan sekaligus bermakna</strong><small>Bermain tetap menjadi cara utama anak mengenal dunia.</small></div></div><div class="fit-row"><span class="fit-check">✓</span><div><strong>Moms ingin komunikasi yang terbuka dan mudah dipahami</strong><small>Kamu tidak perlu menebak-nebak bagaimana hari anak berjalan.</small></div></div><div class="fit-row"><span class="fit-check">✓</span><div><strong>Kamu butuh pilihan jadwal yang dekat dengan ritme keluarga</strong><small>Kebutuhan keluarga menjadi dasar pilihan program yang paling pas.</small></div></div></div></div>
            <aside class="fit-highlight"><h3>Mulai dari kebutuhan keluarga Kamu.</h3><p>Ceritakan usia anak, area yang nyaman, jadwal, dan ekspektasi Moms. Kami akan membantu mengarahkan pilihan layanan Temoe Tumbuh yang paling relevan.</p><a class="btn" href="{{ $interestUrl }}" data-meta-event="Contact" data-ga-event="begin_signup" data-event-name="family_fit_interest">Ceritakan kebutuhan keluarga →</a></aside>
        </div>
    </section>

    <section class="section" id="faq">
        <div class="wrap"><div class="section-head center"><span class="section-kicker">Pertanyaan dari Moms</span><h2>Yang mungkin ingin Kamu tanyakan.</h2><p>Kami rangkum hal-hal penting sebelum keluarga bergabung sebagai Founding Families.</p></div><div class="faq-list">
            <details data-meta-event="ViewContent" data-ga-event="faq_open" data-event-name="location"><summary>Temoe Tumbuh akan hadir di area mana?</summary><p>Fokus pertama kami adalah Cilegon dan Serang. Area final akan diprioritaskan berdasarkan konsentrasi kebutuhan keluarga yang masuk melalui formulir minat.</p></details>
            <details data-meta-event="ViewContent" data-ga-event="faq_open" data-event-name="age"><summary>Usia berapa yang bisa bergabung?</summary><p>Program disiapkan mulai dari bayi, toddler, hingga pre-school. Pembagian kelompok dan kapasitas akan disesuaikan agar aktivitas tetap nyaman dan relevan untuk setiap tahap perkembangan.</p></details>
            <details data-meta-event="ViewContent" data-ga-event="faq_open" data-event-name="schedule"><summary>Apakah tersedia full day dan half day?</summary><p>Ya, keduanya menjadi pilihan program yang sedang dipersiapkan. Kami juga memetakan kebutuhan beberapa hari per minggu dan jadwal fleksibel dari keluarga pendaftar.</p></details>
            <details data-meta-event="ViewContent" data-ga-event="faq_open" data-event-name="price"><summary>Berapa estimasi biayanya?</summary><p>Paket Temoe Tumbuh dimulai dari Rp1,6 juta per bulan. Harga akhir menyesuaikan usia anak, jadwal half day/full day, frekuensi hadir, dan kebutuhan perawatan.</p></details>
            <details data-meta-event="ViewContent" data-ga-event="faq_open" data-event-name="commitment"><summary>Apakah mengisi formulir berarti wajib mendaftar?</summary><p>Tidak. Formulir minat belum menjadi transaksi atau kewajiban membeli. Moms akan mendapat informasi lebih awal saat area, jadwal, paket, dan tahap reservasi sudah siap.</p></details>
        </div></div>
    </section>

    @foreach($customSections as $section)
        <section class="custom-section"><div class="wrap custom-inner"><div class="custom-copy"><h2>{{ $section->title }}</h2>@if($section->subtitle)<div class="sub">{{ $section->subtitle }}</div>@endif @if($section->content)<p>{{ $section->content }}</p>@endif @if($section->cta_label)<a class="btn btn-primary" style="margin-top:12px" href="{{ $withAttribution($section->cta_url ?: route('interest.create')) }}" data-meta-event="Contact" data-ga-event="select_promotion" data-event-name="custom_{{ $section->section_key }}">{{ $section->cta_label }}</a>@endif</div><div class="custom-image">@if($imageUrl($section))<img src="{{ $imageUrl($section) }}" alt="{{ $section->title }}">@endif</div></div></section>
    @endforeach

    <div class="wrap final-wrap"><section class="final"><div class="final-content"><span class="section-kicker">Founding Families</span><h2>Tempat tumbuh yang Kamu cari bisa dimulai dari sini.</h2><p>Moms, bagikan kebutuhan keluarga dan dapatkan priority update untuk lokasi, program, harga, serta pembukaan slot pertama Temoe Tumbuh.</p><a class="btn" href="{{ $interestUrl }}" data-meta-event="Contact" data-ga-event="begin_signup" data-event-name="final_interest">Daftar Minat Temoe Tumbuh →</a></div></section></div>
</main>

<footer class="footer"><div class="wrap footer-inner"><div class="footer-brand"><a class="brand" href="{{ route('home') }}"><span class="brand-mark">@if($logoUrl)<img class="brand-logo" src="{{ $logoUrl }}" alt="">@else 🌱 @endif</span><span>Temoe Tumbuh</span></a><small>Little days. Big growth stories.</small></div><div class="footer-links"><a href="#program">Program</a><a href="#harga">Harga</a><a href="#orang-tua">Untuk Moms</a><a href="{{ route('privacy') }}">Privasi</a><span>Cilegon · Serang</span></div></div></footer>
</body>
</html>
