<!DOCTYPE html>
<html>
    <head>
        <title>{{ config('app.url') }} API - {{ $module }}</title>
        <style>
            body, div
            {
                margin: 0;
            }

            body > div
            {
                width: 80%;
                margin: 0 auto;
                margin-top: 1.2em;
            }

            h1 {
                width: 100%;
                background: #ccc;
                margin-top: 0;
                top: 0;
                padding-left: 1.2em;
            }

            .error-message {
                padding: .6em;
                margin: 0 auto;
                max-width: 80%;
                border: 2px solid red;
                font-weight: bold;
                text-align: center;
            }
        </style>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/prism/0.0.1/prism.min.css" />
    </head>
    <body>
        <h1>[{{ $module }}]&nbsp;{{ $url  }}</h1>

        <div>
            @if ($isError)
                <div class="error-message">Ooops, something went wrong here!</div>
            @endif
            <pre><code class="language-javascript">{{ $content }}</code></pre>
        </div>

        {{--
        <div>
            <h2>Where can I go from here?</h2>
            <ul>
                @foreach ($viableRoutes as $route)
                <li>
                    <em>{{ $route[0] }}</em>:
                    <strong>{{ implode(', ', $route[1]->getMethods())  }}</strong>
                    {{ $route[1]->uri() }}
                </li>
                @endforeach
            </ul>
        </div>
        --}}

        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/prism/0.0.1/prism.min.js"></script>

        @if (env('PIWIK_URL') && env('PIWIK_SITE_ID'))
            <script type="text/javascript">
                var _paq = _paq || [];
                _paq.push(['trackPageView']);
                _paq.push(['enableLinkTracking']);

                (function() {
                    var u="//{{ env('PIWIK_URL') }}/";
                    _paq.push(['setTrackerUrl', u+'piwik.php']);
                    _paq.push(['setSiteId', {{ env('PIWIK_SITE_ID') }}]);
                    var d=document, g= d.createElement('script'), s=d.getElementsByTagName('script')[0];
                    g.type='text/javascript';g.async=true;g.defer=true;g.src=u+'piwik.js';s.parentNode.insertBefore(g,s);
                })();
            </script>
            <noscript><img src="//{{ env('PIWIK_URL') }}/piwik.php?idsite={{ env('PIWIK_SITE_ID') }}" style="border: 0;" alt="" /></noscript>
        @endif
    </body>
</html>