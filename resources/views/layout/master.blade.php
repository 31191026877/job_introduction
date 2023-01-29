<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>{{ $title ?? '' }} - {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/app-creative.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/app-creative-dark.min.css') }}" rel="stylesheet" type="text/css">
    @stack('css')
</head>

<body class="loading"
      data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
<!-- Begin page -->
@include('layout.sidebar')
<div class="wrapper">

    <div class="content-page">
        <div class="content">
            @include('layout.topbar')
            <div class="container-fluid">
                <div class="error">

                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <h4 class="page-title">{{ $title ?? '' }}</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        @include('layout.footer')

    </div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="{{ asset('js/vendor.min.js') }}"></script>
<script src="{{ asset('js/app.min.js') }}"></script>
<script src="{{ asset('js/helper.js') }}"></script>

@stack('js')
</body>
</html>
