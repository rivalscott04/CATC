<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Login 2</title>

    <link href={{asset("css/bootstrap.min.css")}} rel="stylesheet">
    <link href={{asset("font-awesome/css/font-awesome.css")}} rel="stylesheet">

    <link href={{asset("css/animate.css")}} rel="stylesheet">
    <link href={{asset("css/style.css")}} rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="animated fadeInDown">
        <div class="row col-lg-12">

            <div class="col-lg-9  pt-5 pl-5 pr-2">
               <img src="img/kiri.jpg" width="100%" />

            </div>
            <div class="col-lg-3 p-5">
                <div class="logo" style=" margin:25px;">
                    <center> 
                        <img src="img/if.png" width="150px" />
                        @if (Session::has('message'))
                        <p class="alert alert-danger mt-2">{{ Session::get('message') }}</p>
                    @endif
                    </center>
                </div>
                <div class="ibox-content">
                    <h1 class="black-text"> Login </h1>
                    <form class="m-t" role="form" method="POST" action="/login">
                        @csrf
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Email" required="">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Password" required="">
                        </div>
                        <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                        <a href="#">
                            <small>Forgot password?</small>
                        </a>
                    </form>
                    <p class="m-t">
                        <small>CATC PSTI UNRAM &copy; 2022</small>
                    </p>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6">
                Copyright Example Company
            </div>
            <div class="col-md-6 text-right">
               <small>© 2022</small>
            </div>
        </div>
    </div>

</body>

</html>
