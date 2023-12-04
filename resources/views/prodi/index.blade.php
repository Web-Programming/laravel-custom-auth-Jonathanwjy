<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">`
</head>
<body>



<div class="row pt-4">
    <div class="col">
        <h2>Prodi</h2>
        <div class="d-md-flex justify-content-md-end">
            <a href="{{ route('prodi.create') }}" class="btn btn-primary">Tambah</a>
        </div>
        <table class="table table-stripped table-hover">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prodis as $item)
                <tr>
                    <td>
                        <img src="{{ asset('storage/' .$item->foto) }}" width="100px" alt="">
                    </td>
                    <td>{{ $item->nama}}</td>
                    <td>
                        <form action="{{ route('prodi.destroy', ['prodi' => $item->id ]) }}"
                            method="POST">
                            @method('DELETE')
                            @csrf
                            <a href="{{ url('/prodi/' .$item->id) }}" class="btn btn-warning">Detail</a>
                            @can('update', $item)
                                
                            <a href="{{ url('prodi/' .$item->id. '/edit') }}" class="btn btn-info">Ubah</a>
                            @endcan
                            @can('delete', $item)
                            <button type="submit" class="btn btn-danger">Hapus</button>
                            @endcan
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
