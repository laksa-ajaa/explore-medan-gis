@extends('layouts.web.app')

@section('content')
  <!-- Hero Section -->
  <section class="hero d-flex align-items-center" id="home">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <h1 class="mb-4">Jelajahi Keindahan Wisata Kota Medan</h1>
          <p class="lead mb-4">Temukan lokasi wisata terbaik di Medan dengan sistem informasi geografis interaktif kami.
            Rencana perjalanan wisata jadi lebih mudah dan menyenangkan!</p>
          <div class="d-flex gap-3">
            <a href="#" class="btn btn-primary btn-lg">Mulai Eksplorasi</a>
            <a href="#" class="btn btn-outline-light btn-lg">Pelajari Selengkapnya</a>
          </div>
        </div>
        <div class="col-lg-6 d-none d-lg-block">
          <!-- Placeholder for 3D interactive map -->
        </div>
      </div>
    </div>
  </section>

  <!-- Counter Section -->
  <section class="py-5">
    <div class="container">
      <div class="row g-4">
        <div class="col-md-3">
          <div class="counter-box">
            <div class="counter-number">50+</div>
            <div class="counter-text">Destinasi Wisata</div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="counter-box">
            <div class="counter-number">15+</div>
            <div class="counter-text">Rute Terbaik</div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="counter-box">
            <div class="counter-number">5K+</div>
            <div class="counter-text">Pengguna Aktif</div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="counter-box">
            <div class="counter-number">24/7</div>
            <div class="counter-text">Dukungan Online</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="py-5" id="fitur">
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
            <p class="text-muted">Akses informasi terbaru tentang destinasi, jam buka, harga tiket, dan fasilitas</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-card h-100">
            <div class="feature-icon">
              <i class="fas fa-star"></i>
            </div>
            <h4>Ulasan & Rating</h4>
            <p class="text-muted">Lihat rating dan ulasan dari pengunjung lain untuk membantu perencanaan</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="feature-card h-100">
            <div class="feature-icon">
              <i class="fas fa-camera"></i>
            </div>
            <h4>Galeri 360°</h4>
            <p class="text-muted">Nikmati panorama lokasi wisata dengan foto dan video 360 derajat</p>
          </div>
        </div>
        <div class="col-md-4">
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
          <a href="#" class="btn btn-primary">Coba Sekarang</a>
        </div>
        <div class="col-lg-6">
          <div class="map-container">
            <img src="/api/placeholder/800/600" alt="Peta GIS Wisata Medan" class="img-fluid">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Benefits Section -->
  <section class="highlight-section" id="manfaat">
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

  <!-- Team Section -->
  <section class="py-5 bg-light" id="team">
    <div class="container">
      <div class="text-center mb-5">
        <h6 class="text-primary fw-bold">TIM KAMI</h6>
        <h2 class="fw-bold">Otak di Balik GIS Wisata Medan</h2>
        <p class="text-muted">Kenali tim yang berdedikasi dalam mengembangkan sistem informasi geografis wisata Medan
        </p>
      </div>
      <div class="row g-4">
        <!-- Team Member 1 -->
        <div class="col-lg-3 col-md-6">
          <div class="card text-center h-100">
            <div class="card-body">
              <img src="/api/placeholder/200/200" alt="Randi Wijaya" class="team-img mb-4 rounded-circle">
              <h5>Randi Wijaya</h5>
              <p class="text-primary mb-3">GIS Developer</p>
              <p class="text-muted small">Pakar sistem informasi geografis dengan pengalaman 8+ tahun dalam
                pengembangan aplikasi GIS.</p>
              <div class="mt-3">
                <a href="#" class="text-muted me-2"><i class="fab fa-linkedin"></i></a>
                <a href="#" class="text-muted me-2"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-muted"><i class="fab fa-github"></i></a>
              </div>
            </div>
          </div>
        </div>
        <!-- Team Member 2 -->
        <div class="col-lg-3 col-md-6">
          <div class="card text-center h-100">
            <div class="card-body">
              <img src="/api/placeholder/200/200" alt="Nina Situmorang" class="team-img mb-4 rounded-circle">
              <h5>Nina Situmorang</h5>
              <p class="text-primary mb-3">UI/UX Designer</p>
              <p class="text-muted small">Spesialis antarmuka pengguna dengan fokus pada pengalaman pengguna yang
                intuitif dan menarik.</p>
              <div class="mt-3">
                <a href="#" class="text-muted me-2"><i class="fab fa-linkedin"></i></a>
                <a href="#" class="text-muted me-2"><i class="fab fa-dribbble"></i></a>
                <a href="#" class="text-muted"><i class="fab fa-behance"></i></a>
              </div>
            </div>
          </div>
        </div>
        <!-- Team Member 3 -->
        <div class="col-lg-3 col-md-6">
          <div class="card text-center h-100">
            <div class="card-body">
              <img src="/api/placeholder/200/200" alt="Andi Pratama" class="team-img mb-4 rounded-circle">
              <h5>Andi Pratama</h5>
              <p class="text-primary mb-3">Backend Engineer</p>
              <p class="text-muted small">Berpengalaman dalam pengembangan API dan manajemen database untuk sistem
                berbasis GIS.</p>
              <div class="mt-3">
                <a href="#" class="text-muted me-2"><i class="fab fa-linkedin"></i></a>
                <a href="#" class="text-muted me-2"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-muted"><i class="fab fa-github"></i></a>
              </div>
            </div>
          </div>
        </div>
        <!-- Team Member 4 -->
        <div class="col-lg-3 col-md-6">
          <div class="card text-center h-100">
            <div class="card-body">
              <img src="/api/placeholder/200/200" alt="Siti Aminah" class="team-img mb-4 rounded-circle">
              <h5>Siti Aminah</h5>
              <p class="text-primary mb-3">Frontend Developer</p>
              <p class="text-muted small">Ahli dalam membangun antarmuka yang interaktif dan responsif menggunakan
                teknologi web modern.</p>
              <div class="mt-3">
                <a href="#" class="text-muted me-2"><i class="fab fa-linkedin"></i></a>
                <a href="#" class="text-muted me-2"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-muted"><i class="fab fa-github"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
