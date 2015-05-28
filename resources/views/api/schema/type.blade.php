<span><samp>
@if ($type !== "array")
    {{ $type }}
@else
    array of {{ $property['items']['type'] }}
@endif
</samp></span>