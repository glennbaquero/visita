<!DOCTYPE html>
<html class="no-js" lang="{{ app()->getLocale() }}">
<head>

    @include('partials.meta-tags')
    @include('admin.partials.styles')

</head>
<body class="hold-transition sidebar-mini">
	
    <div id="app" class="wrapper">

        <div class="login-box">
            <div class="login-logo">
                <a href="#"><b>{{ config('app.name')}} Web</b></a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">

                @yield('content')
                
            </div>

        </div>

    </div>

    @include('partials.script-tags')

</body>
</html>