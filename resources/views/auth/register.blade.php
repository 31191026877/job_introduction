<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>Register | {{ config('app.name') }} </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link href="{{asset('css/icons.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/app-creative.min.css')}}" rel="stylesheet" type="text/css" id="light-style"
          disabled="disabled">
    <link href="{{asset('css/app-creative-dark.min.css')}}" rel="stylesheet" type="text/css">

</head>

<body class="authentication-bg pb-0" data-layout-config='{"darkMode":false}'>

<div class="auth-fluid">
    <!--Auth fluid left content -->
    <div class="auth-fluid-form-box">
        <div class="align-items-center d-flex h-100">
            <div class="card-body">

                <!-- Logo -->
                <div class="auth-brand text-center text-lg-left">
                    <a href="index.html" class="logo-dark">
                        <span><img src="assets/images/logo-dark.png" alt="" height="18"></span>
                    </a>
                    <a href="index.html" class="logo-light">
                        <span><img src="assets/images/logo.png" alt="" height="18"></span>
                    </a>
                </div>

                <!-- title-->
                <h4 class="mt-0">Free Sign Up</h4>
                <p class="text-muted mb-4">Don't have an account? Create your account, it takes less than a minute</p>

                <!-- form -->
                <form action="{{ route('registering') }}" method="post">
                    @csrf
                    @auth
                        <div class="form-group">
                            <label>Full Name</label>
                            <input class="form-control" value="{{ auth()->user()->name }}" name="name" type="text"
                                   disabled>
                        </div>
                        <div class="form-group">
                            <label>Email address</label>
                            <input class="form-control" name="email" value="{{ auth()->user()->email }}" type="email"
                                   disabled>
                        </div>
                        <div class="form-group">
                            <label>Avatar</label>
                            <div class="nav-link dropdown-toggle nav-user arrow-none mr-0" data-toggle="dropdown">
                                <span class="account-user-avatar">
                                    <img src="{{ auth()->user()->avatar }}" alt="user-image" class="rounded-circle">
                                </span>

                            </div>

                        </div>
                    @endauth
                    @guest
                        <div class="form-group">
                            <label for="fullname">Full Name</label>
                            <input class="form-control" name="name" type="text"
                                   id="fullname" placeholder="Enter your name" required>
                        </div>
                        <div class="form-group">
                            <label for="emailaddress">Email address</label>
                            <input class="form-control" name="email" type="email"
                                   id="emailaddress" required placeholder="Enter your email">
                        </div>
                    @endguest
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input class="form-control" name="password" type="password" required id="password"
                               placeholder="Enter your password">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="checkbox-signup">
                            <label class="custom-control-label" for="checkbox-signup">I accept <a
                                    href="javascript: void(0);" class="text-muted">Terms and Conditions</a></label>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-center">
                        <button class="btn btn-primary btn-block" type="submit"><i class="mdi mdi-account-circle"></i>
                            Sign Up
                        </button>
                    </div>
                    <!-- social-->
                    <div class="text-center mt-4">
                        <p class="text-muted font-16">Sign up using</p>
                        <ul class="social-list list-inline mt-3">
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i
                                        class="mdi mdi-facebook"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i
                                        class="mdi mdi-google"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="social-list-item border-info text-info"><i
                                        class="mdi mdi-twitter"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i
                                        class="mdi mdi-github-circle"></i></a>
                            </li>
                        </ul>
                    </div>
                </form>
                <!-- end form-->

                <!-- Footer-->
                <footer class="footer footer-alt">
                    <p class="text-muted">Already have account? <a href="pages-login-2.html" class="text-muted ml-1"><b>Log
                                In</b></a></p>
                </footer>

            </div> <!-- end .card-body -->
        </div> <!-- end .align-items-center.d-flex.h-100-->
    </div>
    <!-- end auth-fluid-form-box-->

    <!-- Auth fluid right content -->
    <div class="auth-fluid-right text-center">
        <div class="auth-user-testimonial">
            <h2 class="mb-3">I love the color!</h2>
            <p class="lead"><i class="mdi mdi-format-quote-open"></i> It's a elegent templete. I love it very much! . <i
                    class="mdi mdi-format-quote-close"></i>
            </p>
            <p>
                - Hyper Admin User
            </p>
        </div> <!-- end auth-user-testimonial-->
    </div>
    <!-- end Auth fluid right content -->
</div>
<!-- end auth-fluid-->

<!-- bundle -->
<script src="{{asset('js/vendor.min.js')}}"></script>
<script src="{{asset('js/app.min.js')}}"></script>

</body>

</html>
