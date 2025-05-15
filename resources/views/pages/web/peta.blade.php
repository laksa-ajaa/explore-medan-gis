@extends('layouts.web.app')

@push('styles')
  {{-- Virtual Select --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/virtual-select-plugin@1.0.46/dist/virtual-select.min.css"
    integrity="sha256-2J2LphAasJ6yO+ZAylnzWM2N1xHblyZeVK9j0EoJpOQ=" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/virtual-select-plugin@1.0.46/dist/virtual-select.min.js"
    integrity="sha256-vvp5tsZt6dxBdWuGfMnKqHOplFUmacnAc3qtNAZ1HkM=" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="anonymous">

  <script src="https://cdn.jsdelivr.net/npm/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.min.js"
    integrity="sha256-OqfsQXAGfyz0njzJEepuBcQwxXRnv2I3RW70XkpsIbk=" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css"
    integrity="sha256-cu3EeyAbdh7FZ58X4+oQz2g30Tw/U+3Utqmr1ETODqQ=" crossorigin="anonymous">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.21.0/dist/sweetalert2.all.min.js"
    integrity="sha256-TU2eIihLYclo7k5+qmqLlo4q4A8/R0TC5sfcvbzDDFI=" crossorigin="anonymous"></script>
  <style>
    #map {
      height: 90vh;
    }

    .map-container {
      height: 90vh;
      position: relative;
      flex: 1;
      overflow: hidden;
    }

    .legend {
      background-color: white;
      border-radius: 5px;
      box-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);
      position: absolute;
      bottom: 20px;
      right: 20px;
      z-index: 500;
      padding: 10px;
    }

    /* Map Controls */
    .map-control {
      background: white;
      border-radius: 6px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
      padding: 8px;
      z-index: 400;
    }

    .layer-control {
      position: absolute;
      bottom: 20px;
      left: 20px;
      font-size: 14px;
    }

    .fullscreen-control {
      position: absolute;
      top: 10px;
      right: 10px;
      cursor: pointer;
      padding: 8px 10px;
      background: white;
      border-radius: 4px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
      z-index: 1000;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s ease;
    }

    .fullscreen-control:hover {
      background-color: #f8f9fa;
      transform: scale(1.05);
    }

    .fullscreen-control i {
      font-size: 20px;
      color: #198754;
    }

    /* Fullscreen mode */
    .map-fullscreen {
      position: fixed !important;
      top: 3rem !important;
      left: 0 !important;
      width: 90vw !important;
      height: 90vh !important;
      z-index: 9999 !important;
      margin: 0 !important;
      padding: 0 !important;
      border-radius: 0 !important;
      max-width: none !important;
    }

    .map-fullscreen #map {
      height: 100vh !important;
    }

    .legend-color {
      width: 16px;
      height: 16px;
      border-radius: 50%;
      display: inline-block;
      margin-right: 8px;
    }

    .legend-line {
      width: 16px;
      height: 4px;
      display: inline-block;
      margin-right: 8px;
      vertical-align: middle;
    }

    /* Modern Sidebar Styles */
    .sidebar {
      max-width: 380px;
      width: 100%;
      height: 90vh;
      overflow-y: auto;
      scrollbar-width: thin;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      border-radius: 12px;
    }

    .sidebar::-webkit-scrollbar {
      width: 6px;
    }

    .sidebar::-webkit-scrollbar-thumb {
      background-color: #198754;
      border-radius: 10px;
    }

    /* Button Navigation Styling */
    .nav-buttons {
      margin-bottom: 20px;
    }

    .nav-btn {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 12px 8px;
      border-radius: 10px;
      background-color: #f8f9fa;
      border: none;
      color: #6c757d;
      transition: all 0.3s ease;
    }

    .nav-btn i {
      font-size: 20px;
      margin-bottom: 5px;
    }

    .nav-btn span {
      font-size: 12px;
      font-weight: 600;
    }

    .nav-btn:hover {
      background-color: #e9ecef;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      color: #198754;
    }

    .nav-btn.active {
      background-color: #198754;
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(25, 135, 84, 0.25);
    }

    /* Content Sections */
    .content-section {
      display: none;
      margin-bottom: 20px;
      animation: fadeIn 0.5s ease;
    }

    .content-section.active {
      display: block;
    }

    .section-header {
      padding: 0 0 12px 0;
      margin-bottom: 15px;
      border-bottom: 2px solid #e9ecef;
    }

    .section-content {
      background-color: #f8f9fa;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    /* Badge Styling */
    .filter-badge {
      font-size: 11px;
      padding: 6px 12px;
      margin: 3px;
      cursor: pointer;
      border-radius: 20px;
      border: 1px solid #dee2e6;
      background-color: white;
      transition: all 0.25s;
      display: inline-block;
    }

    .filter-badge:hover {
      border-color: #198754;
      transform: translateY(-2px);
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .filter-badge.active {
      background-color: #198754;
      color: white;
      border-color: #198754;
      box-shadow: 0 2px 5px rgba(25, 135, 84, 0.3);
    }

    /* Action Buttons */
    .btn-action {
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      transition: all 0.3s;
    }

    .btn-action:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    /* Search Input Styling */
    .input-group-text {
      border-radius: 8px 0 0 8px;
    }

    #districtSearch {
      border-radius: 0 8px 8px 0;
      transition: all 0.3s ease;
    }

    #districtSearch:focus {
      box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
      border-color: #198754;
    }

    /* Route Info Styling */
    #routeInfo {
      border-radius: 10px;
      border-left: 4px solid #198754;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
    }

    /* Tourist Info Panel */
    #infoPanel {
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      border: none;
      transition: all 0.3s ease;
    }

    #infoPanel .card-header {
      border-bottom: 2px solid #e9ecef;
    }

    .leaflet-interactive {
      cursor: pointer;
    }

    .selecting-start-point .leaflet-interactive {
      cursor: crosshair !important;
    }

    .vscomp-wrapper {
      width: 290px;
    }

    /* Animation */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
@endpush

@section('content')
  <div class="container-fluid d-flex flex-column flex-md-row mt-5 mb-5">
    <!-- Modern Sidebar -->
    <!-- Modern Sidebar with Button Navigation -->
    <div class="bg-white p-4 sidebar me-md-3 mt-4">
      <div class="d-flex align-items-center mb-4">
        <i class="bi bi-map-fill text-success fs-4 me-2"></i>
        <h1 class="text-success fs-4 fw-bold m-0">Peta Wisata Kota Medan</h1>
      </div>

      <!-- Main Navigation Buttons -->
      <div class="nav-buttons mb-4">
        <div class="d-flex gap-2 justify-content-between">
          <button class="btn nav-btn active" data-target="route-section">
            <i class="bi bi-signpost-split"></i>
            <span>Rute</span>
          </button>
          <button class="btn nav-btn" data-target="category-section">
            <i class="bi bi-tags"></i>
            <span>Kategori</span>
          </button>
          <button class="btn nav-btn" data-target="district-section">
            <i class="bi bi-geo-alt"></i>
            <span>Kecamatan</span>
          </button>
        </div>
      </div>

      <!-- Content Sections -->
      <div class="content-sections">
        <!-- Route Planning Section -->
        <div id="route-section" class="content-section active">
          <div class="section-header d-flex align-items-center">
            <h2 class="fs-5 fw-semibold m-0">Perencanaan Rute</h2>
          </div>

          <div class="section-content rounded-3 p-3">
            <!-- Custom Location Selection -->
            <div class="mb-3">
              <div class="fw-semibold text-secondary mb-2 small">Mode Pilih Lokasi:</div>
              <div class="btn-group w-100 mb-3" role="group">
                <input type="radio" class="btn-check" name="locationMode" id="locationModeDropdown" checked>
                <label class="btn btn-outline-success btn-sm" for="locationModeDropdown">Pilih dari Daftar</label>

                <input type="radio" class="btn-check" name="locationMode" id="locationModeMap">
                <label class="btn btn-outline-success btn-sm" for="locationModeMap">Klik pada Peta</label>
              </div>
            </div>

            <!-- Start Point Selection -->
            <!-- Dropdown mode: VirtualSelect for start -->
            <div id="dropdownSelectMode" class="location-mode">
              <div class="mb-3">
                <label for="startingPoint" class="form-label small fw-semibold text-secondary">Lokasi Awal</label>
                <div id="start-select" placeholder="Pilih Titik Awal"></div>
              </div>
            </div>

            <!-- Map-click mode: manual lat/lng for start -->
            <div id="mapClickMode" class="location-mode d-none">
              <div class="mb-3">
                <label class="form-label small fw-semibold text-secondary">Lokasi Awal</label>
                <div class="input-group input-group-sm mb-2">
                  <span class="input-group-text">Lat</span>
                  <input type="text" class="form-control" id="startLat" readonly>
                  <span class="input-group-text">Lng</span>
                  <input type="text" class="form-control" id="startLng" readonly>
                </div>
                <button id="setStartPoint" class="btn btn-outline-primary btn-sm w-100">
                  <i class="bi bi-geo-alt"></i> Pilih Titik Awal
                </button>
              </div>
            </div>

            <!-- Destination Selection (always visible) -->
            <div class="mb-3">
              <label for="destination" class="form-label small fw-semibold text-secondary">Lokasi Wisata</label>
              <div id="wisata-select" placeholder="Pilih Lokasi Wisata"></div>
            </div>

            <!-- Action Buttons -->
            <div class="d-grid gap-2">
              <button id="findRoute" class="btn btn-success btn-sm btn-action">
                <i class="bi bi-search me-1"></i> Cari Rute
              </button>
              <button id="resetMap" class="btn btn-outline-danger btn-sm btn-action">
                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Peta
              </button>
            </div>
          </div>
        </div>

        <!-- Category Filter Section -->
        <div id="category-section" class="content-section">
          <div class="section-header d-flex align-items-center mb-3">
            <h2 class="fs-5 fw-semibold m-0">Filter Kategori</h2>
          </div>

          <div class="section-content p-3 rounded-3">
            <div class="d-flex flex-wrap" id="categoryFilters">
              <span class="filter-badge active" data-category="all">Semua</span>
              @foreach ($point_wisata->unique('category') as $wisata)
                @if ($wisata->category)
                  <span class="filter-badge"
                    data-category="wisata-{{ $wisata->category }}">{{ ucfirst($wisata->category) }}</span>
                @endif
              @endforeach
            </div>
          </div>
        </div>

        <!-- District Filter Section -->
        <div id="district-section" class="content-section">
          <div class="section-header d-flex align-items-center mb-3">
            <h2 class="fs-5 fw-semibold m-0">Filter Kecamatan</h2>
          </div>

          <div class="section-content p-3 rounded-3">
            <div class="mb-3">
              <div class="input-group input-group-sm">
                <span class="input-group-text bg-white border-end-0">
                  <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" class="form-control form-control-sm border-start-0" id="districtSearch"
                  placeholder="Cari kecamatan...">
              </div>
            </div>
            <div class="d-flex flex-wrap mt-2" id="districtFilters">
              <span class="filter-badge active" data-district="all">Semua</span>
              @foreach ($kecamatan->take(10) as $kec)
                <span class="filter-badge" data-district="{{ $kec['name'] }}">{{ $kec['name'] }}</span>
              @endforeach
            </div>
          </div>
        </div>
      </div>

      <!-- Loading and Route Info -->
      <div id="loading" class="text-center text-success my-3 d-none">
        <div class="spinner-border spinner-border-sm me-2" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <span class="small">Mencari rute optimal...</span>
      </div>

      <div id="routeInfo" class="alert alert-success mb-3 d-none">
        <div class="d-flex align-items-center mb-2">
          <i class="bi bi-info-circle-fill me-2"></i>
          <h5 class="alert-heading fs-6 fw-bold m-0">Informasi Rute</h5>
        </div>
        <hr class="my-2">
        <div id="routeDistance" class="small"></div>
        <div id="routeDuration" class="small"></div>
      </div>

      <!-- Tourist Info Panel -->
      <div id="infoPanel" class="card filter-card">
        <div class="card-header d-flex align-items-center py-2 px-3 bg-light">
          <i class="bi bi-info-circle me-2 text-success"></i>
          <h5 class="card-title text-success fw-bold fs-6 m-0">Informasi Wisata</h5>
        </div>
        <div class="card-body p-3">
          <div id="touristInfo">
            <p class="card-text small mb-0">
              Klik pada lokasi wisata di peta untuk melihat informasi atau pilih lokasi dari menu dropdown.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Map Container -->
    <div class="map-container w-100 mt-4"
      style="border-radius: 12px; overflow: hidden; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
      <div id="map"></div>

      <!-- Fullscreen control -->
      <div class="fullscreen-control" id="fullscreenControl" title="Tampilan Layar Penuh">
        <i class="bi bi-arrows-fullscreen"></i>
      </div>

      <!-- Layer control -->
      <div class="layer-control map-control">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <h6 class="m-0 fw-semibold fs-6">Layer Peta</h6>
        </div>
        <hr class="my-2">
        <div class="layer-options">
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="mapLayerRadio" id="layerOSM" checked>
            <label class="form-check-label small" for="layerOSM">
              OpenStreetMap
            </label>
          </div>
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="mapLayerRadio" id="layerSatellite">
            <label class="form-check-label small" for="layerSatellite">
              Satellite
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="layerDistrict">
            <label class="form-check-label small" for="layerDistrict">
              Batas Kecamatan
            </label>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <!-- Bootstrap Icons CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

  <script>
    document.addEventListener('DOMContentLoaded', function() {

      const script = document.createElement('script');
      script.src = 'https://cdn.jsdelivr.net/npm/leaflet-geometryutil@0.10.0/src/leaflet.geometryutil.min.js';
      script.onload = function() {
        initMap();
      };
      document.head.appendChild(script);

      const navButtons = document.querySelectorAll('.nav-btn');
      const contentSections = document.querySelectorAll('.content-section');

      navButtons.forEach(button => {
        button.addEventListener('click', function() {
          navButtons.forEach(btn => btn.classList.remove('active'));
          this.classList.add('active');

          contentSections.forEach(section => section.classList.remove('active'));
          const targetSection = document.getElementById(this.dataset.target);
          targetSection.classList.add('active');
        });
      });
    });

    function initMap() {
      const pointStart = @json($point_start);
      const pointWisata = @json($point_wisata);
      const kecamatan = @json($kecamatan);

      // Default tourist info
      const defaultTouristInfo = document.getElementById('touristInfo').innerHTML;

      const startEl = document.querySelector('#start-select');
      const wisataEl = document.querySelector('#wisata-select');

      const modeDropdown = document.getElementById('locationModeDropdown');
      const modeMap = document.getElementById('locationModeMap');
      const dropdownEl = document.getElementById('dropdownSelectMode');
      const mapClickEl = document.getElementById('mapClickMode');
      const btnSetStart = document.getElementById('setStartPoint');
      const inpStartLat = document.getElementById('startLat');
      const inpStartLng = document.getElementById('startLng');
      const findRouteBtn = document.getElementById('findRoute');
      const resetMapBtn = document.getElementById('resetMap');

      VirtualSelect.init({
        ele: startEl,
        multiple: false,
        options: pointStart.map(point => ({
          label: point.name,
          value: point.id
        })),
        search: true,
      });

      VirtualSelect.init({
        ele: wisataEl,
        multiple: false,
        options: pointWisata.map(point => ({
          label: point.name,
          value: point.id
        })),
        search: true,
      });

      function updateLocationMode() {
        if (modeDropdown.checked) {
          dropdownEl.classList.remove('d-none');
          mapClickEl.classList.add('d-none');
        } else {
          dropdownEl.classList.add('d-none');
          mapClickEl.classList.remove('d-none');
        }
      }
      modeDropdown.addEventListener('change', updateLocationMode);
      modeMap.addEventListener('change', updateLocationMode);
      updateLocationMode();

      // Ikon untuk titik awal - masih menggunakan marker merah
      const redIcon = L.icon({
        iconUrl: '{{ asset('assets/img/legends/halte.png') }}',
        iconSize: [28, 28],
        iconAnchor: [16, 32]
      });
      const selfIcon = L.icon({
        iconUrl: '{{ asset('assets/img/legends/pin.png') }}',
        iconSize: [28, 28],
        iconAnchor: [16, 32]
      });

      // Cache untuk menyimpan ikon yang sudah dibuat
      const categoryIconCache = {};

      // Mapping kategori ke URL ikon Flaticon
      const categoryIconMap = {
        'default': '{{ asset('assets/img/legends/default.png') }}',
        'Bangunan Bersejarah': '{{ asset('assets/img/legends/sejarah.png') }}',
        'Taman': '{{ asset('assets/img/legends/taman.png') }}',
        'Stadium': '{{ asset('assets/img/legends/stadium.png') }}',
        'Museum': '{{ asset('assets/img/legends/museum.png') }}',
        'Kebun Binatang': '{{ asset('assets/img/legends/zoo.png') }}',
        'Mall': '{{ asset('assets/img/legends/mall.png') }}',
        'Lapangan': '{{ asset('assets/img/legends/lapangan.png') }}',
        'Monumen': '{{ asset('assets/img/legends/monumen.png') }}',
        'Danau Wisata': '{{ asset('assets/img/legends/danau.png') }}',
      };

      // Fungsi untuk mendapatkan ikon berdasarkan kategori
      function getIconByCategory(category) {
        if (!category || !categoryIconMap[category]) {
          if (!categoryIconCache.default) {
            categoryIconCache.default = L.icon({
              iconUrl: categoryIconMap.default,
              iconSize: [28, 28],
              iconAnchor: [16, 32],
              popupAnchor: [0, -32]
            });
          }
          return categoryIconCache.default;
        }

        if (categoryIconCache[category]) {
          return categoryIconCache[category];
        }

        // Buat ikon baru dan simpan di cache
        categoryIconCache[category] = L.icon({
          iconUrl: categoryIconMap[category],
          iconSize: [32, 32],
          iconAnchor: [16, 32],
          popupAnchor: [0, -32]
        });

        return categoryIconCache[category];
      }

      const map = L.map('map').setView([3.5952, 98.6722], 12);

      const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
      }).addTo(map);

      const satelliteLayer = L.tileLayer(
        'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
          attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
        });

      // Layer groups
      const startPointsLayer = L.layerGroup().addTo(map);
      const wisataPointsLayer = L.layerGroup().addTo(map);
      const routeLayer = L.layerGroup().addTo(map);
      let kecamatanLayer;

      kecamatanLayer = L.layerGroup();
      const kecamatanPolygons = {}; // Store polygon references by district name

      // Create district polygons from GeoJSON
      kecamatan.forEach(district => {
        if (district.geojson) {
          const geojson = JSON.parse(district.geojson);
          const polygon = L.geoJSON(geojson, {
            style: {
              color: '#28a745',
              weight: 2,
              opacity: 0.6,
              fillColor: '#28a745',
              fillOpacity: 0.1
            },
            // Tambahkan event handler untuk klik pada polygon
            onEachFeature: function(feature, layer) {
              layer.on('click', function(e) {
                // Handle klik pada polygon kecamatan
                if (isSelectingStartPoint) {
                  // Ambil koordinat klik
                  const lat = e.latlng.lat;
                  const lng = e.latlng.lng;

                  // Isi nilai input dengan koordinat yang dipilih
                  inpStartLat.value = lat.toFixed(6);
                  inpStartLng.value = lng.toFixed(6);

                  // Hapus marker titik awal sebelumnya jika ada
                  if (selectedStartMarker) {
                    map.removeLayer(selectedStartMarker);
                  }

                  // Tambahkan marker baru pada posisi yang dipilih
                  selectedStartMarker = L.marker([lat, lng], {
                    icon: selfIcon,
                    draggable: true // Memungkinkan marker dapat di-drag untuk penyesuaian
                  }).addTo(map);

                  // Event ketika marker di-drag
                  selectedStartMarker.on('dragend', function(event) {
                    const marker = event.target;
                    const position = marker.getLatLng();
                    inpStartLat.value = position.lat.toFixed(6);
                    inpStartLng.value = position.lng.toFixed(6);
                  });

                  // Nonaktifkan mode pemilihan titik
                  isSelectingStartPoint = false;
                  btnSetStart.classList.remove('btn-primary');
                  btnSetStart.classList.add('btn-outline-success');
                  btnSetStart.innerHTML = '<i class="bi bi-check-circle"></i> Titik Awal Dipilih';

                  // Setelah 2 detik, kembalikan tampilan tombol ke normal
                  setTimeout(() => {
                    btnSetStart.classList.remove('btn-outline-success');
                    btnSetStart.classList.add('btn-outline-primary');
                    btnSetStart.innerHTML = '<i class="bi bi-geo-alt"></i> Ubah Titik Awal';
                  }, 2000);
                }
              });
              layer.bindPopup(`<b>${district.name}</b>`);
            }
          });

          // Store reference to polygon
          kecamatanPolygons[district.name] = polygon;

          // Add to layer group
          kecamatanLayer.addLayer(polygon);
        }
      });

      // Add kecamatanLayer to map by default
      kecamatanLayer.addTo(map);

      // Make district layer checkbox checked by default
      document.getElementById('layerDistrict').checked = true;

      // District filter event listeners
      document.querySelectorAll('#districtFilters .filter-badge').forEach(btn => {
        btn.addEventListener('click', function() {
          // Toggle active class
          document.querySelectorAll('#districtFilters .filter-badge').forEach(el =>
            el.classList.remove('active'));
          this.classList.add('active');

          const selectedDistrict = this.getAttribute('data-district');
          filterByDistrict(selectedDistrict);
        });
      });

      // District search functionality
      document.getElementById('districtSearch').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const districtFilters = document.getElementById('districtFilters');

        // Clear previous filters
        districtFilters.innerHTML = '<span class="filter-badge" data-district="all">Semua</span>';

        // Filter and add matching districts
        const matchingDistricts = kecamatan.filter(kec =>
          kec.name.toLowerCase().includes(searchTerm)
        );

        matchingDistricts.forEach(kec => {
          const badge = document.createElement('span');
          badge.className = 'filter-badge';
          badge.setAttribute('data-district', kec.name);
          badge.textContent = kec.name;

          badge.addEventListener('click', function() {
            document.querySelectorAll('#districtFilters .filter-badge').forEach(el =>
              el.classList.remove('active'));
            this.classList.add('active');

            filterByDistrict(kec.name);
          });

          districtFilters.appendChild(badge);
        });

        // Make "All" active by default
        document.querySelector('#districtFilters .filter-badge[data-district="all"]').classList.add('active');
      });

      // Function to filter by district
      function filterByDistrict(district) {
        // Reset all district polygon styles
        Object.values(kecamatanPolygons).forEach(polygon => {
          polygon.setStyle({
            color: '#28a745',
            weight: 2,
            opacity: 0.6,
            fillColor: '#28a745',
            fillOpacity: 0.1
          });
        });

        if (district === 'all') {
          // Show all districts without highlighting
          document.getElementById('routeInfo').classList.add('d-none');

          // Keep all points visible
          startPointsLayer.clearLayers();
          wisataPointsLayer.clearLayers();

          // Re-add all start points
          pointStart.forEach(point => {
            const geo = JSON.parse(point.geojson);
            const coords = geo.coordinates;

            const marker = L.marker([coords[1], coords[0]], {
                icon: redIcon
              })
              .bindPopup(`<b>${point.name}</b><br>${point.alamat}`)
              .on('click', function() {
                startEl.setValue(point.id);

                if (wisataEl.virtualSelect.getValue()) {
                  showSelectedRoute();
                }
              });

            startPointsLayer.addLayer(marker);
          });

          // Re-add all wisata points
          pointWisata.forEach(point => {
            const geo = JSON.parse(point.geojson);
            const coords = geo.coordinates;

            const icon = getIconByCategory(point.category);

            const popupContent = `
                <div style="min-width: 180px;">
                  <h6 class="fw-bold text-success mb-1">${point.name}</h6>
                  <p class="mb-1">${point.desc}</p>
                  <p class="mb-1"><i class="bi bi-geo-alt-fill"></i> ${point.alamat}</p>
                  <p class="mb-0 small text-muted">Rating: ${point.rating}</p>
                </div>
              `;

            const marker = L.marker([coords[1], coords[0]], {
                icon: icon
              })
              .bindPopup(popupContent)
              .on('click', function() {
                wisataEl.setValue(point.id);

                if (startEl.virtualSelect.getValue()) {
                  showSelectedRoute();
                } else {
                  document.getElementById('touristInfo').innerHTML = `
                  <div style="min-width: 180px;">
                    <h6 class="fw-bold text-success mb-1">${point.name}</h6>
                    <p class="mb-1">${point.desc}</p>
                    <p class="mb-1"><i class="bi bi-geo-alt-fill"></i> ${point.alamat}</p>
                    <p class="mb-0 small text-muted">Rating: ${point.rating}</p>
                  </div>
                `;
                }
              });

            wisataPointsLayer.addLayer(marker);
          });

          // Reset map view
          map.setView([3.5952, 98.6722], 12);

          return;
        }

        // Highlight selected district polygon
        if (kecamatanPolygons[district]) {
          kecamatanPolygons[district].setStyle({
            color: '#fd7e14',
            weight: 3,
            opacity: 1,
            fillColor: '#fd7e14',
            fillOpacity: 0.2
          });

          // Zoom to the selected district
          map.fitBounds(kecamatanPolygons[district].getBounds());

          // Bring the highlighted polygon to front
          kecamatanPolygons[district].bringToFront();
        }

        // Keep all start points visible but filter wisata points to show only those in the selected district

        // Re-add all start points
        pointStart.forEach(point => {
          const geo = JSON.parse(point.geojson);
          const coords = geo.coordinates;

          const marker = L.marker([coords[1], coords[0]], {
              icon: redIcon
            })
            .bindPopup(`<b>${point.name}</b><br>${point.alamat}`)
            .on('click', function() {
              startEl.setValue(point.id);

              if (wisataEl.virtualSelect.getValue()) {
                showSelectedRoute();
              }
            });

          startPointsLayer.addLayer(marker);
        });

        // Filter and add wisata points in the selected district
        const filteredWisata = pointWisata.filter(point => point.kecamatan === district);

        filteredWisata.forEach(point => {
          const geo = JSON.parse(point.geojson);
          const coords = geo.coordinates;

          // Use icon based on category
          const icon = getIconByCategory(point.category);

          const marker = L.marker([coords[1], coords[0]], {
              icon: icon
            })
            .bindPopup(`<b>${point.name}</b><br>${point.desc}`)
            .on('click', function() {
              wisataEl.setValue(point.id);

              if (startEl.virtualSelect.getValue()) {
                showSelectedRoute();
              } else {
                document.getElementById('touristInfo').innerHTML = `
          <div style="min-width: 180px;">
                  <h6 class="fw-bold text-success mb-1">${point.name}</h6>
                  <p class="mb-1">${point.desc}</p>
                  <p class="mb-1"><i class="bi bi-geo-alt-fill"></i> ${point.alamat}</p>
                  <p class="mb-0 small text-muted">Rating: ${point.rating}</p>
                </div>
        `;
              }
            });

          wisataPointsLayer.addLayer(marker);
        });

        // Update the dropdown to only show wisata points in this district
        const wisataSelectContainer = document.querySelector('#wisata-select');
        wisataSelectContainer.innerHTML = '';

        if (wisataEl.virtualSelect && typeof wisataEl.virtualSelect.destroy === 'function') {
          wisataEl.virtualSelect.destroy();
        }

        VirtualSelect.init({
          ele: wisataSelectContainer,
          multiple: false,
          options: filteredWisata.map(point => ({
            label: point.name,
            value: point.id
          })),
          search: true,
        });

        wisataEl.virtualSelect = document.querySelector('#wisata-select').virtualSelect;
      }

      // Update the resetMap button to also reset district filters
      const originalResetMapListener = resetMapBtn.onclick;
      resetMapBtn.onclick = function() {
        // Reset district filter badges
        document.querySelectorAll('#districtFilters .filter-badge').forEach(function(el) {
          el.classList.remove('active');
        });
        document.querySelector('#districtFilters .filter-badge[data-district="all"]').classList.add('active');

        // Reset district polygons styles
        if (kecamatanPolygons) {
          Object.values(kecamatanPolygons).forEach(polygon => {
            polygon.setStyle({
              color: '#28a745',
              weight: 2,
              opacity: 0.6,
              fillColor: '#28a745',
              fillOpacity: 0.1
            });
          });
        }

        // Call the original reset function
        if (originalResetMapListener) {
          originalResetMapListener.call(this);
        }
      };

      // Layer control event listeners
      document.getElementById('layerOSM').addEventListener('change', function() {
        if (this.checked) {
          map.removeLayer(satelliteLayer);
          map.addLayer(osmLayer);
        }
      });

      document.getElementById('layerSatellite').addEventListener('change', function() {
        if (this.checked) {
          map.removeLayer(osmLayer);
          map.addLayer(satelliteLayer);
        }
      });

      document.getElementById('layerDistrict').addEventListener('change', function() {
        if (this.checked && kecamatanLayer) {
          kecamatanLayer.addTo(map);
        } else if (kecamatanLayer) {
          map.removeLayer(kecamatanLayer);
        }
      });

      // Clear all layers function
      function clearAllLayers() {
        wisataPointsLayer.clearLayers();
        routeLayer.clearLayers();
        if (currentRouting) {
          map.removeControl(currentRouting);
          currentRouting = null;
        }
      }

      // Show all markers function
      function showAllMarkers() {
        clearAllLayers();

        // Add start points to layer
        pointStart.forEach(point => {
          const geo = JSON.parse(point.geojson);
          const coords = geo.coordinates;

          const marker = L.marker([coords[1], coords[0]], {
              icon: redIcon
            })
            .bindPopup(`<b>${point.name}</b><br>${point.alamat}`)
            .on('click', function() {
              startEl.setValue(point.id);

              if (wisataEl.virtualSelect.getValue()) {
                showSelectedRoute();
              }
            });

          startPointsLayer.addLayer(marker);
        });

        // Add wisata points to layer with category-based icons
        pointWisata.forEach(point => {
          const geo = JSON.parse(point.geojson);
          const coords = geo.coordinates;

          const icon = getIconByCategory(point.category);

          const popupContent = `
                <div style="min-width: 180px;">
                  <h6 class="fw-bold text-success mb-1">${point.name}</h6>
                  <p class="mb-1">${point.desc}</p>
                  <p class="mb-1"><i class="bi bi-geo-alt-fill"></i> ${point.alamat}</p>
                  <p class="mb-0 small text-muted">Rating: ${point.rating}</p>
                </div>
              `;

          const marker = L.marker([coords[1], coords[0]], {
              icon: icon
            })
            .bindPopup(popupContent)
            .on('click', function() {
              wisataEl.setValue(point.id);

              if (startEl.virtualSelect.getValue()) {
                showSelectedRoute();
              } else {
                document.getElementById('touristInfo').innerHTML = `
        <div style="min-width: 180px;">
                  <h6 class="fw-bold text-success mb-1">${point.name}</h6>
                  <p class="mb-1">${point.desc}</p>
                  <p class="mb-1"><i class="bi bi-geo-alt-fill"></i> ${point.alamat}</p>
                  <p class="mb-0 small text-muted">Rating: ${point.rating}</p>
                </div>
        `;
              }
            });

          wisataPointsLayer.addLayer(marker);
        });

        // Reset the view and form elements
        map.setView([3.5952, 98.6722], 12);
        document.getElementById('touristInfo').innerHTML = defaultTouristInfo;
        startEl.virtualSelect.reset();
        wisataEl.virtualSelect.reset();
      }

      let isSelectingStartPoint = false;
      let selectedStartMarker = null;

      // Tambahkan event listener untuk tombol "Pilih Titik Awal"
      btnSetStart.addEventListener('click', function() {
        if (!isSelectingStartPoint) {
          // Aktifkan mode pemilihan titik awal
          isSelectingStartPoint = true;
          btnSetStart.classList.remove('btn-outline-primary');
          btnSetStart.classList.add('btn-primary');
          btnSetStart.innerHTML = '<i class="bi bi-geo-alt-fill"></i> Klik pada peta';

          // Ubah style polygon saat mode pemilihan aktif - highlight semua kecamatan
          Object.values(kecamatanPolygons).forEach(polygon => {
            polygon.setStyle({
              color: '#28a745',
              weight: 2,
              opacity: 0.8,
              fillColor: '#28a745',
              fillOpacity: 0.2,
              cursor: 'pointer'
            });
          });

          // Tampilkan instruksi kepada pengguna menggunakan SweetAlert toast
          Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'info',
            title: 'Silakan klik pada peta atau area kecamatan untuk menentukan titik awal',
            showConfirmButton: false,
            timer: 4000
          });
        } else {
          // Nonaktifkan mode pemilihan titik awal
          isSelectingStartPoint = false;
          btnSetStart.classList.remove('btn-primary');
          btnSetStart.classList.add('btn-outline-primary');
          btnSetStart.innerHTML = '<i class="bi bi-geo-alt"></i> Pilih Titik Awal';

          // Kembalikan style polygon ke normal
          Object.values(kecamatanPolygons).forEach(polygon => {
            polygon.setStyle({
              color: '#28a745',
              weight: 2,
              opacity: 0.6,
              fillColor: '#28a745',
              fillOpacity: 0.1,
              cursor: ''
            });
          });
        }
      });

      // Tambahkan event listener untuk klik pada peta
      map.on('click', function(e) {
        if (isSelectingStartPoint) {
          const lat = e.latlng.lat;
          const lng = e.latlng.lng;

          // Isi nilai input dengan koordinat yang dipilih
          inpStartLat.value = lat.toFixed(6);
          inpStartLng.value = lng.toFixed(6);

          // Hapus marker titik awal sebelumnya jika ada
          if (selectedStartMarker) {
            map.removeLayer(selectedStartMarker);
          }

          // Tambahkan marker baru pada posisi yang dipilih
          selectedStartMarker = L.marker([lat, lng], {
            icon: selfIcon,
            draggable: true // Memungkinkan marker dapat di-drag untuk penyesuaian
          }).addTo(map);

          // Event ketika marker di-drag
          selectedStartMarker.on('dragend', function(event) {
            const marker = event.target;
            const position = marker.getLatLng();
            inpStartLat.value = position.lat.toFixed(6);
            inpStartLng.value = position.lng.toFixed(6);
          });

          // Nonaktifkan mode pemilihan titik
          isSelectingStartPoint = false;
          btnSetStart.classList.remove('btn-primary');
          btnSetStart.classList.add('btn-outline-success');
          btnSetStart.innerHTML = '<i class="bi bi-check-circle"></i> Titik Awal Dipilih';

          // Setelah 2 detik, kembalikan tampilan tombol ke normal
          setTimeout(() => {
            btnSetStart.classList.remove('btn-outline-success');
            btnSetStart.classList.add('btn-outline-primary');
            btnSetStart.innerHTML = '<i class="bi bi-geo-alt"></i> Ubah Titik Awal';
          }, 2000);
        }
      });

      // Show selected route function
      function showSelectedRoute() {
        clearAllLayers();
        startPointsLayer.clearLayers();

        let startLat, startLng, startInfo;
        const wisataId = wisataEl.virtualSelect.getValue();

        // Check if using dropdown mode or map click
        if (modeDropdown.checked) {
          // Dropdown mode - use starting point from dropdown
          const startId = startEl.virtualSelect.getValue();
          const start = pointStart.find(p => p.id == startId);

          if (!start) {
            Swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'warning',
              title: 'Silakan pilih titik awal',
              showConfirmButton: false,
              timer: 3000
            });
            return;
          }

          const startCoords = JSON.parse(start.geojson).coordinates;
          startLat = startCoords[1];
          startLng = startCoords[0];
          startInfo = `<b>${start.name}</b><br>${start.alamat}`;
        } else {
          // Map click mode - use starting point from lat/lng inputs
          startLat = parseFloat(inpStartLat.value);
          startLng = parseFloat(inpStartLng.value);

          if (isNaN(startLat) || isNaN(startLng)) {
            Swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'warning',
              title: 'Silakan pilih titik awal dengan mengklik pada peta',
              showConfirmButton: false,
              timer: 3000
            });
            return;
          }

          startInfo = `<b>Lokasi Pilihan</b><br>Lat: ${startLat.toFixed(6)}, Lng: ${startLng.toFixed(6)}`;
        }

        const wisata = pointWisata.find(p => p.id == wisataId);

        if (!wisata) {
          Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'warning',
            title: 'Silakan pilih lokasi wisata',
            showConfirmButton: false,
            timer: 3000
          });
          return;
        }

        const wisataCoords = JSON.parse(wisata.geojson).coordinates;
        const selectedStartCoords = [startLat, startLng];
        const selectedWisataCoords = [wisataCoords[1], wisataCoords[0]];

        // Show loading indicator
        document.getElementById('loading').classList.remove('d-none');

        // Add markers to route layer
        const startMarker = L.marker(selectedStartCoords, {
          icon: redIcon
        }).bindPopup(startInfo);

        const popupContent = `
          <div style="min-width: 180px;">
                  <h6 class="fw-bold text-success mb-1">${wisata.name}</h6>
                  <p class="mb-1">${wisata.desc}</p>
                  <p class="mb-1"><i class="bi bi-geo-alt-fill"></i> ${wisata.alamat}</p>
                  <p class="mb-0 small text-muted">Rating: ${wisata.rating}</p>
                </div>
        `;

        // Use category-based icon for destination marker
        const wisataIcon = getIconByCategory(wisata.category);
        const wisataMarker = L.marker(selectedWisataCoords, {
          icon: wisataIcon
        }).bindPopup(popupContent);

        routeLayer.addLayer(startMarker);
        routeLayer.addLayer(wisataMarker);

        // For dropdown mode, we can use the existing route from database
        if (modeDropdown.checked) {
          const startId = startEl.virtualSelect.getValue();
          const fetchJalur = `/peta/jalur/${startId}/${wisataId}`;

          fetch(fetchJalur, {
              method: 'GET',
            })
            .then(res => res.json())
            .then(data => {
              const geojsonFeature = {
                type: 'Feature',
                geometry: data.geom
              };

              const geoLayer = L.geoJSON(geojsonFeature, {
                style: {
                  color: '#007bff',
                  weight: 4,
                  opacity: 0.9
                }
              });

              geoLayer.addTo(routeLayer);

              const bounds = L.latLngBounds([selectedStartCoords, selectedWisataCoords]);
              map.fitBounds(bounds, {
                padding: [70, 70]
              });

              // Hide loading indicator
              document.getElementById('loading').classList.add('d-none');

              // Calculate duration based on the fixed speed (40 km/h)
              let distanceKm = data.panjang_km || 0;

              // Jika tidak ada data dari backend, pakai haversine
              if (!distanceKm) {
                const startLatLng = L.latLng(selectedStartCoords[0], selectedStartCoords[1]);
                const endLatLng = L.latLng(selectedWisataCoords[0], selectedWisataCoords[1]);
                const distance = startLatLng.distanceTo(endLatLng); // dalam meter
                distanceKm = distance / 1000;
              }

              // Hitung durasi (waktu tempuh) berdasarkan kecepatan tetap
              const duration = calculateDuration(distanceKm * 1000); // masukkan meter

              // Tampilkan info jalur
              document.getElementById('routeDistance').textContent = `Jarak: ${distanceKm.toFixed(2)} km`;
              document.getElementById('routeDuration').textContent =
                `Waktu Tempuh: ${formatDuration(duration)} (40 km/jam)`;
              document.getElementById('routeInfo').classList.remove('d-none');
            })
            .catch(error => {
              document.getElementById('loading').classList.add('d-none');

              // Show toast for error
              Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'Gagal memuat jalur, menggunakan alternatif',
                showConfirmButton: false,
                timer: 3000
              });

              // If failed, use Leaflet Routing Machine as fallback
              useRoutingMachine(selectedStartCoords, selectedWisataCoords);
            });
        } else {
          // For map click mode, use Leaflet Routing Machine
          useRoutingMachine(selectedStartCoords, selectedWisataCoords);
        }

        document.getElementById('touristInfo').innerHTML = `
        <h6 class="fw-bold mb-1 text-success">${wisata.name}</h6>
        <p class="mb-0 small">${wisata.desc}</p>
      `;
      }

      // Function to calculate duration based on distance and fixed speed (40 km/h)
      function calculateDuration(distanceInMeters) {
        const speedKmPerHour = 40; // Fixed speed: 40 km/h
        const speedMeterPerSecond = speedKmPerHour * 1000 / 3600; // Convert to m/s
        const durationInSeconds = distanceInMeters / speedMeterPerSecond;
        return durationInSeconds;
      }

      // Format duration in a more readable way (hours, minutes)
      function formatDuration(seconds) {
        const hours = Math.floor(seconds / 3600);
        const minutes = Math.floor((seconds % 3600) / 60);

        if (hours > 0) {
          return `${hours} jam ${minutes} menit`;
        } else {
          return `${minutes} menit`;
        }
      }


      let currentRouting = null;
      // Fungsi untuk menggunakan Leaflet Routing Machine
      function useRoutingMachine(startCoords, destCoords) {
        // Remove old routing if exists
        if (currentRouting) {
          map.removeControl(currentRouting);
          currentRouting = null;
        }

        // Create new route
        currentRouting = L.Routing.control({
          waypoints: [
            L.latLng(startCoords[0], startCoords[1]),
            L.latLng(destCoords[0], destCoords[1])
          ],
          routeWhileDragging: false,
          addWaypoints: false,
          showAlternatives: false,
          fitSelectedRoutes: true,
          lineOptions: {
            styles: [{
              color: '#007bff',
              opacity: 0.9,
              weight: 4
            }]
          },
          createMarker: function() {
            return null;
          },
          show: false,
          collapsible: true,
          containerClassName: 'd-none'
        }).addTo(map);

        // When route is found
        currentRouting.on('routesfound', function(e) {
          const routes = e.routes;
          const summary = routes[0].summary;
          const distance = summary.totalDistance;

          // Calculate duration using our fixed speed instead of the routing engine's estimate
          const duration = calculateDuration(distance);

          // Display route info
          document.getElementById('routeDistance').textContent = `Jarak: ${(distance / 1000).toFixed(2)} km`;
          document.getElementById('routeDuration').textContent =
            `Waktu Tempuh: ${formatDuration(duration)} (40 km/jam)`;
          document.getElementById('routeInfo').classList.remove('d-none');

          // Hide loading indicator
          document.getElementById('loading').classList.add('d-none');
        });
      }

      // Show wisata by category function
      function showWisataByCategory(category) {
        clearAllLayers();
        startPointsLayer.clearLayers();
        startEl.reset();
        wisataEl.reset();

        pointStart.forEach(point => {
          const geo = JSON.parse(point.geojson);
          const coords = geo.coordinates;

          const marker = L.marker([coords[1], coords[0]], {
              icon: redIcon
            })
            .bindPopup(`<b>${point.name}</b><br>${point.alamat}`)
            .on('click', function() {
              startEl.setValue(point.id);

              if (wisataEl.virtualSelect.getValue()) {
                showSelectedRoute();
              }
            });

          startPointsLayer.addLayer(marker);
        });

        // Filter wisata points by category or show all
        const filtered = category === 'all' ?
          pointWisata :
          pointWisata.filter(w => `wisata-${w.category}` === category);

        const markerCoords = [];

        // Add filtered wisata points to layer with category-based icons
        filtered.forEach(point => {
          const geo = JSON.parse(point.geojson);
          const coords = geo.coordinates;

          const latLng = [coords[1], coords[0]];
          markerCoords.push(latLng);

          const icon = getIconByCategory(point.category);

          const popupContent = `
                <div style="min-width: 180px;">
                  <h6 class="fw-bold text-success mb-1">${point.name}</h6>
                  <p class="mb-1">${point.desc}</p>
                  <p class="mb-1"><i class="bi bi-geo-alt-fill"></i> ${point.alamat}</p>
                  <p class="mb-0 small text-muted">Rating: ${point.rating}</p>
                </div>
              `;

          const marker = L.marker(latLng, {
              icon: icon
            })
            .bindPopup(popupContent)
            .on('click', function() {
              wisataEl.setValue(point.id);

              if (startEl.virtualSelect.getValue()) {
                showSelectedRoute();
              } else {
                document.getElementById('touristInfo').innerHTML = `
          <div style="min-width: 180px;">
                  <h6 class="fw-bold text-success mb-1">${point.name}</h6>
                  <p class="mb-1">${point.desc}</p>
                  <p class="mb-1"><i class="bi bi-geo-alt-fill"></i> ${point.alamat}</p>
                  <p class="mb-0 small text-muted">Rating: ${point.rating}</p>
                </div>
        `;
              }
            });

          wisataPointsLayer.addLayer(marker);
        });


        if (markerCoords.length > 0) {
          const bounds = L.latLngBounds(markerCoords);
          map.fitBounds(bounds, {
            padding: [50, 50],
            maxZoom: 15
          });
        }

        const wisataSelectContainer = document.querySelector('#wisata-select');
        wisataSelectContainer.innerHTML = '';

        if (wisataEl.virtualSelect && typeof wisataEl.virtualSelect.destroy === 'function') {
          wisataEl.virtualSelect.destroy();
        }

        VirtualSelect.init({
          ele: wisataSelectContainer,
          multiple: false,
          options: filtered.map(point => ({
            label: point.name,
            value: point.id
          })),
          search: true,
        });

        wisataEl.virtualSelect = document.querySelector('#wisata-select').virtualSelect;
      }

      // Tambahkan legend/legenda untuk menampilkan keterangan icon kategori
      function addLegend() {
        const legend = L.control({
          position: 'bottomright'
        });

        legend.onAdd = function(map) {
          const div = L.DomUtil.create('div', 'info legend');
          div.style.backgroundColor = 'white';
          div.style.padding = '10px';
          div.style.borderRadius = '5px';
          div.style.boxShadow = '0 1px 5px rgba(0,0,0,0.2)';

          div.innerHTML = '<h6 class="mb-2"><b>Legenda</b></h6>';

          div.innerHTML +=
            '<div><img src="{{ asset('assets/img/legends/halte.png') }}" width="16" height="16"> Titik Awal</div>';

          // Kumpulkan kategori unik dari data
          const uniqueCategories = [];
          pointWisata.forEach(point => {
            if (point.category && !uniqueCategories.includes(point.category)) {
              uniqueCategories.push(point.category);
            }
          });

          // Tambahkan keterangan untuk masing-masing kategori unik
          uniqueCategories.forEach(category => {
            // Dapatkan URL ikon untuk kategori ini
            const iconUrl = categoryIconMap[category] || categoryIconMap.default;
            div.innerHTML += `<div><img src="${iconUrl}" width="16" height="16"> ${category}</div>`;
          });

          return div;
        };

        legend.addTo(map);
      }

      // Event listeners
      document.getElementById('findRoute').addEventListener('click', showSelectedRoute);
      document.getElementById('resetMap').addEventListener('click', showAllMarkers);
      document.getElementById('resetMap').addEventListener('click', function() {
        document.querySelectorAll('.filter-badge').forEach(function(el) {
          el.classList.remove('active');
        });
        document.querySelector('.filter-badge[data-category="all"]').classList.add('active');
        showWisataByCategory('all');
      });


      // Category filter event listeners
      document.querySelectorAll('#categoryFilters .filter-badge').forEach(btn => {
        btn.addEventListener('click', function() {
          // Toggle active class
          document.querySelectorAll('#categoryFilters .filter-badge').forEach(el =>
            el.classList.remove('active'));
          this.classList.add('active');

          const selectedCategory = this.getAttribute('data-category');
          showWisataByCategory(selectedCategory);
        });
      });

      // Fullscreen toggle
      let isFullscreen = false;
      const mapContainer = document.querySelector('.map-container');
      const fullscreenControl = document.getElementById('fullscreenControl');

      fullscreenControl.addEventListener('click', function() {
        if (!isFullscreen) {
          // Enter fullscreen
          mapContainer.style.position = 'fixed';
          mapContainer.style.top = '3rem';
          mapContainer.style.left = '0';
          mapContainer.style.height = '90vh';
          mapContainer.style.zIndex = '9999';
          mapContainer.style.borderRadius = '0';
          fullscreenControl.querySelector('i').classList.remove('bi-arrows-fullscreen');
          fullscreenControl.querySelector('i').classList.add('bi-fullscreen-exit');
          document.body.style.overflow = 'hidden';
          isFullscreen = true;
        } else {
          // Exit fullscreen
          mapContainer.style.position = 'relative';
          mapContainer.style.top = 'auto';
          mapContainer.style.left = 'auto';
          mapContainer.style.width = '100%';
          mapContainer.style.height = '90vh';
          mapContainer.style.zIndex = '1';
          mapContainer.style.borderRadius = '12px';
          fullscreenControl.querySelector('i').classList.remove('bi-fullscreen-exit');
          fullscreenControl.querySelector('i').classList.add('bi-arrows-fullscreen');
          document.body.style.overflow = 'auto';
          isFullscreen = false;
        }

        // Trigger resize event to update map
        setTimeout(() => {
          window.dispatchEvent(new Event('resize'));
          map.invalidateSize();
        }, 100);
      });

      resetMapBtn.addEventListener('click', function() {
        if (selectedStartMarker) {
          map.removeLayer(selectedStartMarker);
          selectedStartMarker = null;
        }

        inpStartLat.value = '';
        inpStartLng.value = '';
        btnSetStart.classList.remove('btn-outline-success', 'btn-primary');
        btnSetStart.classList.add('btn-outline-primary');
        btnSetStart.innerHTML = '<i class="bi bi-geo-alt"></i> Pilih Titik Awal';

        // Kembalikan style polygon ke normal
        isSelectingStartPoint = false;
        Object.values(kecamatanPolygons).forEach(polygon => {
          polygon.setStyle({
            color: '#28a745',
            weight: 2,
            opacity: 0.6,
            fillColor: '#28a745',
            fillOpacity: 0.1,
            cursor: ''
          });
        });

        document.getElementById('routeInfo').classList.add('d-none');

        showAllMarkers();
      });

      showAllMarkers();
      addLegend();
    }
  </script>
@endpush
