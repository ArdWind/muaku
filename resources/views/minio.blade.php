<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <form action="{{ route('minio.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="">Masukan Gambar</label>
        <input type="file" name="berkas" id="">
        <button type="submit">Kirim</button>
    </form>
</body>

</html>
