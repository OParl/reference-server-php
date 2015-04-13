<div class="modal fade splash" id="splash" ng-controller="SplashController">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Willkommen!</h4>
                <span>Bitte wählen sie eine Körperschaft um fortzufahren.</span>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-12" ng-repeat="body in bodies">
                            <div class="well well-lg" data-body-id="@{{ body.id }}">
                                <div class="row">
                                    <div class="col-xs-10">
                                        <h5>@{{ body.name }}</h5>
                                        <address>
                                            <small><a href="@{{ body.website }}">@{{ body.website }}</a></small>
                                        </address>
                                    </div>
                                    <div class="col-xs-2">
                                        <button ng-click="selectBody(body.id)" class="btn btn-default" type="button">Laden</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
