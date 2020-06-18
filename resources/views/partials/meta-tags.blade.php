<base href="/" />
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>{{ config('app.name') }} | @yield('meta:title', '')</title>
<meta name="author" content="{{ config('app.name') }}">

<meta name="description" content="@yield('meta:description', 'VISITA is a non-profit, sustainable tourism project working towards a responsible tourism industry through developing a range of tools on sustainable travel for both travelers and destination managers. In 2017, tourist arrivals reached a total of 1.326 billion globally.')">
<meta name="keywords" content="@yield('meta:keywords', 'Nature, Tourism, Travel, Travelers')">

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="apple-touch-icon" sizes="57x57" href="/favicons/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/favicons/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/favicons/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/favicons/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/favicons/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/favicons/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/favicons/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/favicons/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="/favicons/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="/favicons/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">
<link rel="manifest" href="/favicons/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/favicons/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<meta name="msapplication-navbutton-color" content="#1A1A18">
<meta name="apple-mobile-web-app-status-bar-style" content="#1A1A18">

<meta property="og:image" content="@yield('og:image', url('/') . '/images/visita-logo.png')">
<meta property="og:title" content="@yield('og:title', config('app.name'))">
<meta property="og:description" content="@yield('og:description', 'VISITA is a non-profit, sustainable tourism project working towards a responsible tourism industry through developing a range of tools on sustainable travel for both travelers and destination managers. In 2017, tourist arrivals reached a total of 1.326 billion globally.')">

<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:site_name" content="{{ config('app.name') }}">
<meta property="og:type" content="website">

<meta name="csrf-token" content="{{ csrf_token() }}">