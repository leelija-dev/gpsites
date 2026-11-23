@php
    $gtmId = config('gpsites.gtm_id');
    $gtmEnabled = $gtmId && ! app()->environment(['local', 'testing']);
@endphp
@if ($gtmEnabled)
<!-- Google Tag Manager -->
<script>
window.dataLayer = window.dataLayer || [];
(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','{{ $gtmId }}');
</script>
<!-- End Google Tag Manager -->
<script>
/*
 * GPSites conversion events for Google Tag Manager / GA4.
 * Forms marked with data-gtm-event push that event to the dataLayer when submitted.
 * Read-only: this never stops, delays or changes a form submission.
 */
(function () {
    document.addEventListener('submit', function (e) {
        try {
            var form = e.target;
            if (!form || !form.getAttribute) return;
            var name = form.getAttribute('data-gtm-event');
            if (!name) return;
            // Runs after the form's own validation; skip submissions that validation blocked.
            if (e.defaultPrevented) return;
            var payload = { event: name, form_id: form.id || undefined, page_path: location.pathname };
            Array.prototype.forEach.call(form.attributes, function (a) {
                if (a.name.indexOf('data-gtm-') === 0 && a.name !== 'data-gtm-event') {
                    payload[a.name.slice(9).replace(/-/g, '_')] = a.value;
                }
            });
            if (payload.value !== undefined) payload.value = parseFloat(payload.value) || 0;
            window.dataLayer.push(payload);
        } catch (err) { /* tracking must never break the page */ }
    });
})();
</script>
@endif
