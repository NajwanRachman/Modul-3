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
    <label for="activity_date">Tanggal</label>
    <input
        type="date"
        id="activity_date"
        name="activity_date"
        value="{{ old('activity_date', $activity->activity_date ?? '') }}"
    >

    @error('activity_date')
        <div>{{ $message }}</div>
    @enderror
</div>

<div>
    <label for="category">Kategori</label>
    <input
        type="text"
        id="category"
        name="category"
        value="{{ old('category', $activity->category ?? '') }}"
    >

    @error('category')
        <div>{{ $message }}</div>
    @enderror
</div>

<div>
    <label for="status">Status</label>
    <select id="status" name="status">
        @foreach (['Planned', 'Ongoing', 'Done'] as $status)
            <option
                value="{{ $status }}"
                @selected(old('status', $activity->status ?? '') === $status)
            >
                {{ $status }}
            </option>
        @endforeach
    </select>

    @error('status')
        <div>{{ $message }}</div>
    @enderror
</div>