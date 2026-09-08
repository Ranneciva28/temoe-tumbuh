@if(!empty($tracking['meta_pixel_id']))
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', @json($tracking['meta_pixel_id']));
</script>
@endif

@if(!empty($tracking['tiktok_pixel_id']))
<script>
!function(w,d,t){w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=['page','track','identify','instances','debug','on','off','once','ready','alias','group','enableCookie','disableCookie','holdConsent','revokeConsent','grantConsent'];ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e};ttq.load=function(e,n){var r='https://analytics.tiktok.com/i18n/pixel/events.js',o=n&&n.partner;ttq._i[e]=[];ttq._i[e]._u=r;ttq._t=ttq._t||{};ttq._t[e]=+new Date;ttq._o=ttq._o||{};ttq._o[e]=n||{};var a=document.createElement('script');a.type='text/javascript';a.async=!0;a.src=r+'?sdkid='+e+'&lib='+t;var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(a,s)};ttq.load(@json($tracking['tiktok_pixel_id']));ttq.page()}(window,document,'ttq');
</script>
@endif

@php
    $gtagId = $tracking['ga4_measurement_id'] ?? ($tracking['google_ads_conversion_id'] ?? null);
    $browserMappings = $metaEventMappings->map(fn ($mapping) => [
        'id' => $mapping->id,
        'event_name' => $mapping->event_name,
        'trigger_type' => $mapping->trigger_type,
        'target_key' => $mapping->target_key,
    ])->values();
@endphp
@if(!empty($gtagId))
<script async src="https://www.googletagmanager.com/gtag/js?id={{ urlencode($gtagId) }}"></script>
<script>
window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments)}gtag('js',new Date());
@if(!empty($tracking['ga4_measurement_id']))gtag('config',@json($tracking['ga4_measurement_id']));@endif
@if(!empty($tracking['google_ads_conversion_id']))gtag('config',@json($tracking['google_ads_conversion_id']));@endif
</script>
@endif

<script>
document.addEventListener('DOMContentLoaded',function(){
    var metaMappings=@json($browserMappings);
    var metaPageTarget=@json($metaPageTarget);
    var metaServerEventIds=@json($metaServerEventIds);
    var recordUrl=@json(route('meta-events.record'));
    var csrfToken=@json(csrf_token());

    function createEventId(mapping){
        var randomPart=window.crypto&&typeof window.crypto.randomUUID==='function'
            ? window.crypto.randomUUID()
            : Math.random().toString(36).slice(2);
        return 'temoe_meta_'+mapping.id+'_'+Date.now()+'_'+randomPart;
    }

    function recordDispatch(mapping,eventId){
        var data=new FormData();
        data.append('_token',csrfToken);
        data.append('mapping_id',String(mapping.id));
        data.append('event_id',eventId);
        data.append('page_url',window.location.href);
        if(navigator.sendBeacon&&navigator.sendBeacon(recordUrl,data))return;
        fetch(recordUrl,{method:'POST',body:data,credentials:'same-origin',keepalive:true}).catch(function(){});
    }

    function fireMeta(trigger,target,element,forcedIds){
        if(!target||typeof window.fbq!=='function')return;
        metaMappings.forEach(function(mapping){
            if(mapping.trigger_type!==trigger||mapping.target_key!==target)return;
            var eventId=(forcedIds&&forcedIds[String(mapping.id)])||createEventId(mapping);
            var params={
                content_name:target,
                content_category:trigger,
                link_url:element&&element.href?element.href:window.location.href
            };
            window.fbq('track',mapping.event_name,params,{eventID:eventId});
            recordDispatch(mapping,eventId);
        });
    }

    function trackOtherPlatforms(element){
        if(!element)return;
        var name=element.dataset.eventName||'website_action';
        var eventName=element.dataset.metaEvent;
        var gaEvent=element.dataset.gaEvent;
        var params={
            content_name:name,
            content_category:element.dataset.eventCategory||'website',
            link_url:element.href||window.location.href
        };
        if(eventName&&window.ttq&&typeof window.ttq.track==='function')window.ttq.track(eventName,params);
        if(gaEvent&&typeof window.gtag==='function')window.gtag('event',gaEvent,{
            event_label:name,
            event_category:params.content_category,
            link_url:params.link_url
        });
    }

    fireMeta('page_view',metaPageTarget,null,null);
    if(metaPageTarget==='page_thank_you'&&Object.keys(metaServerEventIds).length){
        fireMeta('form_success','interest_form_success',null,metaServerEventIds);
    }

    document.addEventListener('click',function(event){
        var target=event.target.closest('[data-event-name]');
        if(!target||target.matches('details'))return;
        fireMeta('click',target.dataset.eventName,target,null);
        trackOtherPlatforms(target);
    });

    document.querySelectorAll('details[data-event-name]').forEach(function(detail){
        detail.addEventListener('toggle',function(){
            if(!detail.open)return;
            fireMeta('click',detail.dataset.eventName,detail,null);
            trackOtherPlatforms(detail);
        });
    });

    document.querySelectorAll('form[data-track-form]').forEach(function(form){
        form.addEventListener('submit',function(){
            fireMeta('form_submit',form.dataset.eventName,form,null);
            trackOtherPlatforms(form);
        });
    });
});
</script>
