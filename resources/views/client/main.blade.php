<div style="display: none;" id="main" ng-controller="MainController">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar">
                    <span class="sr-only">Zur Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand">OParl Demo</a>
            </div>

            <div class="collapse navbar-collapse" id="main-navbar">
                <div class="navbar-right">
                    <button type="button" class="btn navbar-btn" ng-click="toggleBodyChange()">Körperschaft wechseln</button>
                </div>
            </div>
        </div>
    </nav>

    <h1>@{{ body.name }}</h1>

    <div role="tabpanel">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#overview" aria-controls="overview" role="tab" data-toggle="tab">Übersicht</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="overview">

            </div>
        </div>

    </div>
</div>