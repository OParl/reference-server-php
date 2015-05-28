<div class="panel panel-default">
    <div class="panel-heading">
        <h3>{{ $module }}</h3>
    </div>

    <div class="panel-body {{ strtolower($module) }} {{ $collectionClass }}" id="oparl-documentation">
        {{-- FIXME: The workaround to check for schema information should not be necessary once the complete schema is available. --}}
        @if (!is_null($schema))
            @include ('api.schema')
        @else
            TODO: Spezifikation
        @endif
    </div>

    <div class="panel-footer">
        Mehr Informationen gibt es unter <a href="//oparl.org/spezifikation/">http://oparl.org/spezifikation/</a>.
    </div>
</div>
