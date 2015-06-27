<!DOCTYPE html>
<html>
    <head>
        <title>Drucksache {{ $name }}</title>
    </head>
    <body>
        <h1>Drucksache {{ $name }}</h1>

        @foreach ($text as $paragraph)
            <p>
                {{ $paragraph }}
            </p>
        @endforeach
    </body>
</html>