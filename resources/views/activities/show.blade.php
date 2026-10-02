<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $activity->title }}</title>
</head>
<body>
    <h1>{{ $activity->title }}</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    @endif

    <p><strong>Kode:</strong> {{ $activity->code }}</p>

    <p>
        <strong>Kategori:</strong>
        {{ $activity->category?->name ?? 'Tidak ada kategori' }}
    </p>

    <p>
        <strong>Deskripsi:</strong>
        {{ $activity->description ?? '-' }}
    </p>

    <p>
        <strong>Mulai:</strong>
        {{ $activity->start_at?->format('d-m-Y H:i') ?? '-' }}
    </p>

    <p>
        <strong>Selesai:</strong>
        {{ $activity->end_at?->format('d-m-Y H:i') ?? '-' }}
    </p>

    <p>
        <strong>Lokasi:</strong>
        {{ $activity->location ?? '-' }}
    </p>

    <p>
        <strong>Kapasitas:</strong>
        {{ $activity->capacity ?? '-' }}
    </p>

    <p>
        <strong>Status:</strong>
        {{ $activity->status }}
    </p>

    @if ($activity->status === 'draft')
        <form
            action="{{ route('activities.publish', $activity) }}"
            method="POST"
        >
            @csrf
            <button type="submit">
                Publish
            </button>
        </form>
    @endif

    @if ($activity->status === 'published')
        <form
            action="{{ route('activities.complete', $activity) }}"
            method="POST"
        >
            @csrf
            <button type="submit">
                Complete
            </button>
        </form>
    @endif

    <br>

    <a href="{{ route('activities.edit', $activity) }}">
        Edit
    </a>

    <br>

    <a href="{{ route('activities.index') }}">
        Kembali ke daftar
    </a>
</body>
</html>