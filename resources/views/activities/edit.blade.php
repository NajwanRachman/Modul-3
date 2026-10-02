<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kegiatan</title>
</head>
<body>

    <h1>Edit Kegiatan</h1>

        <form
        action="{{ route('activities.update', $activity) }}"
        method="POST"
        enctype="multipart/form-data"
        >
        @csrf
        @method('PUT')

        @include('activities._form')

        <button type="submit">Simpan Perubahan</button>
    </form>

    <a href="{{ route('activities.show', $activity) }}">Batal</a>

</body>
</html>