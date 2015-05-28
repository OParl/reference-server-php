@if (isset($property['format']) || isset($property['items']['format']))
    <div>
        Format:
        <span>
            @if (isset($property['format']))
                {{ $property['format'] }}
            @elseif (isset($property['items']['format']))
                {{ $property['items']['format'] }}
            @endif
        </span>
    </div>
@endif