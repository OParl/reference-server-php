<div style="display: none;" id="main" ng-controller="MainController">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar">
                    <span class="sr-only">Zur Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand"><span class="text-oparl">OParl</span> - Client Demo</a>
            </div>

            <div class="collapse navbar-collapse" id="main-navbar">
                <div class="navbar-left">
                    <p class="navbar-text">@{{ body.name }}</p>
                </div>

                <div class="navbar-right">
                    <button type="button" class="btn navbar-btn" ng-click="toggleBodyChange()">Körperschaft wechseln</button>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1">
                <div class="alert alert-danger">
                    Dies ist eine <strong>Demo</strong> zur Nutzung der <a href="{{ action('API\SystemController@index') }}">OParl API</a>
                    und enthält <strong>keine realen Daten</strong>!
                </div>
            </div>
        </div>

        {{-- CONTENT HERE --}}
        <div class="row">
            <div class="col-xs-12 col-md-3">
                {{-- Organizations List --}}
                @include('client.organizations')
            </div>
            <div class="col-xs-12 col-md-9">
                {{-- Detail View --}}
                @include('client.detail')
            </div>
        </div>

        <nav class="navbar navbar-inverse navbar-fixed-bottom">
            <div class="container">
                <div class="navbar-left">
                    <p class="navbar-text">
                        @{{ body.name }}
                    </p>
                </div>
                <div class="navbar-right">
                    <p class="navbar-text text-small">
                        Kontakt: <a href="@{{ body.contactEmail }}">@{{ body.contactName }}</a>
                    </p>
                </div>
            </div>
        </nav>
    </div>
</div>