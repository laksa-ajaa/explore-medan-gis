@extends('layouts.web.app')

@section('content')
  <!-- Hero Section -->
  <section class="hero d-flex align-items-center" id="home">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <h1 class="mb-4">Jelajahi Destinasi Wisata di Kota Medan</h1>
          <p class="lead mb-4">Temukan lokasi wisata terbaik di Medan dengan sistem informasi geografis interaktif kami.
            Rencana perjalanan wisata jadi lebih mudah dan menyenangkan!</p>
          <div class="d-flex gap-3">
            <a href="{{ route('peta') }}" class="btn btn-primary btn-lg">Jelajahi Peta</a>
            <a href="#info" class="btn btn-outline-light btn-lg">Pelajari Selengkapnya</a>
          </div>
        </div>
        <div class="col-lg-6 d-none d-lg-block">
          <!-- Placeholder for 3D interactive map -->
        </div>
      </div>
    </div>
  </section>

  <!-- Counter Section -->
  <section class="pt-5" id="info">
    <div class="container">
      <div class="row g-4">
        <div class="col-md-4">
          <div class="counter-box">
            <div class="counter-number">50+</div>
            <div class="counter-text">Destinasi Wisata</div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="counter-box">
            <div class="counter-number">15+</div>
            <div class="counter-text">Rute Terbaik</div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="counter-box">
            <div class="counter-number">24/7</div>
            <div class="counter-text">Dukungan Online</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <div class="mb-5" id="fitur"></div>
  <section class="py-5">
    <div class="container">
      <div class="text-center mb-5">
        <h6 class="text-primary fw-bold">FITUR UNGGULAN</h6>
        <h2 class="fw-bold">Nikmati Kemudahan Eksplorasi</h2>
        <p class="text-muted">Sistem informasi geografis kami dirancang untuk memberikan pengalaman terbaik</p>
      </div>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="feature-card h-100">
            <div class="feature-icon">
              <i class="fas fa-map-marked-alt"></i>
            </div>
            <h4>Peta Interaktif</h4>
            <p class="text-muted">Jelajahi peta interaktif dengan tampilan yang menarik dan mudah digunakan</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-card h-100">
            <div class="feature-icon">
              <i class="fas fa-route"></i>
            </div>
            <h4>Rekomendasi Rute</h4>
            <p class="text-muted">Dapatkan rekomendasi rute terbaik untuk mengunjungi destinasi wisata favorit</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-card h-100">
            <div class="feature-icon">
              <i class="fas fa-info-circle"></i>
            </div>
            <h4>Info Lengkap</h4>
            <p class="text-muted">Akses informasi tentang destinasi, harga tiket, dan fasilitas</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="feature-card h-100">
            <div class="feature-icon">
              <i class="fas fa-star"></i>
            </div>
            <h4>Rating</h4>
            <p class="text-muted">Lihat rating terkait destinasi wisata untuk membantu perencanaan</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="feature-card h-100">
            <div class="feature-icon">
              <i class="fas fa-mobile-alt"></i>
            </div>
            <h4>Responsif Mobile</h4>
            <p class="text-muted">Akses dari perangkat apapun dengan tampilan yang tetap optimal</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Map Section -->
  <section class="py-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0">
          <h6 class="text-primary fw-bold">PETA INTERAKTIF</h6>
          <h2 class="fw-bold mb-4">Temukan Lokasi Wisata dengan Mudah</h2>
          <p class="mb-4">Gunakan sistem informasi geografis kami untuk menemukan dan merencanakan kunjungan ke
            tempat wisata favorit di Kota Medan. Fitur peta interaktif memudahkan Anda melihat lokasi, jarak, dan
            informasi penting lainnya.</p>
          <ul class="list-unstyled mb-4">
            <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Tampilan peta yang detail dan
              akurat</li>
            <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Filter berdasarkan kategori
              tempat wisata</li>
            <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Informasi rute dan transportasi
              publik</li>
            <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Estimasi waktu tempuh dan jarak
            </li>
          </ul>
          <a href="{{ route('peta') }}" class="btn btn-primary">Coba Sekarang</a>
        </div>
        <div class="col-lg-6">
          <div class="map-container">
            <img src="/api/placeholder/800/600" alt="Peta GIS Wisata Medan" class="img-fluid">
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="mb-5" id="manfaat"></div>
  <!-- Benefits Section -->
  <section class="highlight-section">
    <div class="container">
      <div class="text-center mb-5">
        <h6 class="fw-bold text-light">MANFAAT</h6>
        <h2 class="fw-bold text-white">Mengapa Menggunakan GIS Wisata Medan?</h2>
        <p class="text-white opacity-75">Nikmati berbagai manfaat yang akan memudahkan perjalanan wisata Anda</p>
      </div>
      <div class="row g-4">
        <div class="col-lg-3 col-md-6">
          <div class="card h-100">
            <div class="card-body text-center">
              <i class="fas fa-search feature-icon"></i>
              <h5>Pencarian Mudah</h5>
              <p class="text-muted">Temukan destinasi wisata dengan cepat dan mudah melalui fitur pencarian yang
                intuitif</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="card h-100">
            <div class="card-body text-center">
              <i class="fas fa-clock feature-icon"></i>
              <h5>Hemat Waktu</h5>
              <p class="text-muted">Rencanakan perjalanan dengan efisien dan hindari pemborosan waktu saat berwisata
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="card h-100">
            <div class="card-body text-center">
              <i class="fas fa-map feature-icon"></i>
              <h5>Navigasi Akurat</h5>
              <p class="text-muted">Panduan arah yang akurat dan terpercaya untuk mencapai destinasi dengan tepat</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="card h-100">
            <div class="card-body text-center">
              <i class="fas fa-lightbulb feature-icon"></i>
              <h5>Rekomendasi Pintar</h5>
              <p class="text-muted">Dapatkan saran tempat wisata sesuai preferensi dan minat Anda</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="mb-5" id="team"></div>
  <!-- Team Section -->
  <section class="py-5 bg-light">
    <div class="container">
      <div class="text-center mb-5">
        <h6 class="text-primary fw-bold">TIM KAMI</h6>
        <h2 class="fw-bold">Otak di Balik GIS Wisata Medan</h2>
        <p class="text-muted">Kenali tim yang berdedikasi dalam mengembangkan sistem informasi geografis wisata Medan
        </p>
      </div>
      <div class="row g-4">
        @foreach ($teams as $team)
          <div class="col-lg-4 col-md-6">
            <div class="card text-center h-100">
              <div class="card-body">
                <img src="{{ asset('images/' . $team->photo) }}" alt="{{ $team->name }}"
                  class="team-img mb-4 rounded-circle" width="200" height="200">
                <h5>{{ $team->name }}</h5>
                <p class="text-primary mb-3">{{ $team->nim }}</p>
                <p class="text-muted small">{{ $team->email }}</p>
                <div class="mt-3">
                  @if (!empty($team->linkedIn))
                    <a href="{{ $team->linkedIn }}" class="text-muted me-2" target="_blank"><i
                        class="fab fa-linkedin"></i></a>
                  @endif
                  @if (!empty($team->instagram))
                    <a href="{{ $team->instagram }}" class="text-muted me-2" target="_blank"><i
                        class="fab fa-instagram"></i></a>
                  @endif
                  @if (!empty($team->github))
                    <a href="{{ $team->github }}" class="text-muted" target="_blank"><i class="fab fa-github"></i></a>
                  @endif
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>
@endsection
