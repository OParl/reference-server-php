@if (env('PIWIK_URL') && env('PIWIK_SITE_ID'))
    <script type="text/javascript">
        var _paq = _paq || [];
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function() {
            var u="//{{ env('PIWIK_URL') }}/";
            _paq.push(['setTrackerUrl', u+'piwik.php']);
            _paq.push(['setSiteId', {{ env('PIWIK_SITE_ID') }}]);
            var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
            g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
        })();
    </script>
    <noscript>
        <img src="//{{ env('PIWIK_URL') }}/piwik.php?idsite={{ env('PIWIK_SITE_ID') }}" style="border:0;" alt="" />
    </noscript>
@endif