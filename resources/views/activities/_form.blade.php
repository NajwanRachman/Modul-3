
<div>
    <label for="category_id">Kategori</label>
    <select id="category_id" name="category_id">
        <option value="">-- Pilih Kategori --</option>

        @foreach (\App\Models\Category::orderBy('name')->get() as $category)
            <option
                value="{{ $category->id }}"
                @selected(
                    (string) old(
                        'category_id',
                        $activity->category_id ?? ''
                    ) === (string) $category->id
                )
            >
                {{ $category->name }}
            </option>
        @endforeach
    </select>

    @error('category_id')
        <div>{{ $message }}</div>
    @enderror
</div>

<div>
    <label for="code">Kode Kegiatan</label>
    <input
        type="text"
        id="code"
        name="code"
        value="{{ old('code', $activity->code ?? '') }}"
    >

    @error('code')
        <div>{{ $message }}</div>
    @enderror
</div>

<div>
    <label for="title">Judul</label>
    <input
        type="text"
        id="title"
        name="title"
        value="{{ old('title', $activity->title ?? '') }}"
    >

    @error('title')
        <div>{{ $message }}</div>
    @enderror
</div>

<div>
    <label for="description">Deskripsi</label>
    <textarea
        id="description"
        name="description"
    >{{ old('description', $activity->description ?? '') }}</textarea>

    @error('description')
        <div>{{ $message }}</div>
    @enderror
</div>

<div>
    <label for="start_at">Mulai</label>
    <input
        type="datetime-local"
        id="start_at"
        name="start_at"
        value="{{ old(
            'start_at',
            isset($activity->start_at)
                ? $activity->start_at->format('Y-m-d\TH:i')
                : ''
        ) }}"
    >

    @error('start_at')
        <div>{{ $message }}</div>
    @enderror
</div>

<div>
    <label for="end_at">Selesai</label>
    <input
        type="datetime-local"
        id="end_at"
        name="end_at"
        value="{{ old(
            'end_at',
            isset($activity->end_at)
                ? $activity->end_at->format('Y-m-d\TH:i')
                : ''
        ) }}"
    >

    @error('end_at')
        <div>{{ $message }}</div>
    @enderror
</div>

<div>
    <label for="location">Lokasi</label>
    <input
        type="text"
        id="location"
        name="location"
        value="{{ old('location', $activity->location ?? '') }}"
    >

    @error('location')
        <div>{{ $message }}</div>
    @enderror
</div>

<div>
    <label for="capacity">Kapasitas</label>
    <input
        type="number"
        id="capacity"
        name="capacity"
        min="1"
        max="500"
        value="{{ old('capacity', $activity->capacity ?? '') }}"
    >

    @error('capacity')
        <div>{{ $message }}</div>
    @enderror
</div>

<div class="field">
    <label for="poster">Poster Kegiatan</label>
    <input
        type="file"
        id="poster"
        name="poster"
        accept="image/*"
    >

    @error('poster')
        <small>{{ $message }}</small>
    @enderror
</div>
