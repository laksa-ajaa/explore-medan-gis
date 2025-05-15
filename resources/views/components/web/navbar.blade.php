<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
  <div class="container-fluid px-5">
    <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
      <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" height="30" class="me-2">
      <span class="text-primary">Explore</span><span class="text-success">Medan</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="{{ !request()->routeIs('home') ? route('home') : '#' }}">Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ !request()->routeIs('home') ? route('home') . '#fitur' : '#fitur' }}">Fitur</a>
        </li>
        <li class="nav-item">
          <a class="nav-link"
            href="{{ !request()->routeIs('home') ? route('home') . '#manfaat' : '#manfaat' }}">Manfaat</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ !request()->routeIs('home') ? route('home') . '#team' : '#team' }}">Team</a>
        </li>
      </ul>
      <a href="{{ request()->routeIs('home') ? route('peta') : route('home') }}" class="btn btn-primary ms-lg-3">
        {{ request()->routeIs('home') ? 'Jelajahi Peta' : 'Kembali ke Beranda' }}
      </a>
    </div>
  </div>
</nav>
