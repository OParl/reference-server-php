<!DOCTYPE html>
<html>
    <head>
        <title>OParl API - {{ $module }}</title>
        <link rel="stylesheet" href="{{ asset('css/api.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/prism.css') }}" />

        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    </head>
    <body>

        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-header">
                        <h1><span class="text-oparl">OParl.</span> – API<small>Demo</small></h1>
                    </div>
                </div>
            </div>
            @if ($isError)
                <div class="row">
                    <div class="col-xs-8 col-xs-offset-2">
                        <div class="alert alert-danger">Ooops, something went wrong here!</div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-xs-12 col-md-4">
                    @include('api.sidebar')
                </div>
                <div class="col-xs-12 col-md-8">
                    @include('api.main')
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <hr />
                    <div class="text-center">
                        {!! $paginationCode or '' !!}
                    </div>
                </div>
            </div>
        </div>

        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.js"></script>
        <script src="{{ asset('js/api.js') }}"></script>

        @include('common.piwik')
    </body>
</html>
