@if ($type !== "array")
    <span>{{ $type }}</span>
@else
    <span>array of {{ $property['items']['type'] }}</span>
@endif
