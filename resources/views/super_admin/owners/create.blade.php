<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pemilik Coffee Shop</title>
</head>
<body>
    <h1>Tambah Pemilik Coffee Shop</h1>

    @if ($errors->any())
        <ul style="color:red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('super.owners.store') }}" method="POST">
        @csrf

        <div style="margin-bottom:10px;">
            <label>Nama</label><br>
            <input type="text" name="name" value="{{ old('name') }}">
        </div>

        <div style="margin-bottom:10px;">
            <label>Email</label><br>
            <input type="email" name="email" value="{{ old('email') }}">
        </div>

        <div style="margin-bottom:10px;">
            <label>Password</label><br>
            <input type="password" name="password">
        </div>

        <button type="submit">Simpan</button>
    </form>

    <p style="margin-top:15px;">
        <a href="{{ route('super.owners.index') }}">⬅ Kembali ke daftar pemilik</a>
    </p>
</body>
</html>
