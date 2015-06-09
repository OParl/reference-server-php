@if (isset($property['format']) || isset($property['items']['format']))
    <div>
        Format:
        <samp>
            @if (isset($property['format']))
                {{ $property['format'] }}
            @elseif (isset($property['items']['format']))
                {{ $property['items']['format'] }}
            @endif
        </samp>
    </div>
@endif