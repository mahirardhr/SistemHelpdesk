@extends('template.master')

@section('content')
<div class="container-fluid">
    <h2 class="mb-2 font-weight-bold" style="font-size: 25px;">Daftar Pengguna</h2>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <form method="GET" action="{{ route('users.index') }}">
        <div class="row mb-2 align-items-center">
            <div class="col-md-6 text-left">
                <a href="{{ route('users.create') }}" class="btn btn-primary">
                    Tambah Pengguna
                </a>
            </div>
            <div class="col-md-4 offset-md-2">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama, email, atau No. SAP" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <table class="table table-bordered table-striped ">
        <thead class="thead-dark">
            <tr class="text-center">
                <th>No</th>
                <th>No. SAP</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>No. HP</th>
                <th>Departemen</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
            <tr>
                <td class="text-center">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                <td>{{ $user->no_sap }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td><span class="badge badge-secondary">{{ ucfirst($user->role) }}</span></td>
                <td>{{ $user->no_hp }}</td>
                <td>{{ $user->departemen->nama_departemen ?? '-' }}</td>
                <td class="text-center">
                    <div class="d-inline-flex gap-1">
                        {{-- Tombol Edit --}}
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        {{-- Tombol Hapus --}}
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada pengguna</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-end">
        {{ $users->withQueryString()->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection