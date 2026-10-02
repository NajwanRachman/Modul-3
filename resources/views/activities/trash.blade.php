<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Trash Kegiatan</title>

    @vite(['resources/css/activities.css'])
</head>

<body>

<div class="container">

    <div class="page-header">
        <h1>Trash Kegiatan</h1>
        <p>Daftar kegiatan yang telah dihapus sementara.</p>
    </div>

    @if (session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    <div style="margin-bottom: 20px;">

        <a
            href="{{ route('activities.index') }}"
            class="btn btn-secondary"
        >
            ← Kembali ke Daftar
        </a>

    </div>

    @if ($activities->count())

        <div class="activity-list">

            @foreach ($activities as $activity)

                <article class="activity-card">

                    <h2>
                        {{ $activity->title }}
                    </h2>

                    <p>
                        <strong>Kode:</strong>
                        {{ $activity->code }}
                    </p>

                    <p>
                        <strong>Kategori:</strong>
                        {{ $activity->category?->name ?? '-' }}
                    </p>

                    <p>
                        <strong>Dihapus pada:</strong>
                        {{ $activity->deleted_at?->format('d-m-Y H:i') }}
                    </p>

                    <div class="activity-actions">

                        <form
                            action="{{ route('activities.restore', $activity->id) }}"
                            method="POST"
                        >

                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                class="btn btn-success"
                            >
                                Restore
                            </button>

                        </form>

                    </div>

                </article>

            @endforeach

        </div>

    @else

        <div class="activity-card">

            <p>
                Tidak ada kegiatan yang berada di Trash.
            </p>

        </div>

    @endif

</div>

</body>
</html>