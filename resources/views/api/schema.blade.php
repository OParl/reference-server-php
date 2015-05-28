<h4>Kurzbeschreibung</h4>
<p>
    TODO: Beschreibung
</p>

<h4>Eigenschaften</h4>
<dl class="properties">
@foreach ($schema['properties'] as $name => $property)
    <dt>
        @if (in_array($name, $schema['required']))
            <span class="text-danger" aria-label="Zwingende Eigenschaft">{{ $name }}</span>
        @elseif(isset($schema['oparl:recommended']) && in_array($name, $schema['oparl:recommended']))
            <span class="text-success" aria-label="Empfohlene Eigenschaft">{{ $name }}</span>
        @else
            {{ $name }}
        @endif
    </dt>
    <dd>
        <div class="row">
            <div class="col-md-offset-2 col-md-10">
                <div class="type">
                    JSON-Datentyp: @include ('api.schema.type_or_type_list')
                </div>
                @include('api.schema.format')

                @if (isset($property['description']))
                    <p class="text-muted small">
                        {{ $property['description'] }}
                    </p>
                @endif
            </div>
        </div>
    </dd>
@endforeach
</dl>

<div class="well well-sm small hidden-xs">
    <h4 class="text-muted">Legende</h4>
    <ul class="list-unstyled">
        <li class="text-danger">Zwingende Eigenschaft</li>
        <li class="text-success">Empfohlene Eigenschaft</li>
    </ul>
</div>
