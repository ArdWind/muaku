@extends('layout.master')

@section('data')
<div class="container mt-4">
    <a href="{{ route('data-users.create') }}" class="btn btn-primary mb-2">Tambah User</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th><th>Email</th><th>Role</th><th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td><td>{{ $user->email }}</td><td>{{ $user->role }}</td>
                <td>
                    <a href="{{ route('data-users.edit', $user) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('data-users.destroy', $user) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
