<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        *, *::before, *::after {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            margin: 0.5rem;
        }

        h1 {
            margin-bottom: 1rem
        }

        h2 {
            margin-bottom: 0.5rem
        }

        hr {
            margin: 0.5rem 0
        }

        form {
            display: grid;
            grid-template-columns: auto auto;
        }

        .buttons {
            grid-column: 1 / span 2;
        }
    </style>
    <title>Document</title>
</head>
<body>
    <h1>Item bearbeiten</h1>
    <a href="/admin/list">Zurück</a>
    <hr>
    <h2>EAN: {{ $barcode->id }}</h2>
    <form action="/admin/item/{{ $barcode->id }}" method="POST">
        @csrf
        <label for="title">Produktname</label>
        <input id="title" name="title" type="text" value="{{ $barcode->title ? $barcode->title : '' }}">
        <label for="notes">Freitext</label>
        <textarea name="notes" id="notes" rows="10">{{ $barcode->notes ? $barcode->notes : '' }}</textarea>
        <div class="buttons">
            @foreach ($keys as $key => $value)
                <div>
                    <input type="checkbox" name="key_{{ $key }}" id="{{ $key }}" {{ $value ? 'checked' : '' }}>
                    <label for="{{ $key }}">{{ $key }}</label>
                </div>
            @endforeach
        </div>
        <input class="submit" type="submit" value="Speichern">
    </form>
    <a href="/admin/delete/{{ $barcode->id }}">Löschen</a>
</body>
</html>