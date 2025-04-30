<meta name="robots" content="noindex,nofollow">

@php($appName = 'ExploreMedan')
<title>{{ isset($title) ? "$title - $appName" : $appName }}</title>

<meta name="application-name" content="{{ $appName }}">

<link rel="apple-touch-icon" sizes="180x89" href="{{ asset('apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="32x16" href="{{ asset('favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x8" href="{{ asset('favicon-16x16.png') }}">
