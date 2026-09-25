<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $activity->title }}</title>
</head>
<body>
    <h1>{{ $activity->title }}</h1>

    <p>{{ $activity->description }}</p>
    <p>Tanggal: {{ $activity->activity_date }}</p>
    <p>Kategori: {{ $activity->category }}</p>
    <p>Status: {{ $activity->status }}</p>

    <a href="{{ route('activities.index') }}">
        Kembali ke daftar
    </a>
</body>
</html>