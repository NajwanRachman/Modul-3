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

            <a href="{{ route('activities.edit', $activity) }}">Edit</a>

            <p>{{ $activity->description }}</p>
            <p>Tanggal: {{ $activity->activity_date }}</p>
            <p>Kategori: {{ $activity->category }}</p>
            <p>Status: {{ $activity->status }}</p>
        <form
            action="{{ route('activities.destroy', $activity) }}"
            method="POST"
            onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')"
        >
            @csrf
            @method('DELETE')

            <button type="submit">Hapus</button>
        </form>
        </article>

        <form method="GET" action="{{ route('activities.index') }}">
    <label for="status">Filter Status:</label>

    <select name="status" id="status" onchange="this.form.submit()">
        <option value="">Semua</option>
        <option value="Planned" {{ $status === 'Planned' ? 'selected' : '' }}>
            Planned
        </option>
        <option value="Ongoing" {{ $status === 'Ongoing' ? 'selected' : '' }}>
            Ongoing
        </option>
        <option value="Done" {{ $status === 'Done' ? 'selected' : '' }}>
            Done
        </option>
    </select>
</form>

        <hr>
    @endforeach
</body>
</html>