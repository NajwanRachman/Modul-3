<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Activities</title>
</head>
<body>
    <h1>Daftar Kegiatan</h1>

    @foreach ($activities as $activity)
        <article>
            <h2>
                <a href="{{ route('activities.show', $activity) }}">
                    {{ $activity->title }}
                </a>
            </h2>

            <p>{{ $activity->description }}</p>
            <p>Tanggal: {{ $activity->activity_date }}</p>
            <p>Kategori: {{ $activity->category }}</p>
            <p>Status: {{ $activity->status }}</p>
        </article>

        <hr>
    @endforeach
</body>
</html>