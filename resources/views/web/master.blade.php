<!DOCTYPE html>
<html class="no-js" lang="{{ app()->getLocale() }}">
<head>

    @include('partials.meta-tags')
    @include('web.partials.meta-tags')
    @include('web.partials.styles')

</head>
<body>
    
    @include('sweetalert::alert')
    <div id="app">

        @include('web.partials.header')
        
        @yield('content')

        @include('web.partials.footer')
        
        {{-- Dialogs --}}
        <dialog-container></dialog-container>

    </div>
    @include('PRXPayPal::includes.js')
    @include('partials.script-tags')

</body>
</html>