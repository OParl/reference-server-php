<!DOCTYPE html>
<html>
    <head>
        <title>meanderingsoul.com API - {{ $module }}</title>
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
        <h1>{{ url('/') }}/api/{{ $module  }}</h1>

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
    </body>
</html>