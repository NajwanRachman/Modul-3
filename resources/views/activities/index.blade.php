<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Daftar Kegiatan</title>

    @vite(['resources/css/activities.css'])
</head>

<body>

<div class="container">

    <div class="page-header">
        <h1>Daftar Kegiatan</h1>
        <p>Kelola kegiatan, kategori, status, dan informasi aktivitas.</p>
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

    <div style="margin-bottom: 20px;">
        <a href="{{ route('activities.create') }}" class="btn btn-primary">
    + Tambah Kegiatan
    </a>

    <a href="{{ route('activities.trash') }}" class="btn btn-secondary">
    🗑 Trash
    </a>
    </div>

    <div class="filter-card">

        <form method="GET" action="{{ route('activities.index') }}">

            <div class="filter-grid">

                <div class="field">
                    <label for="search">Cari Kode / Judul</label>

                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Masukkan kode atau judul"
                    >
                </div>

                <div class="field">
                    <label for="category_id">Kategori</label>

                    <select name="category_id" id="category_id">

                        <option value="">
                            Semua kategori
                        </option>

                        @foreach ($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                @selected((string) $categoryId === (string) $category->id)
                            >
                                {{ $category->name }}
                            </option>

                        @endforeach

                    </select>
                </div>

                <div class="field">
                    <label for="status">Status</label>

                    <select name="status" id="status">

                        <option value="">
                            Semua status
                        </option>

                        @foreach (\App\Models\Activity::STATUSES as $activityStatus)

                            <option
                                value="{{ $activityStatus }}"
                                @selected($status === $activityStatus)
                            >
                                {{ ucfirst($activityStatus) }}
                            </option>

                        @endforeach

                    </select>
                </div>

                <div class="field">
                    <label for="sort">Urutan</label>

                    <select name="sort" id="sort">

                        <option
                            value="newest"
                            @selected($sort === 'newest')
                        >
                            Terbaru
                        </option>

                        <option
                            value="oldest"
                            @selected($sort === 'oldest')
                        >
                            Terlama
                        </option>

                    </select>
                </div>

                <div class="field">
                    <label>&nbsp;</label>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Terapkan
                    </button>
                </div>

            </div>

            <div style="margin-top: 12px;">
                <a href="{{ route('activities.index') }}">
                    Reset Filter
                </a>
            </div>

        </form>

    </div>

    @if ($activities->count())

        <div class="activity-list">

            @foreach ($activities as $activity)

                <article class="activity-card">

                    <h2>
                        <a href="{{ route('activities.show', $activity) }}">
                            {{ $activity->title }}
                        </a>
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
                        <strong>Mulai:</strong>
                        {{ $activity->start_at?->format('d-m-Y H:i') ?? '-' }}
                    </p>

                    <p>
                        <strong>Status:</strong>

                        <span class="status status-{{ $activity->status }}">
                            {{ ucfirst($activity->status) }}
                        </span>
                    </p>

                    <div class="activity-actions">

                        <a
                            href="{{ route('activities.show', $activity) }}"
                            class="btn btn-primary"
                        >
                            Detail
                        </a>

                        <a
                            href="{{ route('activities.edit', $activity) }}"
                            class="btn btn-secondary"
                        >
                            Edit
                        </a>

                        <form
                            action="{{ route('activities.destroy', $activity) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')"
                        >

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger"
                            >
                                Hapus
                            </button>

                        </form>

                    </div>

                </article>

            @endforeach

        </div>

    @else

        <div class="activity-card">

            <p>
                Tidak ada kegiatan yang sesuai dengan filter.
            </p>

        </div>

    @endif

    <div class="pagination">
        {{ $activities->links() }}
    </div>

    <p class="result-info">
        Menampilkan
        {{ $activities->firstItem() ?? 0 }}
        sampai
        {{ $activities->lastItem() ?? 0 }}
        dari
        {{ $activities->total() }}
        kegiatan.
    </p>

</div>

</body>
</html>