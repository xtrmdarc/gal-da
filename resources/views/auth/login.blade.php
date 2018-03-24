<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::to('application/images/favicon.png') }}">
    <title>Ela - Bootstrap Admin Dashboard Template</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ URL::to('application/css/lib/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ URL::to('application/css/helper.css') }}" rel="stylesheet">
    <link href="{{ URL::to('application/css/style.css') }}" rel="stylesheet">
</head>

<body class="fix-header fix-sidebar">
<!-- Preloader - style you can find in spinners.css -->
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
</div>
<!-- Main wrapper  -->
<div id="main-wrapper" class="background-gray">

    <div class="unix-login">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <div class="login-content card">
                        <div>
                            <img src="{{ URL::to('application/images/galdaLogo.png') }}" alt="">
                        </div>

                        <div class="login-form">
                            <h4>{{ trans('auth.login') }}</h4>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <label>Email address</label>
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="Email">
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Password">

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                    <label class="pull-right">
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            Forgot Your Password?
                                        </a>
                                    </label>

                                </div>
                                <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Sign in</button>
                                <div class="register-link m-t-15 text-center">
                                    <p>Don't have account ? <a href="{{ route('register') }}"> Sign Up Here</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- End Wrapper -->
<!-- All Jquery -->
<script src="{{ URL::to('application/js/lib/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ URL::to('application/js/lib/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ URL::to('application/js/lib/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="{{ URL::to('application/js/jquery.slimscroll.js') }}"></script>
<!--Menu sidebar -->
<script src="{{ URL::to('application/js/sidebarmenu.js') }}"></script>
<!--stickey kit -->
<script src="{{ URL::to('application/js/lib/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
<!--Custom JavaScript -->
<script src="{{ URL::to('application/js/custom.min.js') }}"></script>

</body>

</html>