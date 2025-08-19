@extends('template.master')

@section('content')
<div class="container mt-4">
    <h3>Detail Pengguna</h3>
    <ul class="list-group">
        <li class="list-group-item"><strong>Nama:</strong> {{ $user->name }}</li>
        <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
        <li class="list-group-item"><strong>Role:</strong> {{ $user->role ?? '-' }}</li>
        <li class="list-group-item"><strong>Dibuat pada:</strong> {{ $user->created_at }}</li>
    </ul>
</div>
@endsection
