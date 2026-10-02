<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kegiatan</title>
</head>
<body>

    <h1>Tambah Kegiatan</h1>

        <form
        action="{{ route('activities.store') }}"
        method="POST"
        enctype="multipart/form-data"
>
        @csrf

        @include('activities._form')

        <button type="submit">Simpan</button>
    </form>

    <a href="{{ route('activities.index') }}">Kembali</a>

</body>
</html>