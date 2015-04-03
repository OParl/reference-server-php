<html>
    <head>
        <title>{{ $meeting->organization->body->name }} - {{ $meeting->organization->name }}</title>
        <style type="text/css">
            .header
            {
                font-size: x-large;
            }

            .p1
            {
                text-align: center;
                font-size: large;
                font-weight: bold;
                letter-spacing: 0.6em;
                margin-bottom: 2em;
                text-decoration: underline;
            }

            .p2
            {
                width: 70%;
                text-align: justify;
            }
        </style>
    </head>
    <body>
        <div class="header">
            {{ $meeting->organization->body->name }} - {{ $meeting->organization->name }}
        </div>

        <p class="p1">Einladung</p>

        <p class="p2">
             Hiermit lade ich Sie zu einem Treffen des <strong>{{ $meeting->organization->name }}</strong>
             am <strong>{{ $meeting->start_date->format('l, d F Y') }}</strong> ein.
        </p>

        <hr />

        <table>
            <tr>
                <td><strong>Sitzungstermin:</strong></td>
                <td>{{ $meeting->start_date->format('l, d F Y \u\m H:i') }}</td>
            </tr>
            @if ($meeting->locality)
            <tr>
                <td><strong>Ort, Raum:</strong></td>
                <td>{{ $meeting->locality }}</td>
            </tr>
            @endif
            <tr>
                <td><strong>Beteiligte:</strong></td>
                <td class="participants">
                    {!! implode(', ', $meeting->participants->lists('name')) !!}
                </td>
            </tr>
        </table>

        <hr />

        <h3>Tagesordnung:</h3>

        <ol>
            @foreach ($meeting->agendaItems->sortBy('order') as $agendaItem)
                <li>[{{$agendaItem->consecutive_number}}] {{ $agendaItem->name }}</li>
            @endforeach
        </ol>

        <p class="p2">
            Mit freundlichen Grüßen,<br />
            <br />
            {{ $meeting->chair->name }}
        </p>
    </body>
</html>