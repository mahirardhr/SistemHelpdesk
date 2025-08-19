<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register - Sistem Helpdesk</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- jQuery (wajib untuk Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        /* Styling tambahan agar select2 enak dilihat */
        .select2-container--default .select2-selection--single {
            height: 38px;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            color: #333;
            background-color: #fff;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 24px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
            right: 10px;
        }

        .select2-container .select2-dropdown {
            color: #333;
            background-color: #fff;
        }
    </style>
    <style>
        body {
            background-color: #f7f7f7;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-box {
            width: 100%;
            max-width: 500px;
            padding: 30px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .register-title {
            margin-bottom: 30px;
        }

        .form-group small {
            color: red;
        }

        /* Warna teks pilihan */
        .select2-container--default .select2-selection--single {
            color: #333 !important;
            /* warna teks */
            background-color: #fff !important;
            /* latar belakang */
            border: 1px solid #ccc !important;
            /* border agar jelas */
        }
    </style>
    <link rel="icon" href="{{ asset('dist/img/Logo_PTPN4.png') }}" type="image/png">
</head>

<body>
    <div class="register-box">
        <h3 class="text-center register-title"><b>Registrasi Pengguna</b></h3>
        <hr />

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('register') }}" method="POST" novalidate>
            @csrf

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" value="{{ old('name') }}" required />
                @error('name') <small>{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required />
                @error('email') <small>{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>No. SAP</label>
                <input type="text" name="no_sap" class="form-control" placeholder="No. SAP" value="{{ old('no_sap') }}" required />
                @error('no_sap') <small>{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>No. HP</label>
                <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx" value="{{ old('no_hp') }}" required />
                @error('no_hp') <small>{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Departemen</label>
                <select name="departemen" id="departemen" class="form-control" required>
                    <option value="" disabled selected>-- Pilih Departemen --</option>
                    @foreach ($departemens as $dept)
                    <option value="{{ $dept->id }}" {{ old('departemen') == $dept->id ? 'selected' : '' }}>
                        {{ $dept->nama_departemen }}
                    </option>
                    @endforeach
                </select>
                @error('departemen') <small>{{ $message }}</small> @enderror
            </div>


            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password" required />
                @error('password') <small>{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi Password" required />
            </div>

            <button type="submit" class="btn btn-primary btn-block">Daftar</button>
        </form>

        <hr />

        <div class="text-center">
            <a href="{{ route('login') }}" class="btn btn-default">Kembali ke Login</a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#departemen').select2({
                placeholder: "-- Pilih Departemen --",
                allowClear: true,
                width: '100%' // biar tetap responsif
            });
        });
    </script>

</body>

</html>