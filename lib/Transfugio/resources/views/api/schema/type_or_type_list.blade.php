@if (is_array($property['type']))
    @foreach ($property['type'] as $type)
        @include ('transfugio::api.schema.type', compact('type'))
    @endforeach
@else
    @include ('transfugio::api.schema.type', ['type' => $property['type']])
@endif
