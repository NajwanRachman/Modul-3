<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $activity->title }}</title>

    @vite(['resources/css/activities.css'])
</head>

<body>

<div class="container">

    <div class="page-header">
        <h1>{{ $activity->title }}</h1>
        <p>Detail kegiatan</p>
    </div>

    @if (session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="activity-card">

        <p>
            <strong>Kode:</strong>
            {{ $activity->code }}
        </p>

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
            <strong>Terdaftar:</strong>
            {{ $activity->registered_count ?? 0 }}
        </p>

        <p>
            <strong>Status:</strong>
            <span class="status status-{{ $activity->status }}">
                {{ ucfirst($activity->status) }}
            </span>
        </p>

    </div>

    @if ($activity->poster_path)
    <div class="activity-card">
        <h2>Poster Kegiatan</h2>

        <img
            src="{{ asset('storage/' . $activity->poster_path) }}"
            alt="Poster {{ $activity->title }}"
            style="max-width: 500px; width: 100%; height: auto;"
        >
    </div>
    @endif


    @if ($activity->status === 'published')

        <div class="filter-card">

            <h2>Daftar Kegiatan</h2>

            <form
                action="{{ route('activities.registrations.store', $activity) }}"
                method="POST"
            >
                @csrf

                <div class="field">
                    <label for="participant_name">
                        Nama Peserta
                    </label>

                    <input
                        type="text"
                        id="participant_name"
                        name="participant_name"
                        value="{{ old('participant_name') }}"
                        required
                    >

                    @error('participant_name')
                        <small>{{ $message }}</small>
                    @enderror
                </div>

                <br>

                <div class="field">
                    <label for="email">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                    >

                    @error('email')
                        <small>{{ $message }}</small>
                    @enderror
                </div>

                <br>

                <button type="submit" class="btn btn-primary">
                    Daftar
                </button>

            </form>

        </div>

    @endif


    @if ($activity->status === 'draft')

        <div class="activity-actions">

            <form
                action="{{ route('activities.publish', $activity) }}"
                method="POST"
            >
                @csrf

                <button type="submit" class="btn btn-primary">
                    Publish
                </button>
            </form>

        </div>

    @endif


    @if ($activity->status === 'published')

        <div class="activity-actions">

            <form
                action="{{ route('activities.complete', $activity) }}"
                method="POST"
            >
                @csrf

                <button type="submit" class="btn btn-success">
                    Complete
                </button>
            </form>

        </div>

    @endif


    <div class="activity-actions">

        <a
            href="{{ route('activities.edit', $activity) }}"
            class="btn btn-secondary"
        >
            Edit
        </a>

        <a
            href="{{ route('activities.index') }}"
            class="btn btn-secondary"
        >
            Kembali ke daftar
        </a>

    </div>

</div>

</body>
</html>