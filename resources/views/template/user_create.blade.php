@extends('template.master')

@section('content')
<div class="container-fluid">
    <h2 class="mb-2 font-weight-bold" style="font-size: xx-large;">Tambah Pengguna</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Nama</label>
                <input name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="form-group col-md-6">
                <label>Email</label>
                <input name="email" type="email" class="form-control" value="{{ old('email') }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Password</label>
                <input name="password" type="password" class="form-control" required>
            </div>

            <div class="form-group col-md-6">
                <label>No. SAP</label>
                <input name="no_sap" class="form-control" value="{{ old('no_sap') }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label>No. HP</label>
                <input name="no_hp" class="form-control" value="{{ old('no_hp') }}" required>
            </div>

            <div class="form-group col-md-6">
                <label>Departemen</label>
                <select name="departemen" id="departemen" class="form-control select2" required>
                    <option value="" disabled selected>-- Pilih Departemen --</option>
                    @foreach ($departemens as $dept)
                    <option value="{{ $dept->id }}" {{ old('departemen') == $dept->id ? 'selected' : '' }}>
                        {{ $dept->nama_departemen }}
                    </option>
                    @endforeach
                </select>
                @error('departemen') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

        </div>

        <div class="form-group">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="">-- Pilih Role --</option>
                <option value="asisten" {{ old('role') == 'asisten' ? 'selected' : '' }}>Asisten TI</option>
                <option value="krani" {{ old('role') == 'krani' ? 'selected' : '' }}>Krani TI</option>
                <option value="pelapor" {{ old('role') == 'pelapor' ? 'selected' : '' }}>Pelapor</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
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