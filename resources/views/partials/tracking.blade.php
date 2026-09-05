@if(!empty($tracking['meta_pixel_id']))
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', @json($tracking['meta_pixel_id']));
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id={{ urlencode($tracking['meta_pixel_id']) }}&ev=PageView&noscript=1" alt=""></noscript>
@endif

@php($gtagId = $tracking['ga4_measurement_id'] ?? ($tracking['google_ads_conversion_id'] ?? null))
@if(!empty($gtagId))
<script async src="https://www.googletagmanager.com/gtag/js?id={{ urlencode($gtagId) }}"></script>
<script>
window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments)}gtag('js',new Date());
@if(!empty($tracking['ga4_measurement_id']))gtag('config',@json($tracking['ga4_measurement_id']));@endif
@if(!empty($tracking['google_ads_conversion_id']))gtag('config',@json($tracking['google_ads_conversion_id']));@endif
</script>
@endif
