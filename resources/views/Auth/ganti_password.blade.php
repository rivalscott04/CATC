<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CATC | Ganti Password</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <img src="img/unram_logo.png" alt="Logo Unram" style="width: 150px" class="mt-5">

            </div>
            <h3>Ganti Pasword</h3>
            <form class="m-t" role="form" action="/ganti_password" method="post">
                @if (Session::has('message'))
                    <p class="alert alert-info">{{ Session::get('message') }}</p>
                @endif
                @if (session('status'))
                    <div class="alert alert-warning">
                        {{ session('status') }}
                    </div>
                @endif
                @csrf
                <div class="form-group">
                    <p style="text-align: left; font-size: 14px">Password Lama</p>
                    <input type="password" name="lama" class="form-control" placeholder="Password Lama" required="">
                </div>
                <div class="form-group">
                    <p style="text-align: left; font-size: 14px">Password Baru</p>
                    <input type="password" class="form-control" name="baru" placeholder="Password" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
            </form>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>

</body>

</html>
