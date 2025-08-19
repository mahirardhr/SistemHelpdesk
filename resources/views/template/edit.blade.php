@extends('template.master')

@section('content')
<div class="container">
    <h3>Edit Pengguna</h3>
    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <!-- Input Nama -->
        <div class="form-group">
            <label for="name">Nama</label>
            <input name="name" id="name" type="text" class="form-control" value="{{ $user->name }}" required>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">Email</label>
            <input name="email" id="email" type="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <!-- No SAP -->
        <div class="form-group">
            <label for="no_sap">No SAP</label>
            <input name="no_sap" id="no_sap" type="text" class="form-control" value="{{ $user->no_sap }}">
        </div>

        <!-- No HP -->
        <div class="form-group">
            <label for="no_hp">No HP</label>
            <input name="no_hp" id="no_hp" type="text" class="form-control" value="{{ $user->no_hp }}">
        </div>

        <!-- Departemen -->
        <select name="departemen_id" id="departemen_id" class="form-control select2" required>
            <option value="" disabled>-- Pilih Departemen --</option>
            @foreach ($departemens as $dept)
            <option value="{{ $dept->id }}" {{ $user->departemen_id == $dept->id ? 'selected' : '' }}>
                {{ $dept->nama_departemen }}
            </option>
            @endforeach
        </select>

        <!-- Role -->
        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="asisten" {{ $user->role == 'asisten' ? 'selected' : '' }}>Asisten TI</option>
                <option value="krani" {{ $user->role == 'krani' ? 'selected' : '' }}>Krani TI</option>
                <option value="pelapor" {{ $user->role == 'pelapor' ? 'selected' : '' }}>Pelapor</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

@section('scripts')
<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Styling Select2 biar nyatu -->
<style>
    .select2-container--default .select2-selection--single {
        height: 38px !important;
        padding: 6px 12px;
        border: 1px solid #ced4da;
        border-radius: 4px;
    }

    .select2-container {
        width: 100% !important;
    }
</style>

<script>
    $(document).ready(function() {
        $('#departemen').select2({
            placeholder: "-- Pilih Departemen --",
            allowClear: true,
            width: 'resolve'
        });
    });
</script>
@endsection