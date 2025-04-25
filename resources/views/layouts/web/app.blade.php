<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MedanTour GIS - Jelajahi Wisata Kota Medan</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">

  @stack('styles')
</head>

<body>
  @include('components.web.navbar')

  @include('components.web.hero')

  @yield('content')

  @include('components.web.footer')

  @stack('scripts')
</body>

</html>
