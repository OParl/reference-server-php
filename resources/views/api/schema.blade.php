<h4>Kurzbeschreibung</h4>
<p>
    TODO: Beschreibung
</p>

<h4>Eigenschaften</h4>
<dl class="dl-horizontal properties">
@foreach ($schema['properties'] as $name => $property)
    <dt>
        @if (in_array($name, $schema['required']))
            <span class="text-danger" aria-label="Zwingendes Attribut">{{ $name }}</span>
        @elseif(isset($schema['oparl:recommended']) && in_array($name, $schema['oparl:recommended']))
            <span class="text-success" aria-label="Empfohlenes Attribut">{{ $name }}</span>
        @else
            {{ $name }}
        @endif
    </dt>
    <dd class="type">
        @include ('api.schema.type_or_type_list')
    </dd>
@endforeach
</dl>

<div class="well well-sm small hidden-xs">
    <h4 class="text-muted">Legende</h4>
    <ul class="list-unstyled">
        <li class="text-danger">Zwingendes Attribut</li>
        <li class="text-success">Empfohlenes Attribut</li>
    </ul>
</div>
