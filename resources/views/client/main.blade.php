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
                <a class="navbar-brand">BodyName</a>
            </div>

            <div class="collapse navbar-collapse" id="main-navbar">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Übersicht</a></li>
                    <li><a href="#">Mitglieder</a></li>
                    <li><a href="#">Ausschüsse</a></li>
                </ul>
                <div class="navbar-right">
                    <button type="button" class="btn navbar-btn" ng-click="toggleBodyChange()">Körperschaft wechseln</button>
                </div>
            </div>
        </div>
    </nav>
</div>