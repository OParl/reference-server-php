@if (is_array($property['type']))
    @foreach ($property['type'] as $type)
        @include ('api.schema.type', compact('type'))
    @endforeach
@else
    @include ('api.schema.type', ['type' => $property['type']])
@endif
