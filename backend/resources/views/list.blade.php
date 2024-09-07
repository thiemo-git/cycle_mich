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

        h1 {
            margin-bottom: 1rem
        }

        nav {
            display: flex;
            justify-content: flex-start;
            gap: 2rem;
            flex-wrap: wrap;
        }
        hr {
            margin: 0.5rem 0
        }

        .barcode {
            display: block;
            padding-bottom: 0.5rem;
        }
    </style>
    <title>Document</title>
</head>
<body>
    <h1>{{ $heading }}</h1>
    <nav>
        <a href="/admin/list?filter=valid">Öffentliche Barcodes</a>
        <a href="/admin/list?filter=invalid">Unvollständige Barcodes</a>
        <a href="/admin/list?filter=all">Alle Barcodes</a>
    </nav>
    <hr>
    <div class="Liste">
        @foreach ($barcodes as $barcode)
            <a href="/admin/item/{{ $barcode->id }}" class="barcode">{{ $barcode->id }}@if ($barcode->title)
                - {{ $barcode->title }}
            @endif</a>
        @endforeach
    </div>
</body>
</html>