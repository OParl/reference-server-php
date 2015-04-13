<div class="list-group" ng-controller="OrganizationController">
    <a href="#" class="list-group-item" ng-repeat="organization in body.organization.data">
        <h4 class="list-group-item-heading">@{{ organization.name }}</h4>
        <p class="list-group-item-text">
            <span class="text-muted">@{{ organization.startDate }}</span>
        </p>
    </a>
</div>
