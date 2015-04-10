<!DOCTYPE html>
<html ng-app="opc">
    <head>
        <title>OParl Client</title>

        <link rel="stylesheet" href="{{ asset('css/client.css') }}" />

        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    </head>
    <body>
        @include('client.splash')
        @include('client.main')

        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.js"></script>
        <script src="{{ asset('js/client.js') }}"></script>
        @include('common.piwik')
    </body>
</html>