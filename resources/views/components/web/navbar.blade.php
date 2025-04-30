<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
  <div class="container">
    <a class="navbar-brand" href="{{ route('home') }}">
      <span class="text-primary">Explore</span><span class="text-success">Medan</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#fitur">Fitur</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#manfaat">Manfaat</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#team">Team</a>
        </li>
      </ul>
      <a href="{{ request()->routeIs('home') ? route('peta') : route('home') }}" class="btn btn-primary ms-lg-3">
        {{ request()->routeIs('home') ? 'Jelajahi Peta' : 'Kembali ke Home' }}
      </a>
    </div>
  </div>
</nav>
