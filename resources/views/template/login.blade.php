<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - Sistem Helpdesk</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f7f7f7;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .login-title {
            margin-bottom: 30px;
        }
    </style>
    <link rel="icon" href="{{ asset('dist/img/Logo_PTPN4.png') }}" type="image/png">
</head>

<body>
    <div class="login-box">
        <h3 class="text-center login-title"><b>Sistem Helpdesk</b></h3>
        <hr />

        @if(session('error'))
        <div class="alert alert-danger">
            <strong>Oops!</strong> {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('login.submit') }}" method="post">
            @csrf
            <div class="form-group">
                <label>No. SAP</label>
                <input type="text" name="no_sap" class="form-control" placeholder="No. SAP" required />
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password" required />
            </div>

            <button type="submit" class="btn btn-primary btn-block">Log In</button>
        </form>

        <hr />

        <!-- Tombol Register mengarah ke form create user -->
        <div class="text-center">
            <a href="{{ route('register') }}" class="btn btn-success">Register</a>
        </div>
    </div>
</body>

</html>