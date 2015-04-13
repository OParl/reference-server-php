<ul class="nav navbar-nav">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
           aria-expanded="false">Legislaturperioden<span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li ng-repeat="term in body.legislativeTerm.data">
                <a href="#">
                    @{{ term.startDate | date:dd.mm.yyyy }} – @{{ term.endDate | date:dd.mm.yyyy }}
                </a>
            </li>
        </ul>
    </li>
</ul>