<!DOCTYPE html>
<html class="no-js" lang="{{ app()->getLocale() }}">
<head>

    @include('partials.meta-tags')
    @include('web.partials.meta-tags')
    @include('web.partials.styles')

</head>
<body>

    <div id="app">

        @include('web.partials.header')
        
        @yield('content')

        @include('web.partials.footer')

        {{-- Dialogs --}}
        <dialog-container></dialog-container>

    </div>

    @include('partials.script-tags')

</body>
</html>